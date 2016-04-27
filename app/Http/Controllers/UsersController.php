<?php
namespace App\Http\Controllers;

use App\Http\Controllers\DirectSponsorBaseController;
use Auth;
use Session;
use Validator;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Http\Request;
use App\Models\User;
use App\Process\Registration\Manager as Registration;


class UsersController extends DirectSponsorBaseController {

    public function __construct(){
        $this->middleware('auth', array('only'=> array(
            'edit','panel','logout', 'edit', 'updateEmail', 'updatePass', 'updateDetails', 'permissionsDenied', 'visitorOnly', 'notFound'
        )));
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

    public function confirm(Request $request, $hash) {
        $registrationManager = new Registration;
        $registrationManager->confirmEmail($hash);
        $request->session()->flash('notification', 'Your email has been confirmed. Please login.');

        return redirect('/');
    }
}
