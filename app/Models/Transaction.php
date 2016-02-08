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

    protected $dates = ['due_date'];

    protected $guarded = array();
    public static $rules = array();

    protected $mailer;

//    public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
//    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called

    public function member() {
        return $this->belongsTo("App\Models\ProjectMember");
    }

    public function sender() {
        return $this->belongsTo("App\Models\ProjectMember", "from_project_member_id");
    }

    public function type() {
        return $this->belongsTo("App\Models\Transtype", "trans_type_id");
    }

    public function overduePayment() {
        if ($this->type->descriptor != 'Payment') {
            return false;
        }
        if ($this->stat != 'pending') {
            return false;
        }
        if ($this->due_date->isPast() and ($this->due_date->diffInDays() >=5)) {
            return true;
        } else {
            return false;
        }
    }

    public function markLate() {
        $this->stat = 'late';
        $this->save();

        $emailTemplate = 'emails.sponsors.no_payment';
        $subject = 'Reminder: Monthly payment is overdue';
        $this->getMailer()->sendEmailReminderToSponsor($this, $emailTemplate, $subject);
        return true;
    }

    public function initialiseFirstSponsorProjectPayment(ProjectMember $sponsor, ProjectMember $recipient, SponsoredRecipient $sponsoredRecipient) {
        DB::transaction(function() use($sponsor, $recipient, $sponsoredRecipient){
            $this->member()->associate($recipient);
            $this->sender()->associate($sponsor);
            $paymentType = Transtype::getPaymentType();
            $this->type()->associate($paymentType);
            $this->description = 'First payment from Sponsor';
            $this->amount_local = $sponsoredRecipient->promised_amount;

            $monthEndDate = new Carbon();
            $monthEndDate->endOfMonth();
            $this->month = $monthEndDate->format('M');
            $this->due_date = $monthEndDate->format('Y-m-d');
            $this->save();
        });
        return true;
    }

    public function processAcceptedPaymentCoordinator() {
        $this->stat = 'accepted';
        $this->save();
        return $this;
    }

    public function processAcceptedPaymentRecipient() {
        DB::transaction(function() {
            $user = Auth::user();
            if ($user->account_type == 'Coordinator') {
                $this->stat = 'acceptedByCoordinator';
            } else {
                $this->stat = 'accepted';
            }
            $this->save();

            /*
             *  Create a group funds payment to coordinator from this recipient
             */
            $recipientMember = $this->member();
            $coordinatorMember = $recipientMember->project->coordinator;
            $this->newPaymentForCoordinator($recipientMember, $coordinatorMember);

            /*
             *  The recipient accepts payment from sponsor,
             *  - Update next payment date for this sponsor for this project
             *  - Create next months pending payment for Recipient
             */
            $monthEndDate = $this->setNextPayDateForSponsor();
            $this->newNextMonthPayment($monthEndDate);

//            $emailTemplate = 'emails.sponsors.no_payment';
//            $subject = 'Reminder: Monthly payment is overdue';
//            $this->getMailer()->sendEmailReminderToSponsor($this, $emailTemplate, $subject);
        });
        return true;
    }

    private function getNewPaymentDataFormatted($senderId=0, $receiverId=0, $type='', $stat='', $monthPay='', $monthEndDate='') {
        return array(
            'sender_member_id' => $senderId,
            'member_id' => $receiverId,
            'type' => $type,
            'stat' => $stat,
            'month' => $monthPay,
            'due_date' => $monthEndDate
            );
    }

    private function newPaymentForCoordinator($recipientMember, $coordinatorMember) {
        $data = $this->getNewPaymentDataFormatted(
                $recipientMember->id,
                $coordinatorMember->id,
                'Receipt Fund',
                'pending',
                $this->pay_month,
                $this->due_date
                );
        $this->newPayment($data);
        return true;
    }

    private function newNextMonthPayment($monthEndDate) {
        $data = $this->getNewPaymentDataFormatted(
                $this->sender_member_id,
                $this->member_id,
                'Payment',
                'pending',
                $monthEndDate->format('M'),
                $monthEndDate->format('Y-m-d')
                );
        $this->newPayment($data);
        return true;
    }

    private function newFirstMonthPayment(Project $project, $monthEndDate, $senderId, $receiverId) {
        $data = $this->getNewPaymentDataFormatted(
                $senderId,
                $receiverId,
                'Payment',
                'pending',
                $monthEndDate->format('M'),
                $monthEndDate->format('Y-m-d')
                );
        $this->newPayment($data, $project);
        return true;
    }

    private function newPayment($data, $projectMember=null) {
        $payment = new Transaction($data);
        $payment->member()->associate($projectMember);
        $payment->save();
        return true;
    }

    private function setNextPayDateForSponsor() {
        $sponsoredRecipient = SponsoredRecipient::where('member_id', '=', $this->sender_member_id)
                ->where('recipient_member_id', '=', $this->member_id)
                ->first();
        if ($sponsoredRecipient) {
            $lastPaymentDate = new Carbon($sponsoredRecipient->next_pay);
            if (! $lastPaymentDate instanceof Carbon) {
                $lastPaymentDate = new Carbon();
            }
            $sponsoredRecipient->next_pay = $lastPaymentDate->addDays(5)->endOfMonth()->format('Y-m-d');
            $sponsoredRecipient->save();
            return $lastPaymentDate;
        } else {
            abort(404, 'System Error : A valid Sponsor->Recipient relationship could not be found.');
        }
    }

    private function getMailer() {
        if (!isset($this->mailer)) {
            $this->mailer = new Mailer;
        }
        return $this->mailer;
    }

}
