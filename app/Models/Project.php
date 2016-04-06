<?php

namespace app\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
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
    protected $table = 'project';

    protected $guarded = array();

    protected $fillable = array(
        'name','status','local_currency','local_currency_symbol','initial_target_budget',
        'max_recipients', 'max_sponsors',
        'currency_conversion_factor',
        'min_local_amount_per_recipient','min_local_amount_retained_recipient',
        'max_local_amount_per_recipient',
        'min_euro_amount_per_recipient', 'max_euro_amount_per_recipient',
        'description'
        );

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

    public function coordinator() {
        return $this->hasMany('App\Models\CoordinatorMember');
    }

    public function recipients() {
        return $this->hasMany('App\Models\RecipientMember');
    }

    public function sponsors() {
        return $this->hasMany('App\Models\SponsorMember');
    }

    public function invitations() {
        return $this->hasMany("App\Models\Invitation");
    }

    /*
     * Override Setters
     */
    public function setMaxRecipientsAttribute($value) {
        $this->attributes['max_recipients'] = floor($value);
        return $this;
    }

    public function setMaxSponsorsAttribute($value) {
        $this->attributes['max_sponsors'] = floor($value);
        return $this;
    }

    /*
     * Derived Relationships
     */
    public function getCoordinator($activeOnly=true) {
        $collection = $this->coordinator;
        $filteredCollection = $collection->filter( function($projectMember) use($activeOnly) {
            if ($activeOnly and ($projectMember->isActive() == false)) {
                return false;
            }
            if ($projectMember->userRole->isCoordinator()) {
                return true;
            }
        });
        if ($activeOnly) {
            return $filteredCollection->first();
        } else {
            return $filteredCollection;
        }
    }

    public function getRecipients($activeOnly=true) {
        $collection = $this->recipients;
        $filteredCollection = $collection->filter( function($projectMember) use($activeOnly) {
            if ($activeOnly and ($projectMember->isActive() == false)) {
                return false;
            }
            if ($projectMember->userRole->isRecipient()) {
                return true;
            } else {
                return false;
            }
        });
        return $filteredCollection;
    }

    public function getSponsors($activeOnly=true) {
        $collection = $this->sponsors;
        $filteredCollection = $collection->filter( function($projectMember) use($activeOnly) {
            if ($activeOnly and ($projectMember->isActive() == false)) {
                return false;
            }
            if ($projectMember->userRole->isSponsor()) {
                return true;
            }
        });
        return $filteredCollection;
    }

    public function getPayments() {
        $payments = new Collection();
        foreach($this->getRecipients(false) as $recipient) {
            foreach($recipient->receiptsConfirmed() as $receipt) {
                $payments->add($receipt);
            }
        }
        return $payments;
    }

    public function getPaymentsDue() {
        $payments = new Collection();
        $coordinators = $this->getCoordinator(false);
        if ($coordinators) {
            foreach($coordinators as $coordinator) {
                foreach($coordinator->receiptsDue() as $receipt) {
                    $payments->add($receipt);
                }
            }
        }
        foreach($this->getRecipients(true) as $recipient) {
            foreach($recipient->receiptsDue() as $receipt) {
                $payments->add($receipt);
            }
        }
        return $payments;
    }

    public function getFundReceipts() {
        $receipts = new Collection();
        foreach($this->getCoordinator(false) as $coordinator) {
            foreach($coordinator->receipts as $receipt) {
                $receipts->add($receipt);
            }
        }
        return $receipts;
    }

    public function getSpends() {
        $expenses = new Collection();
        foreach($this->getCoordinator(false) as $coordinator) {
            foreach($coordinator->expenses as $expense) {
                $expenses->add($expense);
            }
        }
        return $expenses;
    }

    /*
     * Project Methods
     */

    public function isMemberOfProject(UserRole $userRole) {
        $members = $this->projectMembers()->filter( function($member) use($userRole) {
            if ($member->userRole->id == $userRole->id) {
                return $member;
            }
        });
        if ($members->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getMaxRecipients() {
        if (is_numeric($this->max_recipients)) {
            return $this->max_recipients;
        } else {
            return 0;
        }
    }

    public function getMaxSponsors() {
        if (is_numeric($this->max_sponsors)) {
            return $this->max_sponsors;
        } else {
            return 0;
        }
    }

    public function getMaxEuroAmountPerRecipient() {
        if (is_numeric($this->max_euro_amount_per_recipient)) {
            return $this->max_euro_amount_per_recipient;
        } else {
            return 0;
        }
    }

    public function getMinEuroAmountPerRecipient() {
        if (is_numeric($this->min_euro_amount_per_recipient)) {
            return $this->min_euro_amount_per_recipient;
        } else {
            return 0;
        }
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

    public function fillFromRequest(Request $request) {
        $this->fill($request->all());
        $this->url = str_replace(" ", "_", strtolower(e($request->input('name'))));
        return $this;
    }

    /**
     *
     * @param Request $request
     * @return \App\Models\Project
     */
    public function save(array $options=array()) {
        DB::transaction(function() use($options) {
            if (!isset($this->status)) {
                $this->status = 'Building Budget';
            }
            $this->calculateAmounts();
            parent::save($options);
        });
        return $this;
    }

    private function calculateAmounts() {
        if (is_null($this->currency_conversion_factor)) {
            $this->currency_conversion_factor = 0;
        } elseif (!is_numeric($this->currency_conversion_factor)) {
            $this->currency_conversion_factor = 0;
        }

        if (is_null($this->min_euro_amount_per_recipient)) {
            $this->min_euro_amount_per_recipient = 0;
        } elseif (!is_numeric($this->min_euro_amount_per_recipient)) {
            $this->min_euro_amount_per_recipient = 0;
        }

        if (is_null($this->max_sponsors)) {
            $this->max_sponsors = 0;
        } elseif (!is_numeric($this->max_sponsors)) {
            $this->max_sponsors = 0;
        }

        $this->max_euro_amount_per_recipient
                = $this->min_euro_amount_per_recipient * (int) $this->max_sponsors;
        $this->min_local_amount_per_recipient
                = $this->min_euro_amount_per_recipient * $this->currency_conversion_factor;
        $this->max_local_amount_per_recipient
                = $this->max_euro_amount_per_recipient * $this->currency_conversion_factor;

        return $this;
    }

    public function addMemberToProject(UserRole $userRole) {
        $projectMember = new ProjectMember;
        $projectMember->user_role_id = $userRole->id;
        $projectMember->status = 'Active';
        $this->projectMembers()->save($projectMember);

        return $projectMember->castMemberRole();
    }

    public function isFullySupported() {
        if (isset($this->isFullySupportedIndic)) {
            return $this->isFullySupportedIndic;
        }
        $maxSupportAllowed = ($this->getMaxRecipients() * $this->getMaxEuroAmountPerRecipient());
        $currentSupport = 0;
        foreach($this->getSponsors(true) as $sponsorMember) {
            $currentSupport += $sponsorMember->getCommittedTotal();
        }
        if ($currentSupport >= $maxSupportAllowed) {
            $this->isFullySupportedIndic = true;
        } else {
            $diff = $maxSupportAllowed - $currentSupport;
            if ($diff >= $this->getMinEuroAmountPerRecipient()) {
                $this->isFullySupportedIndic = false;
            } else {
                $this->isFullySupportedIndic = true;
            }
        }
        return $this->isFullySupportedIndic;
    }
}
