<?php

namespace app\Models;

use Illuminate\Support\Facades\DB;

use App\Models\DirectSponsorBaseModel;
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

    protected $fillable = array('status');

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $mailer;

    /*
     * Direct Relationships
     */
    public function project() {
        return $this->belongsTo('App\Models\Project');
    }

    public function userRole() {
        return $this->belongsTo('App\Models\UserRole');
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
        if ($this->userRole->role_type == 'Sponsor') {
            return true;
        } else {
            return false;
        }
    }

    private function getMailer() {
        if (!isset($this->mailer)) {
            $this->mailer = new Mailer;
        }
        return $this->mailer;
    }

    public function addRecipientToSponsor(ProjectMember $recipientMember, $promisedAmount=0) {
        DB::transaction(function() use($recipientMember, $promisedAmount) {
            $sponsoredRecipient = new SponsoredRecipient;
            $sponsoredRecipient->recipient_member_id = $recipientMember->id;
            $sponsoredRecipient->status = 'Active';
            $sponsoredRecipient->promised_amount = $promisedAmount;
            $sponsoredRecipient->setNextPaymentDueFromSponsor();

            $this->sponsoredRecipients()->save($sponsoredRecipient);
            return $this;
        });
    }

}
