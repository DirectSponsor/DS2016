<?php

namespace app\Models;


use App\Models\DirectSponsorBaseModel;

class Transtype extends DirectSponsorBaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'trans_type';

    protected $guarded = array();

    protected $fillable = array('descriptor', 'amount_sign');

    /*
     * Direct Relationships
     */

    public function projectMembers() {
        return $this->hasMany('App\Models\ProjectMember');
    }

    /*
     * Utility Methods
     */
    public function getPaymentType() {
        try {
            return Transtype::where('descriptor', 'Payment')->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function getReceiptFundType() {
        try {
            return Transtype::where('descriptor', 'Receipt Fund')->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function getSpendFundType() {
        try {
            return Transtype::where('descriptor', 'Spend Fund')->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function isPayment() {
        if ($this->descriptor == 'Payment') {
            return true;
        }
        return false;
    }

    public function isReceiptFund() {
        if ($this->descriptor == 'Receipt Fund') {
            return true;
        }
        return false;
    }

    public function isSpendFund() {
        if ($this->descriptor == 'Spend Fund') {
            return true;
        }
        return false;
    }

}
