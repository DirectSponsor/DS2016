<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Collection;
use App\Models\ProjectMember;

class RecipientMember extends ProjectMember
{
    /*
     * Direct Relationships
     */
    public function sponsors() {
        return $this->hasMany('App\Models\SponsoredRecipient', 'recipient_member_id');
    }

    public function receipts() {
        return $this->hasMany('App\Models\Receipt', 'project_member_id');
    }

    /*
     * Derived Relationships
     */


    /*
     * Recipient Methods
     */

    public function receiptsConfirmed() {
        $receipts = new Collection();
        foreach($this->receipts as $receipt) {
            if ($receipt->status == 'Confirmed') {
                $receipts->add($receipt);
            }
        }
        return $receipts;
    }

    public function receiptsDue() {
        $receipts = new Collection();
        foreach($this->receipts as $receipt) {
            if ($receipt->status != 'Confirmed') {
                $receipts->add($receipt);
            }
        }
        return $receipts;
    }

    public function getCurrentSupport() {
        $currentSupport = $this->sponsors()->sum('euro_amount_promised');
        if (is_numeric($currentSupport)) {
            return $currentSupport;
        } else {
            return 0;
        }
    }

    public function getMaxSupportAllowed() {
        $maxSupportAlowed = $this->project->max_euro_amount_per_recipient;
        if (is_numeric($maxSupportAlowed)) {
            return $maxSupportAlowed;
        } else {
            return 0;
        }
    }

    public function getSupportRequired() {
        return ($this->getMaxSupportAllowed() - $this->getCurrentSupport());
    }


}
