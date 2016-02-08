<?php
namespace App\Http\Controllers;

use App\Http\Controllers\DirectSponsorBaseController;
use Auth;
use Session;
use Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Transaction;

class UsersController extends DirectSponsorBaseController {

    public function __construct(){
        $this->middleware('auth', array('only'=> array(
            'edit','panel','logout', 'edit', 'updateEmail', 'updatePass', 'updateDetails', 'permissionsDenied', 'visitorOnly', 'notFound'
        )));
    }

    public function loginForm(){ // Shows the login page
        if (Auth::check()) {
            return redirect()->route('panel');
        }
        $this->layout = 'layouts.login';
        $this->render('users.login');
        return $this->layout;
    }

    public function loginAction(Request $request){ // Login the user
        $credentials = array(
            'username' => $request->input('username'),
            'password' => $request->input('password')
        );

        if(!Auth::attempt($credentials)){
            Session::put('error','Incorrect Username or Password!');
            return redirect()->route('login.form');
        }

        $accountType = Auth::user()->account_type;
        if (($accountType == 'Admin') or ($accountType == 'Coordinator') ) {
            return redirect()->route('panel');
        }

        $recipientOrSponsorObj = Auth::user()->account;

        if(!$recipientOrSponsorObj->confirmed){
            Auth::logout();
            Session::put('info','You have to confirm your email before login to your account. Please check your email inbox !');
            return redirect()->route('login.form');
        }

        if($accountType == 'Sponsor'){
            if($recipientOrSponsorObj->suspended){
                Auth::logout();
                Session::put('info','Your account is suspended now !');
                return redirect()->route('login.form');
            }
        }
        return redirect()->route('panel');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login.form');
    }

    public function resendConfEmailForm(){
        $this->layout = 'layouts.forget-password';
        $this->render('users.resend-conf-email');
        return $this->layout;
    }

    public function resendConfEmailAction(Request $request, Encrypter $encrypter, Mailer $mailer){
        $email = $request->input('username');
        $user = User::where('email', $email)->first();
        if (is_null($user)) {
            return redirect()->back()
                        ->withInput($request->only('username'))
                        ->withErrors(['username' => 'That email does not exist !' ]);
        }
        if ($user->account->confirmed == 0) {
            $this->resendConfirmationEmail($user, $request, $encrypter, $mailer);
            Session::put('success','A confirmation email was sent to your email ' . $user->email);
            return redirect()->route('login.form');
        }else{
            return redirect()->back()
                        ->withInput($request->only('username'))
                        ->withErrors(['username' => 'The User for that email address has already been confirmed. <br/>Use the password reset option !' ]);
        }
    }

    private function resendConfirmationEmail(User $user, Request $request, Encrypter $encrypter, Mailer $mailer) {
        Session::flash('email',$user->email);
        $account = $user->account;
        //send email
        switch($user->account_type) {
            case 'Sponsor':
                $subject = 'Sponsor account created (Copy) !';
                $emailTemplate = 'emails.sponsors.confirmation';
                $data = array(
                    'name' => $account->name,
                    'hash' => $encrypter->encrypt($account->id),
                    'project' => $account->projects()->first(),
                    'recipient' => $account->recipientOfProject($account->projects()->first()->id)
                );
                break;
            default:
                $subject = 'Confirm account created (Copy) !';
                $emailTemplate = 'emails.recipients.confirm';
                $data = array(
                    'name' => (isset($account->name) ? $account->name : $user->username),
                    'hash' => $encrypter->encrypt($account->id)
                );
                break;
        }
        $mailer->send($emailTemplate, $data, function($message) use($request, $subject) {
            $message->to($request->input('username'))->subject($subject);
        });
        return true;
    }

    public function forgetPasswordForm(){
        $this->layout = 'layouts.forget-password';
        $this->render('users.forget-password');
        return $this->layout;
    }

    public function forgetPasswordConfirmForm($token){
        $this->layout = 'layouts.forget-password';
        $this->render('users.forget-password-confirm', false, array('token'=>$token));
        return $this->layout;
    }

    public function panel(){
        $user = Auth::user();
        switch($user->account_type){
            case 'Admin':
                return redirect()->route('projects.index');
            case 'Coordinator':
            case 'Recipient':
            case 'Sponsor':
            default:
                return redirect()->route('myProject');
        }
    }

    public function newUser(Request $request, $invitationId){
        $invitation = Invitation::find($invitationId);
        if (is_null($invitation)){
            abort(404, 'Invitation Not Found');
        }
        if ($invitation->processed) {
            abort(404, 'Invalid Invitation - Already Processed');
        }
        switch($invitation->role) {
            case 'Sponsor':
                $newUserType = 'Sponsor';
                $pageTitle = 'Register for DirectSponsor';
                $projectId = 0;
                break;
            case 'Recipient':
                $newUserType = 'Recipient';
                $project = $invitation->project;
                if ( !$project->open ) {
                    $this->render('projects.closed_project');
                    return $this->layout;
                }
                $pageTitle = 'Register for the project : '.$project->name;
                if ($project->isFullySubscribedWithRecipients()) {
                    $this->render('static.message','Apologies - All availabe places are now full',array(
                        'msg' => 'You can\'t join this project because it already has the maximum number of recipients. Please contact the Project Coordinator.'
                    ));
                    return $this->layout;
                }
                $projectId = $project->id;
                break;
            case 'Coordinator':
                $newUserType = 'Coordinator';
                $project = $invitation->project;
                if ( !$project->open ) {
                    $this->render('projects.closed_project');
                    return $this->layout;
                }
                $pageTitle = 'Register for the project : '.$project->name;
                $projectId = $project->id;
                break;
            default:
                abort(404, 'Invalid Invitation - Bad Role Type');
                break;
        }

        $this->render('users.create',
            $pageTitle,
                array(
                    'original_url' => $request->url(),
                    'project_id' => $projectId,
                    'newUserType' => $newUserType
                    )
                );
        return $this->layout;
    }

