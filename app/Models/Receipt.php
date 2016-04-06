<?php

namespace app\Models;

use App\Models\Transaction;


class Receipt extends Transaction
{
    /*
     * Relationships
     */
    public function recipient() {
        return $this->belongsTo("App\Models\RecipientMember", "project_member_id");
    }

    /*
     * Derived Relationships
     */

    /*
     * Recipient Methods
     */

    public function overduePayment() {
        if ($this->status != 'Pending') {
            return false;
        }
        if ($this->due_date->isPast() and ($this->due_date->diffInDays() >=5)) {
            return true;
        } else {
            return false;
        }
    }

    public function setStatusLate() {
        $this->status = 'Late';
        $this->save();

        $emailTemplate = 'emails.sponsors.no_payment';
        $subject = 'Reminder: Monthly payment is overdue';
        $this->getMailer()->sendEmailReminderToSponsor($this, $emailTemplate, $subject);
        return true;
    }

    public function setStatusConfirmed() {
        $this->status = 'Confirmed';
        $this->save();
        return $this;
    }

}
