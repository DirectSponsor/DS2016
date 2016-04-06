<?php

namespace app\Models;

use App\Models\DirectSponsorBaseModel;
use App\Models\SponsorMember;
use App\Models\RecipientMember;
use App\Models\CoordinatorMember;
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
        return $this->belongsTo('App\Models\UserRole', 'user_role_id');
    }

    public function transactions() {
        return $this->hasMany('App\Models\Transaction');
    }

    /*
     * Member Methods
     */
    public function isActive() {
        if (!$this->userRole->user->registered) {
            return false;
        }
        if ($this->status != 'Active') {
            return false;
        }
        return true;
    }

    public function castMemberRole() {
        switch ($this->userRole->role_type) {
            case 'Sponsor':
                $sponsorMember = new SponsorMember;
                $sponsorMember->id = $this->id;
                $sponsorMember->fill($this->toArray());
                return $sponsorMember;
            case 'Coordinator':
                $coordinatorMember = new CoordinatorMember;
                $coordinatorMember->id = $this->id;
                $coordinatorMember->fill($this->toArray());
                return $coordinatorMember;
            case 'Recipient':
                $recipientMember = new RecipientMember;
                $recipientMember->id = $this->id;
                $recipientMember->fill($this->toArray());
                return $recipientMember;
            default:
                return $this;
        }
    }

    /*
     * Utility Methods
     */
    protected function getMailer() {
        if (!isset($this->mailer)) {
            $this->mailer = new Mailer;
        }
        return $this->mailer;
    }

}
