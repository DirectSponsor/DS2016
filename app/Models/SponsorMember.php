<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Collection;
use App\Models\ProjectMember;
use App\Models\RecipientMember;


class SponsorMember extends ProjectMember
{
    /*
     * Direct Relationships
     */
    public function sponsoredRecipients() {
        return $this->hasMany('App\Models\SponsoredRecipient', 'project_member_id');
    }

    public function payments() {
        return $this->hasMany('App\Models\Receipt', 'sender_member_id');
    }

    /*
     * Derived Relationships
     */


    /*
     * Sponsor Methods
     */

    public function paymentsConfirmed() {
        $payments = new Collection();
        foreach($this->payments as $payment) {
            if ($payment->status == 'Confirmed') {
                $payments->add($payment);
            }
        }
        return $payments;
    }

    public function receiptsDue() {
        $receipts = new Collection();
        foreach($this->payments as $receipt) {
            if ($receipt->status != 'Confirmed') {
                $receipts->add($receipt);
            }
        }
        return $receipts;
    }

    public function getCommittedTotal() {
        return $this->sponsoredRecipients->sum('euro_amount_promised');
    }

    public function isAlreadySponsoringRecipient(ProjectMember $recipientMember) {
        return $this->sponsoredRecipients()
                ->where('recipient_member_id', $recipientMember->id)
                ->first();
    }
}
