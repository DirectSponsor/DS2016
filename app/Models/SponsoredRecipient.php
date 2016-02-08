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

    protected $mailer;

    public function projectMember() {
        return $this->belongsTo('App\Models\ProjectMember');
    }

}
