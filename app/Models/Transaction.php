<?php

namespace app\Models;

use App\Models\DirectSponsorBaseModel;
use App\Models\MailerDS as Mailer;


class Transaction extends DirectSponsorBaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'transaction';

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
        return $this->projectMember->project;
    }

    public function senderName() {
        return $this->sender->userRole->user->name;
    }

    /*
     * Transaction Methods
     */

    public function formatTransData(array $data = array()) {
        if (!array_key_exists('due_date', $data)) {
            return false; /* Throw Exception */
        }
        $data['month'] = $data['due_date']->format("M");
        return $data;
    }

    public function initialiseData($data) {
        $this->fill($data);
        return $this;
    }

    public function getMailer() {
        if (!isset($this->mailer)) {
            $this->mailer = new Mailer;
        }
        return $this->mailer;
    }

}
