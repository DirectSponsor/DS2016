<?php

namespace app\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;
use App\Models\DirectSponsorBaseModel;

class Role extends DirectSponsorBaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

    protected $guarded = array();

    protected $fillable = array('descriptor');

    /*
     * Direct Relationships
     */

    public function users() {
        return $this->hasMany('App\Models\UserRole', 'user_roles');
    }

    /*
     * Derived Relationships
     */

    
    /*
     * Utility Methods
     */
    public function getAdministratorRole() {
        try {
            return Role::where('descriptor', 'Administrator')->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function getCoordinatorRole() {
        try {
            return Role::where('descriptor', 'Coordinator')->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function getRecipientRole() {
        try {
            return Role::where('descriptor', 'Recipient')->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function getSponsorRole() {
        try {
            return Role::where('descriptor', 'Sponsor')->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }


    /*
     * Significant Attribute Checks
     */
    public function isSuperuser() {
        if ($this->descriptor == 'Superuser') {
            return true;
        }
        return false;
    }

    public function isAdministrator() {
        if ($this->descriptor == 'Administrator') {
            return true;
        }
        return false;
    }

    public function isCoordinator() {
        if ($this->descriptor == 'Coordinator') {
            return true;
        }
        return false;
    }

    public function isRecipient() {
        if ($this->descriptor == 'Recipient') {
            return true;
        }
        return false;
    }

    public function isSponsor() {
        if ($this->descriptor == 'Sponsor') {
            return true;
        }
        return false;
    }


}