    public function createUser(Request $request, $project_id=0) {
        $project = Project::find($project_id);
        if (is_null($project)){
            abort(404, 'Project Not Found');
        }
        if ( !$project->open ) {
            $this->render('projects.closed_project');
        }
        $user = new User;
        $result = $user->validateCreateRequest($request);
        if ($result instanceof Validator) {
            Session::put('error','There were some errors !');
            return redirect()->to($request->input('original_url'))
                        ->withErrors($result)
                        ->withInput();
        }
        switch($request->input('new_user_type')) {
            case 'Coordinator':
                /*
                 * ToDo - Check if project has a coordinator
                 * and mark as cancelled or inactive if present.
                 */
                $user->createNewCoordinator($request, $project);
                break;
            case 'Recipient':
                $user->createNewRecipient($request, $project);
                break;
            case 'Sponsor':
                $user->createNewSponsor($request, $project);
                break;
            default:
                abort(404, 'Unrecognised Request');
        }
        if (config('app.debug')) {
            $link = "<a href='".$user->url."'>Confirm Email Link</a>";
            Session::put('success',
                    'Your account was successfully created ! an email has been sent to you to confirm your email '
                    .$user->email. '   '.$link);
        } else {
            Session::put('success',
                    'Your account was successfully created ! an email has been sent to you to confirm your email '
                    .$user->email);
        }
        return redirect()->route('login.form');
    }

    public function edit($id){
        if (Auth::user()->account_type == 'Admin') {
            abort(403, 'The Admin user is not authorised for this action');
        } else {
            $profile = Auth::user()->account;
        }
        $user = Auth::user();
        $data = array(
            'id' => $user->id,
            'username' => $user->username,
            'name' => $profile->name,
            'skrill_acc' => $profile->skrill_acc,
            'email' => $user->email
        );
        $this->render('users.edit','Edit Account Details',$data);
        return $this->layout;
    }

    public function updatePass(Request $request, $id, Hasher $hashService){
        $userId = Auth::user()->id;
        if($userId != $id){
            abort(403, 'You are not authorised for this action');
        }
        /*
         * Validate request inputs
         */
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|min:6',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            $errors = array('There were some errors !');
            foreach($validator->getMessageBag()->getMessages() as $message) {
                $errors[] = $message;
            }
            return response()->json(array('result'=> 'error', 'errors' => $errors));
        }

        $user = User::find($id);

        if(!$hashService->check($request->input('current_password'),$user->password)){
            return response()->json(array('result'=> 'error', 'errors' => array('The password you entered was not correct !')));
        }

        $user->password = $hashService->make($request->input('password'));
        if(!$user->save()){
            return response()->json(array('result'=>'There were some errors !', 'errors' => array('Update Error')));
        }
        Session::put('success','Your password was modified !');
        return response()->json(array('result'=>'success'));
    }

    public function updateDetails(Request $request, $id, Hasher $hashService){
        $userId = Auth::user()->id;
        if($userId != $id){
            abort(403, 'You are not authorised for this action');
        }
        $user = User::find($id);
        $account = $user->account;
        /*
         * Validate request inputs
         */
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'skrill_acc' => 'required|email|unique:recipients,skrill_acc,'.$account->id.'|unique:sponsors,skrill_acc,'.$account->id,
            'email' => 'required|email|unique:users,email,'.$id
        ]);

        if ($validator->fails()) {
            Session::put('error','There were some errors !');
            return redirect()->route('users.edit',$id)
                        ->withErrors($validator)
                        ->withInput();
        }

        $account->name = $request->name;
        $account->skrill_acc = $request->skrill_acc;
        if(!$account->save()){
            Session::put('error','There was some errors !');
            return redirect()->route('users.edit',$id)->withErrors($account->errors())->withInput();
        }

        $user->email = $request->email;
        if(!$user->save()){
            Session::put('error','There was some errors !');
            return redirect()->route('users.edit',$id)->withErrors($user->errors())->withInput();
        }

        Session::put('success','Your details were updated !');
        return redirect()->route('users.edit',$id);
    }

    public function permissionsDenied(){
        $this->render('static.permissions_denied');
        return $this->layout;
    }
    public function visitorOnly(){
        $this->render('static.visitor_only');
        return $this->layout;
    }
    public function notFound(){
        $this->render('static.not_found');
        return $this->layout;
    }
}
