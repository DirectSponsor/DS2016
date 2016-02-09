<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use App\Models\DirectSponsorBaseModel;
use App\Models\Role;
use app\Models\UserRole;
use App\Models\Invitation;
use app\Models\ProjectMember;
use App\Models\Transaction;
use App\Models\MailerDS as Mailer;


class User extends DirectSponsorBaseModel implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('name', 'email', 'skrill_acc', 'registered', 'password');

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    protected $hashService;

    public static $rules = array(
        'username' => 'required|unique:users',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6|confirmed'
    );

    public function __construct() {
        parent::__construct();
    }

    /*
     * Direct Relationships
     */
    public function userRoles() {
        return $this->hasMany('App\Models\UserRole', 'user_roles');
    }

    public function projectMemberships() {
        return $this->hasManyThrough('App\Models\ProjectMember', 'App\UserRole');
    }

    /*
     * Derived Relationships
     */
    private function getRolesList() {
        $roleList = array();
        foreach($this->userRoles as $userRole) {
            $roleList[] = $userRole->role_type;
        }
        return $roleList;
    }

    public function hasMultipleRoles() {
        if ($this->userRoles()->count() > 1) {
            return true;
        } else {
            return false;
        }
    }

    public function isAdministrator() {
        $roleList = $this->getRolesList();
        if (in_array('Administrator', $roleList)) {
            return true;
        } else {
            return false;
        }
    }

    public function isCoordinator() {
        $roleList = $this->getRolesList();
        if (in_array('Coordinator', $roleList)) {
            return true;
        } else {
            return false;
        }
    }

    public function isRecipient() {
        $roleList = $this->getRolesList();
        if (in_array('Recipient', $roleList)) {
            return true;
        } else {
            return false;
        }
    }

    public function getProjectMember($project_id) {
        $projectMember = $this->projectMemberships()
                ->where('project_id', '=', $project_id)
                ->first();

        if ($projectMember) {
            return $projectMember;
        } else {
            return false;
        }
    }

    public function isSponsorOfProject($project_id) {
        $projectMemberships = $this->projectMemberships()
                ->where('project_id', '=', $project_id)
                ->get();

        if ($projectMemberships) {
            foreach($projectMemberships as $projectMember) {
                if ($projectMember->role->descriptor == 'Sponsor') {
                    return $projectMember;
                }
            }
        } else {
            return false;
        }
    }

    public function isValidSponsorOfProject($project_id) {
        $isSponsor = true;
        foreach($this->projectMemberships as $projectMember) {
            if ($projectMember->role->descriptor != 'Sponsor') {
                $isSponsor = false;
            }
            if ($projectMember->project_id == $project_id) {
                /* Already a sponsor / member of this project */
                return false;
            }
        }
        return $isSponsor;
    }

    /*
     * Utility Methods
     */
    public function getReminderEmail() {
        return $this->email;
    }

    private function getMailer() {
        if (!isset($this->mailer)) {
            $this->mailer = new Mailer;
        }
        return $this->mailer;
    }

    public function validateCreateRequest(Request $request) {
        /*
         * Validate request inputs
         */
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required|min:6|confirmed',
            'skrill_acc' => 'email|unique:recipients'
        ]);

        if ($validator->fails()) {
            return $validator;
        } else {
            return $this;
        }
    }

    public function createNewCoordinator(Request $request, Invitation $invitation) {
        DB::transaction(function() use($request, $invitation) {
            $this->createNewUser($request);
            $coordinatorRole = Role::getCoordinatorRole();
            $this->createUserRole($this, $coordinatorRole);

            $project = $invitation->project();

            $projectMember = new ProjectMember;
            $projectMember->addCoordinatorToProject($this, $project, $coordinatorRole);
            $this->url = $this->getMailer()->sendCoordinatorConfirmationMail($this);

            return $this;
        });
    }

    public function createNewRecipient(Request $request, Invitation $invitation) {
        DB::transaction(function() use($request, $invitation) {
            $this->createNewUser($request);
            $recipientRole = Role::getRecipientRole();
            $this->createUserRole($this, $recipientRole);

            $project = $invitation->project();

            $projectMember = new ProjectMember;
            $projectMember->addRecipientToProject($this, $project, $recipientRole);
            $this->url = $this->getMailer()->sendRecipientConfirmationMail($this);

            return $this;
        });
    }

    public function createNewSponsor(Request $request, Project $project) {
        $this->createNewUser($request);
        $this->url = $this->getMailer()->sendNewSponsorMail($this);

        return $this;
    }

    public function createNewUser(Request $request) {
        $this->fill($request);
        $this->confirmed = false;
        if (empty($this->skrill_acc)) {
            $this->skrill_acc = $request->input('email');
        }
        $this->password = Hash::make($this->password);

        $this->save();
        return $this;
    }

    private function createUserRole(User $user, Role $role) {
        $userRole = new UserRole;
        $userRole->user()->associate($user);
        $userRole->role()->associate($role);
        $userRole->save();
    }

    public function confirmAndCompleteSetup($project_id=0) {
        DB::transaction(function() {
            $this->confirmed = true;
            $this->save();

            $projectMember = $this->memberships()->first();
            if ($projectMember->isSponsorRole()) {
                $payment = new Transaction;
                $recipient = $projectMember->sponsoredRecipients()->first();
                $payment->initialiseFirstSponsorProjectPayment($projectMember, $recipient);
            }
        });
        return $this;
    }

}
