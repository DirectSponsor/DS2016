<?php

/**
 * This file is part of Direct Sponsor Accounts
 *
 * @copyright Copyright (c) 2015 McGarryIT
 * @link      (http://www.mcgarryit.com)
 */

namespace app\Process\Registration;

use Illuminate\Support\Facades\Crypt;
use App\Models\MailerDS as Mailer;
use App\Models\Invitation;
use App\Models\User;


/**
 * Description of Manager
 *
 * @author Paul McGarry <mcgarryit@gmail.com>
 */
class Manager {

    protected $mailer;


    public function __construct() {

    }

    public function newUser(Array $data=array()) {
        $userNew = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'skrill_acc' => $data['skrill_acc'],
            'password' => bcrypt($data['password'])
        ]);
        return $userNew;
    }

    public function registerMember(Array $data=array()) {
        if (!array_key_exists('encryptedString', $data)) {
            abort(403, 'Invitation required for this registration!!');
        }
        $invitationId = Crypt::decrypt($data['encryptedString']);
        $invitation = Invitation::findOrFail($invitationId);
        if (!(($invitation->role_type === 'Coordinator') or ($invitation->role_type === 'Recipient'))) {
            abort(404, 'Invitation Not Found');
        }
        if ($invitation->processed == 1) {
            abort(404, 'Invitation Not Found');
        }
        if ($invitation->email != $data['email']) {
            abort(404, 'Invitation Not Found');
        }
        $user = $this->newUser($data);
        $user->createUserRole($invitation->role_type);
        $userRole = $user->userRoles()->first();
        $invitation->project->addMemberToProject($userRole);
        if ($invitation->role_type === 'Recipient') {
            $this->getMailer()->sendRecipientConfirmationMail($user);
        } else {
            $this->getMailer()->sendCoordinatorConfirmationMail($user);
        }
        return $user;
    }

    public function registerSponsor(Array $data=array()) {
        $user = $this->newUser($data);
        $user->createUserRole('Sponsor');
        $this->getMailer()->sendNewSponsorMail($user);
        return $user;
    }

    public function confirmEmail($hash) {
        $userId = Crypt::decrypt($hash);
        $user = User::findOrFail($userId);
        if ($user->registered == 1) {
            abort(403, 'User ID already registered');
        }
        $user->registered = 1;
        $user->save();
        return $this;
    }

    private function getMailer() {
        if (!isset($this->mailer)) {
            $this->mailer = new Mailer;
        }
        return $this->mailer;
    }

}
