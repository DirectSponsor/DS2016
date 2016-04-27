<?php

namespace App\Http\Controllers;

use app\Http\Controllers\DirectSponsorBaseController;
use Auth;
use Illuminate\Support\Facades\Gate;
use Session;
use Illuminate\Contracts\Validation\Validator as Validator;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Process\Support\Manager as SupportManager;


class ProjectsController extends DirectSponsorBaseController {

    public function __construct(){
        $this->middleware('auth',array('only'=> array(
            'index', 'myProject', 'create', 'store', 'show', 'edit', 'update', 'close', 'open', 'joinProject', 'joinProjectAction', 'withdraw'
        )));
    }

    public function index(){
        $projects = Auth::user()->getProjects();
        $enableSupport = (Auth::user()->isSponsor() ? 1 : 0);
        return view('projects.list', array('projects' => $projects, 'enableSupport' => $enableSupport));
    }

    public function supportShow($projectId=0) {
        if (Gate::denies('valid-sponsor', $projectId)) {
            abort(403);
        }
        $project = Project::find($projectId);
        $supportManager = new SupportManager($project);
        $amounts = $supportManager->getSupportAmountsAvailable();

        return view('forms.support_amount', array('project' => $project, 'amounts' => $amounts));
    }

    public function supportConfirm(Request $request, $projectId=0) {
        if (Gate::denies('valid-sponsor', $projectId)) {
            abort(403);
        }
        $project = Project::find($projectId);
        $supportManager = new SupportManager($project);

        $recipientMember = $supportManager->createSupportedRecipient(Auth::user(), $request->amount_selected[0]);

        $request->session()->flash('notification', 'You have sponsored '. $recipientMember->userRole->user->name . ' on this project "'.$project->name.'" Please check your email inbox to make your first payment !');
        return redirect()->route('projects');
    }

    public function create(){
        $project = new Project();
        return view('forms.project_create', array('project' => $project));
    }

    public function store(Request $request){
        if (Gate::denies('admin-project')) {
            abort(403, 'You may not update project configuration');
        }
        $project = new Project;
        $result = $project->validateCreateProjectData($request);
        if ($result instanceof Validator) {
            Session::put('error','There were some errors creating a new Project!');
            return redirect()->route('projects.create')
                        ->withErrors($result)
                        ->withInput();
        }
        $project->setupProject($request);
        Session::put('success','Project has been added !');
        return redirect()->route('projects.show',$project->url);
    }

    public function edit($pid){
        $project = Project::findorfail($pid);
//        $coordinator = $project->coordinator;
        return view('forms.project_edit', array('project' => $project));
    }

    public function update(Request $request, $id){
        if (Gate::denies('admin-project')) {
            abort(403, 'You may not update project configuration');
        }
        $project = Project::find($id);
        if (is_null($project)) {
            abort(404, 'Project Not Found');
        }
        $project->fillFromRequest($request)->save();
        $request->session()->flash('success', 'Project updated successfully !');
        return redirect()->route('projects');
    }


    public function close($id){
        $project = Project::find($id);
        if (is_null($project)) {
            abort(404, 'Project Not Found');
        }
        $project->open = false;
        $project->save();
        Session::put('error','The project \''.$project->name.'\' has been closed !');
        return redirect()->route('projects.index');
    }

    public function open($id){
        if (Gate::denies('admin-project')) {
            abort(403, 'You may not update project configuration');
        }
        $project = Project::find($id);
        if (is_null($project)) {
            abort(404, 'Project Not Found');
        }
        $project->open = true;
        $project->save();
        Session::put('success','The project \''.$project->name.'\' has been opened !');
        return redirect()->route('projects.index');
    }

    public function withdraw($projectId){
        if (Gate::denies('admin-project')) {
            abort(403, 'You may not update project configuration');
        }
        $accountType = Auth::user()->account_type;
        if ($accountType != 'Sponsor') {
            abort(403, 'You are not authorised for this action');
        }
        $project = Project::find($projectId);
        if (is_null($project)) {
            abort(404, 'Project Not Found');
        }
        $sponsor = Auth::user()->account;
        $sponsor->projects()->detach($projectId);

        Session::put('info','You don\'t sponsor the project "'.$project->name.'" anymore. You can still rejoin the project later if you want.');
        return response()->json(array('result'=>'success'));
    }
}
