<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\DirectSponsorBaseModel;
use App\Models\UserRole;
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

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /*
     * Relationships
     */

    public function projectMembers() {
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
        $coordinator = $this->projectMembers()
                ->join('user_roles', 'project_members.user_roles_id', '=', 'user_roles.id')
                ->where('user_roles.role_type', '=', 'Coordinator')
                ->first();
        return $coordinator;
    }

    public function recipients() {
        $recipients = $this->projectMembers()
                ->join('user_roles', 'project_members.user_roles_id', '=', 'user_roles.id')
                ->where('user_roles.role_type', '=', 'Recipient')
                ->get();
        return $recipients;
    }

    public function sponsors() {
        $sponsors = $this->projectMembers()
                ->join('user_roles', 'project_members.user_roles_id', '=', 'user_roles.id')
                ->where('user_roles.role_type', '=', 'Sponsor')
                ->get();
        return $sponsors;
    }

    public function payments() {
        $payments = $this->transactions()
                ->where('trans_type', 'Receipt')
                ->get();
        return $payments;
    }

    public function fundReceipts() {
        $receipts = $this->transactions()
                ->where('trans_type', 'Fund Receipt')
                ->get();
        return $receipts;
    }

    public function spends() {
        $spends = $this->transactions()
                ->where('trans_type', 'Fund Expense')
                ->get();
        return $spends;
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
                    ->sum('euro_amount_promised');
            if ($sumPromises <= 0) {
                return $recipient;
            }
            if (($sumPromises < $this->max_euro_amount_per_recipient) and
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
            if(!$recipient->userRole->user->registered){
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
    public function saveProject(Request $request) {
        DB::transaction(function() use($request) {
            $this->fill($request->all());
            $this->url = str_replace(" ", "_", strtolower(e($request->input('name'))));
            if (!isset($this->status)) {
                $this->status = 'Building Budget';
            }
            $this->save();
        });
        return $this;
    }

    public function addMemberToProject(UserRole $userRole) {
        $projectMember = new ProjectMember;
        $projectMember->user_role_id = $userRole->id;
        $projectMember->member_status = 'Active';
        $this->projectMembers()->associate($projectMember);

        $this->save();
        return $this;
    }

}
