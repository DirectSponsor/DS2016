<?php

namespace app\Models;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\DirectSponsorBaseModel;
use App\Models\SponsorMember;
use App\Models\RecipientMember;
use App\Models\ProjectMember;


class SponsoredRecipient extends DirectSponsorBaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sponsored_recipient';

    protected $guarded = array();

    protected $fillable = array('sponsored_status', 'next_due');

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'next_due'
    ];

    protected $mailer;

    public function projectMember() {
        return $this->belongsTo('App\Models\ProjectMember');
    }

    /*
     * Sponsored Recipient Methods
     */

    /**
     *
     * @param SponsorMember $sponsor
     * @param RecipientMember $recipient
     * @param type $amount_promised_euro
     * @return \app\Models\SponsoredRecipient
     */
    public function initialiseNew(SponsorMember $sponsor, ProjectMember $recipient, $amount_promised_euro) {
        $this->project_member_id = $sponsor->id;
        $this->recipient_member_id = $recipient->id;
        $this->status = 'Active';
        $this->euro_amount_promised = $amount_promised_euro;
        $this->setNextPaymentDueFromSponsor();
        return $this;
    }

    /**
     *
     * @return \app\Models\SponsoredRecipient
     */
    public function setNextPaymentDueFromSponsor() {
        if (!isset($this->next_due)) {
            $date = new Carbon();
            $date->endOfMonth();
            $this->next_due = $date;
        } else {
            $this->next_due = $this->next_due->addDays(5)->endOfMonth();
        }
        return $this;
    }

    /**
     *
     * @return string $next_due date
     */
    public function getNextPaymentDueFromSponsor() {
        if ($this->next_due->diffInYears() > 50) { /* Checks for no date set in next_pay */
            return '';
        } else {
            return $this->next_due->format('d/m/Y');
        }
    }

}
