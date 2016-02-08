<?php

namespace app\Models;


use App\Models\DirectSponsorBaseModel;

class Memberstatus extends DirectSponsorBaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'member_status';

    protected $guarded = array();

    protected $fillable = array('descriptor');

    public function isActive() {
        if ($this->descriptor == 'Active') {
            return true;
        }
        return false;
    }

    public function isSuspended() {
        if ($this->descriptor == 'Suspended') {
            return true;
        }
        return false;
    }

    public function isCancelled() {
        if ($this->descriptor == 'Cancelled') {
            return true;
        }
        return false;
    }

}
