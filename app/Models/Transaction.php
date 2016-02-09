<?php

namespace app\Models;

use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\DirectSponsorBaseModel;

use App\Models\User;
use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\SponsoredRecipient;
use App\Models\MailerDS as Mailer;


class Transaction extends DirectSponsorBaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'transactions';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'due_date',
        'created_at',
        'updated_at'
    ];

    protected $guarded = array();
    public static $rules = array();

    protected $mailer;

    /*
     * Relationships
     */
    public function projectMember() {
        return $this->belongsTo("App\Models\ProjectMember");
    }

    public function sender() {
        return $this->belongsTo("App\Models\ProjectMember", "sender_member_id");
    }

    /*
     * Derived Relationships
     */
    public function project() {
        return $this->projectMembers()->first()->project;
    }

    public function overduePayment() {
        if ($this->trans_type != 'Receipt') {
            return false;
        }
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

    public function initialiseFirstSponsorProjectPayment(ProjectMember $sponsor, ProjectMember $recipient, SponsoredRecipient $sponsoredRecipient) {
        DB::transaction(function() use($sponsor, $recipient, $sponsoredRecipient){
            $this->projectMember()->associate($recipient);
            $this->sender()->associate($sponsor);
            $this->trans_type = 'Receipt';
            $this->description = 'First payment from Sponsor';
            $this->euro_amount = $sponsoredRecipient->euro_amount_promised;
            $this->due_date = $sponsoredRecipient->next_due;
            $this->month = $this->due_date->format('M');
            $this->save();
        });
        return true;
    }

    public function setStatusConfirmed() {
        $this->status = 'Confirmed';
        $this->save();
        return $this;
    }

    public function processAcceptedPaymentRecipient() {
        DB::transaction(function() {
            $this->setStatusConfirmed();
            /*
             *  Create a group funds payment to coordinator from this recipient
             */
            $recipientMember = $this->member();
            $coordinatorMember = $recipientMember->project()->coordinator();
            $this->newPaymentForCoordinator($recipientMember, $coordinatorMember);

            /*
             *  The recipient accepts payment from sponsor,
             *  - Update next payment date for this sponsor for this project
             *  - Create next months pending payment for Recipient
             */
            $monthEndDate = $this->setNextPayDateForSponsor();
            $this->newMonthPayment($monthEndDate);
        });
        return true;
    }

    private function setNextPayDateForSponsor() {
        $sponsoredRecipient = SponsoredRecipient::where('project_member_id', '=', $this->sender_member_id)
                ->where('recipient_member_id', '=', $this->member_id)
                ->first();
        if ($sponsoredRecipient) {
            $sponsoredRecipient->setNextPaymentDueFromSponsor();
            $sponsoredRecipient->save();
            return $sponsoredRecipient->next_due;
        } else {
            abort(404, 'System Error : A valid Sponsor->Recipient relationship could not be found.');
        }
    }

    private function formatTransData($senderId=0, $receiverId=0, $type='', $status='', $monthEndDate='') {
        return array(
            'sender_member_id' => $senderId,
            'project_member_id' => $receiverId,
            'type' => $type,
            'status' => $status,
            'month' => $monthEndDate->format("M"),
            'due_date' => $monthEndDate
            );
    }

    private function newPaymentForCoordinator($recipientMember, $coordinatorMember) {
        $data = $this->formatTransData(
                $recipientMember->id,
                $coordinatorMember->id,
                'Fund Receipt',
                'Pending',
                $this->due_date
                );
        $this->newPayment($data);
        return true;
    }

    private function newMonthPayment($monthEndDate) {
        $data = $this->formatTransData(
                $this->sender_member_id,
                $this->project_member_id,
                'Receipt',
                'Pending',
                $monthEndDate
                );
        $this->newPayment($data);
        return true;
    }

    private function newFirstMonthPayment($monthEndDate, $senderId, $receiverId) {
        $data = $this->formatTransData(
                $senderId,
                $receiverId,
                'Receipt',
                'Pending',
                $monthEndDate
                );
        $this->newPayment($data);
        return true;
    }

    private function newPayment($data) {
        $payment = new Transaction($data);
        $payment->save();
        return true;
    }

    private function getMailer() {
        if (!isset($this->mailer)) {
            $this->mailer = new Mailer;
        }
        return $this->mailer;
    }

}
