<?php
namespace App\Http\Controllers;

use App\Http\Controllers\DirectSponsorBaseController;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Http\Requests\InvitationStoreRequest;
use App\Models\Invitation;


class InvitationsController extends DirectSponsorBaseController {

    public function __construct(){
        $this->middleware('auth',array('only'=> array(
            'index','store'
        )));
    }

    public function index(){
        if (Gate::denies('admin-project')) {
            abort(403);
        }
        $projects = Auth::user()->getProjects();
        $user = new User;
        return view('invitations.list', array('projects' => $projects, 'user' => $user));
    }

    public function store(InvitationStoreRequest $request, $projectId){
        if (Gate::denies('admin-project')) {
            abort(403);
        }
        $invitation = new Invitation;
        $invitation->saveData($request, $projectId)->send();
        $request->session()->flash('success','Invitation sent successfuly !');
        return redirect()->route('invitations.index');
    }

    public function resend(Request $request, $invitationId=0) {
        $invitation = Invitation::findOrFail($invitationId);
        $invitation->send();
        $request->session()->flash('success','Invitation sent successfuly !');
        return redirect()->route('invitations.index');
    }
}