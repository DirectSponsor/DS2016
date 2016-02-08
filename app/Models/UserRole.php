<?php

namespace app\Models;

use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Role;
use App\Models\DirectSponsorBaseModel;

class UserRole extends DirectSponsorBaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_roles';

    protected $guarded = array();

    protected $fillable = array('');

    protected $mailer;

    /*
     * Direct Relationships
     */
    public function user() {
        return $this->belongsTo("App\Models\User");
    }

    public function role() {
        return $this->belongsTo("App\Models\Role");
    }

    /*
     * Update Methods
     */
}
