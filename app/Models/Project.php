<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\DirectSponsorBaseModel;
use App\Models\Role;
use App\Models\ProjectMember;
use App\Models\SponsoredRecipient;

class Project extends DirectSponsorBaseModel {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'projects';

    protected $guarded = array();

    protected $fillable = array('name','content','max_recipients','max_sponsors_per_recipient','currency','amount','euro_amount','gf_commission');

    /*
     * Relationships
     */

    public function members() {
        return $this->hasMany('App\Models\ProjectMember');
    }

    public function transactions() {
        return $this->hasManyThrough('App\Models\Transaction', 'App\Models\ProjectMember');
    }

    public function invitations() {
        return $this->hasMany("App\Models\Invitation");
    }

    /*
     * Derived Relationships
     */

    public function coordinator() {
        $coordinator = $this->members
                ->join('roles', 'project_members.role_id', '=', 'roles.id')
                ->where('roles.desciptor', '=', 'Coordinator')
                ->first();
        return $coordinator;
    }

    public function recipients() {
        $recipients = $this->members
                ->join('roles', 'project_members.role_id', '=', 'roles.id')
                ->where('roles.desciptor', '=', 'Recipient')
                ->get();
        return $recipients;
    }

    public function sponsors() {
        $sponsors = $this->members
                ->join('roles', 'project_members.role_id', '=', 'roles.id')
                ->where('roles.desciptor', '=', 'Sponsor')
                ->get();
        return $sponsors;
    }

    public function payments() {
        $payments = $this->transactions->whereHas('transtype', function ($query) {
            $query->where('descriptor', '=', 'Payment');
        })->get();
        return $payments;
    }

    public function fundReceipts() {
        $receipts = $this->transactions->whereHas('transtype', function ($query) {
            $query->where('descriptor', '=', 'Receipt Fund');
        })->get();
        return $receipts;
    }

    public function spends() {
        $spends = $this->transactions->whereHas('transtype', function ($query) {
            $query->where('descriptor', '=', 'Spend Fund');
        })->get();
        return $spends;
    }

    public function paymentsOfSponsor($sid){
        return $this->sponsors()->where('user_id', $sid)->paymentsOfProject($this->id);
    }

    public function recipientOfSponsor($sid){
        return $this->sponsors()->where('sponsor_id', $sid)->first()->recipientOfProject($this->id);
    }

    public function confirmedPaymentsOfSponsor($sid){
        return $this->paymentsOfSponsor($sid)->where('stat','like','accepted%');
    }

    public function confirmedRecipients() {
        return $this->recipients()
                ->where('confirmed', 1)
                ->count();
    }

    /**
     * Find a Confirmed Recipient who has not been allocated the max number of sponsors.
     *
     * @return boolean | ProjectMember
     */
    public function getFreeRecipient(){
        $selectedRecipient = null;
        $selectedRecipient_sumPromises = 9999;

        foreach ($this->recipients as $recipient){
            if(!$recipient->user->confirmed){
                continue;
            }
            $sumPromises = SponsoredRecipient::where('recipient_member_id', '=', $recipient->id)
                    ->sum('promised_amount');
            if ($sumPromises <= 0) {
                return $recipient;
            }
            if (($sumPromises < $this->max_amount_per_recipient) and
                ($sumPromises < $selectedRecipient_sumPromises)) {
                $selectedRecipient = $recipient;
                $selectedRecipient_sumPromises = $sumPromises;
                continue;
            }
        }
        if ($selectedRecipient != null) {
            return $selectedRecipient;
        } else {
            return false;
        }
    }

    public function isFullySubscribedWithRecipients(){
        if (!$this->open) {
            return true;
        }
        $countConfirmedRecipients = 0;
        foreach ($this->recipients as $recipient){
            if(!$recipient->user->confirmed){
                continue;
            }
            $countConfirmedRecipients++;
        }
        if ($countConfirmedRecipients >= $this->max_recipients) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *
     * @param Request $request
     * @return \App\Models\Project
     */
    public function validateCreateProjectData(Request $request) {
        /*
         * Validate request inputs
         */
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|unique:projects',
            'max_recipients' => 'required|numeric',
            'max_sponsors_per_recipient' => 'required|numeric',
            'max_recipients_per_sponsor' => 'required|numeric',
            'currency' => 'required',
            'amount' => 'required|numeric',
            'euro_amount' => 'required|numeric',
            'recipient_amount_local_currency' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return $validator;
        } else {
            return $this;
        }
    }

    /**
     *
     * @param Request $request
     * @return \App\Models\Project
     */
    public function setupProject(Request $request) {
        DB::transaction(function() use($request) {
            $user = new User;
            $user->createNewUser($request->all(), 'Coordinator');
            $coordinator = new Coordinator();
            $coordinator->user()->associate($user);

            $this->fill($request->all());
            $this->url = str_replace(" ", "_", strtolower(e($request->input('name'))));
            $this->open = true;
            $this->save();

            $coordinator->project()->associate($this);
            $coordinator->save();
        });
        return $this;
    }

    public function validateEditProjectData(Request $request) {
        /*
         * Validate request inputs
         */
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|unique:projects,id,'.$this->id,
            'max_recipients' => 'required|numeric',
            'max_sponsors_per_recipient' => 'required|numeric',
            'max_recipients_per_sponsor' => 'required|numeric',
            'currency' => 'required',
            'amount' => 'required|numeric',
            'euro_amount' => 'required|numeric',
            'recipient_amount_local_currency' => 'required|numeric'
            ]);

        if ($validator->fails()) {
            return $validator;
        } else {
            return $this;
        }
    }

    public function updateProject(Request $request) {
        $this->fill($request->all());
        $this->url = str_replace(" ", "_", strtolower(e($this->name)));
        $this->save();
        return $this;
    }

}
