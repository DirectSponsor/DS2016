<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Collection;
use App\Models\ProjectMember;


class CoordinatorMember extends ProjectMember
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'project_member';

//    protected $guarded = array();
//
//    protected $fillable = array('status');

    /*
     * Direct Relationships
     */
    public function receipts() {
        return $this->hasMany('App\Models\Receipt', 'project_member_id');
    }

    public function expenses() {
        return $this->hasMany('App\Models\Transaction', 'sender_member_id');
    }

    /*
     * Derived Relationships
     */

    public function receiptsConfirmed() {
        $receipts = new Collection();
        foreach($this->receipts as $receipt) {
            if ($receipt->status == 'Confirmed') {
                return true;
            }
        }
        return $receipts;
    }

    public function receiptsDue() {
        $receipts = new Collection();
        foreach($this->receipts as $receipt) {
            if ($receipt->status != 'Confirmed') {
                $receipts->add($receipt);
            }
        }
        return $receipts;
    }


    /*
     * Coordinator Methods
     */

}
