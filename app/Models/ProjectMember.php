<?php

namespace app\Models;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\DirectSponsorBaseModel;
use App\Models\Role;
use App\Models\Invitation;
use App\Models\MailerDS as Mailer;


class ProjectMember extends DirectSponsorBaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'project_member';

    protected $guarded = array();

    protected $fillable = array('member_status');

    protected $mailer;

    /*
     * Direct Relationships
     */
    public function project() {
        return $this->belongsTo('App\Models\Project');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function role() {
        return $this->belongsTo('App\Models\Role');
    }

    public function sponsoredRecipients() {
        return $this->hasMany('App\Models\SponsoredRecipient');
    }

    public function transactions() {
        return $this->hasMany('App\Models\Transaction');
    }

    /*
     * Derived Relationships
     */
    public function isSponsorRole() {
        if ($this->role->descriptor == 'Sponsor') {
            return true;
        } else {
            return false;
        }
    }

//    public function sentPayments(){
//        return $this->user->sentPayments();
//    }
//
//    public function receivedPayments(){
//        return $this->user->receivedPayments();
//    }

    public function nextPaymentDueFromSponsor($sponsorId) {
    	$nextPaymentDueFromSponsor = $this->sponsors()
                ->where('sponsor_id', $sponsorId)
                ->first();
        if (is_null($nextPaymentDueFromSponsor)) {
            return '';
        }
        $dateObj = new Carbon($nextPaymentDueFromSponsor->pivot->next_pay);
        if ($dateObj->diffInYears() > 50) { /* Checks for no date set in next_pay */
            return '';
        } else {
            return $dateObj->format('d/m/Y');
        }
    }

    private function getMailer() {
        if (!isset($this->mailer)) {
            $this->mailer = new Mailer;
        }
        return $this->mailer;
    }

    public function addCoordinatorToProject(User $user, Project $project, Role $coordinatorRole) {
        DB::transaction(function() use($user, $project, $coordinatorRole) {
            $this->addMemberToProject($user, $project, $coordinatorRole);
        });
        return $this;
    }

    public function addRecipientToProject(User $user, Project $project, Role $recipientRole) {
        DB::transaction(function() use($user, $project, $recipientRole) {
            $this->addMemberToProject($user, $project, $recipientRole);
        });
        return $this;
    }

    public function addSponsorToProject(User $user, Project $project, ProjectMember $recipient) {
        DB::transaction(function() use($user, $project, $recipient) {
            $sponsorRole = Role::getSponsorRole();
            $this->addMemberToProject($user, $project, $sponsorRole);
            $sponsoredRecipient = $this->addRecipientToSponsor($recipient->id);
            return $sponsoredRecipient;
        });
    }

    private function addMemberToProject(User $user, Project $project, Role $role) {
        $this->user()->associate($user);
        $this->project()->associate($project);
        $this->role_id = $role->id;
        $this->member_status = 'active';

        $this->save();
        return $this;
    }

    public function addRecipientToSponsor($recipient_member_id) {
        DB::transaction(function() use($recipient_member_id) {
            $sponsoredRecipient = new SponsoredRecipient;
            $sponsoredRecipient->project_member_id = $this->id;
            $sponsoredRecipient->recipient_member_id = $recipient_member_id;
            $sponsoredRecipient->status = 'active';
            $sponsoredRecipient->promised_amount = $this->project->min_amount_per_recipient;

            $date = new Carbon();
            $date->endOfMonth();
            $sponsoredRecipient->next_pay = $date;
            $sponsoredRecipient->save();

            return $sponsoredRecipient;
        });
    }

}
