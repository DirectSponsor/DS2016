<?php

namespace app\Models;

//use Auth;
//use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

use app\Models\Transaction;
use App\Models\Project;
use App\Models\ProjectMember;
use app\Models\SponsoredRecipient;
use App\Models\User;


class MailerDS
{
    protected $hasher;
    protected $cryptService;

    /**
     * Send New Sponsor an email with Link to click, to confirm email address & complete account setup
     *
     * @param ProjectMember $sponsor
     * @return type
     */
    public function sendNewSponsorMail(User $sponsor) {
        $hash = Crypt::encrypt($sponsor->id);
        $url = URL::route('sponsor.confirm',$hash);
        Mail::send('emails.sponsors.confirm',
                array(
                    'name' => $sponsor->name,
                    'hash' => $hash
                ),
                function($message) use ($sponsor) {
                    $message->to($sponsor->email)
                            ->subject('Sponsor account created !');
                }
        );
        return $url;
    }

    /**
     * Send Sponsor email with Link to click, to confirm email address & complete account setup
     *
     * @param ProjectMember $sponsor
     * @param Project $project
     * @return type
     */
    public function sendSponsorConfirmationMail(ProjectMember $sponsor, Project $project) {
        $recipient = $sponsor->recipients()->first();
        $hash = Crypt::encrypt($sponsor->user->id);
        $url = URL::route('sponsor.confirm',$hash);
        Mail::send('emails.sponsors.confirmation',
                array(
                    'name' => $sponsor->name,
                    'hash' => $hash,
                    'project' => $project,
                    'recipient' => $recipient
                ),
                function($message) use ($sponsor) {
                    $message->to($sponsor->user->email)
                            ->subject('Sponsor account created !');

                }
        );
        return $url;
    }

    /**
     * Send Sponsor email to confirm support of additional Project (& new Recipient)
     *
     * @param User $userSponsor
     * @param Project $project
     * @param ProjectMember $sponsor
     * @param SponsoredRecipient $recipient
     * @return boolean
     */
    public function sendJoinProjectEmail(Project $project, ProjectMember $sponsor, SponsoredRecipient $sponsoredRecipient) {
        Mail::send('emails.sponsors.joining', array(
                'name' => $sponsor->user->name,
                'project' => $project,
                'recipientSkrill' => $sponsoredRecipient->projectMember->user->skrill_acc,
                'promisedAmount' =>$sponsoredRecipient->promised_amount
            ), function($message) use($sponsor) {
            $message->to($sponsor->user->email)->subject('Thank you for joining new project');
        });
        return true;
    }

    /**
     * Send Invitation to a new potential Recipient
     *
     * @param \App\Models\Invitation $invitation
     * @return boolean
     */
    public function sendInvitation(Invitation $invitation) {
        $hash = Crypt::encrypt($invitation->id);
        if ($invitation->role_type == 'Recipient') {
            Mail::send('emails.recipients.invitation', array(
                    'name' => $invitation->project->name,
                    'id' => $hash
                    ), function($message) use($invitation) {
                $message->to($invitation->email)->subject('Invitation to Direct Sponsor');
            });
        } else {
            Mail::send('emails.coordinator.invitation', array(
                    'name' => $invitation->project->name,
                    'id' => $hash
                    ), function($message) use($invitation) {
                $message->to($invitation->email)->subject('Invitation to Direct Sponsor');
            });
        }
        return true;
    }

    /**
     * Send Coordinator email with Link to click, to confirm email address & complete account setup
     *
     * @param User $user
     * @return type
     */
    public function sendCoordinatorConfirmationMail(User $user) {
        $hash = Crypt::encrypt($user->id);
        $url = URL::route('coordinator.confirm',$hash);
        Mail::send('emails.coordinator.confirm', array(
            'name' => $user->name,
            'hash' => $hash
            ), function($message) use($user) {
            $message->to($user->email)->subject('Confirm your Direct Sponsor account');
        });
        return $url;
    }

    /**
     * Send Recipient email with Link to click, to confirm email address & complete account setup
     *
     * @param User $user
     * @return type
     */
    public function sendRecipientConfirmationMail(User $user) {
        $hash = Crypt::encrypt($user->id);
        $url = route('recipient.confirm',['hash' => $hash]);
        Mail::send('emails.recipients.confirm', array(
            'name' => $user->name,
            'hash' => $hash
            ), function($message) use($user) {
            $message->to($user->email)->subject('Confirm your Direct Sponsor account');
        });
        return $url;
    }

    /**
     * This email was being used when a payment was rejected.
     * May no longer be required.
     * Or may be used when a payment is very overdue from a sponsor.
     *
     * @param Transaction $payment
     * @return boolean
     */
    public function sendEmailAdminAndCoordinator(Transaction $payment) {
        $coordEmail = Project::find($payment->project->id)->coordinator->user->email;
        Mail::send('emails.sponsor_payment_denied', array(
            'recipient'=>$payment->recipient,
            'sponsor'=>$payment->sponsor,
            'project'=>$payment->project
        ),function($message) use($coordEmail) {
            $message->to(User::where('account_type','Admin')->first()->email)
                ->cc($coordEmail)
                ->subject('Sponsorship Denied !');
        });
        return true;
    }

    public function sendEmailReminderToSponsor(Transaction $payment, $emailTemplate, $subject='Reminder: Monthly payment due !') {
        $recipient = $payment->receiver->recipient;
        $sponsor = $payment->sender->sponsor;
        Mail::send($emailTemplate, array(
            'recipient' => $recipient,
            'sponsor' => $sponsor,
            'dueDate' => $payment->due_date->format('d/m/Y')
        ),function($message) use($sponsor, $subject) {
            $message->to($sponsor->user->email)
                ->subject($subject);
        });
        return true;
    }

}
