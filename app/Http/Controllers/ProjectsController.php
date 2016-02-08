<?php

namespace App\Http\Controllers;

use App\Http\Controllers\DirectSponsorBaseController;
use Auth;
use Session;
use Illuminate\Contracts\Validation\Validator as Validator;
use Illuminate\Http\Request;

use App\Models\Project;
use app\Models\Transaction;
use App\Models\MailerDS as Mailer;


class ProjectsController extends DirectSponsorBaseController {

    public function __construct(){
        $this->middleware('auth',array('only'=> array(
            'index', 'myProject', 'create', 'store', 'show', 'edit', 'update', 'close', 'open', 'joinProject', 'joinProjectAction', 'withdraw'
        )));
    }

    public function index(){
        $projects = Project::all();

        $this->render('projects.index','Projects',array('projects'=>$projects));
        return $this->layout;
    }

    public function show($url){
        if ((Auth::user()->account_type == 'Admin') or (Auth::user()->account_type == 'Sponsor')) {
            // Continue
        } else {
            abort(403, 'Not authorised to view this page');
        }
        if (Auth::user()->account_type == 'Sponsor') {
            $sponsor = Auth::user()->account;
            $sponsorProjects = array();
            foreach($sponsor->projects as $eachProject) {
                $sponsorProjects[] = $eachProject->id;
            }
        }
        $project = Project::where('url','=',$url)->first();
        if (is_null($project)) {
            abort(404, 'Project Not Found');
        } else {
            if (Auth::user()->account_type == 'Sponsor') {
                if (!in_array($project->id, $sponsorProjects)) {
                    abort(403, 'Not authorised to view this Project');
                }
            }
            $this->render('projects.show','Project: '.$project->name, array('project'=>$project));
            return $this->layout;
        }
    }

    public function myProject(){
        $user = Auth::user();
        switch($user->account_type){
            case 'Admin' :
                return redirect()->route('projects.index');
            case 'Coordinator' :
                $project = Project::find($user->account->project_id);
                $this->render('projects.show',$project->name,array('project' => $project));
                return $this->layout;
            case 'Recipient' :
                $project = Project::find($user->account->project_id);
                $sponsors = $user->account->sponsors;
                $this->render('projects.show_recipient',$project->name,array(
                    'project' => $project,
                    'sponsors' => $sponsors
                ));
                return $this->layout;
            case 'Sponsor' :
                $this->render('projects.index','My Projects',array(
                    'projects' => $user->account->projects
                ));
                return $this->layout;
        }
        abort(404, 'Your account type is not known to the system.');
    }

    public function joinProject(){
        $accountType = Auth::user()->account_type;
        if ($accountType != 'Sponsor') {
            abort(403, 'You must be a Sponsor to join a Project');
        }
        $sponsorProjectsIds = Auth::user()->account->projects->lists('id');
        if (empty($sponsorProjectsIds)) {
            $projects = Project::where('open','=',true)->get();
        } else {
            $projects = Project::whereNotIn('id',$sponsorProjectsIds)->where('open','=',true)->get();
        }
        $this->render('projects.sponsor_join','Join A Project',array(
            'projects' => $projects
        ));
        return $this->layout;
    }

    public function sponsorAnotherRecipient($pid, Mailer $mailer){
        $user = Auth::user();
        if (!$user->isSponsor()) {
            abort(403, 'You are not authorised for this action');
        }
        $project = Project::find($pid);
        if (is_null($project)) {
            abort(404, 'Project Not Found');
        }
        $projectMember = $user->getProjectMember($pid);

        $recipient = $project->getFreeRecipient();
        if ($recipient){
            $sponsoredRecipient = $this->addRecipientToSponsor($recipient->id);
            $payment = new Transaction;
            $payment->initialiseFirstSponsorProjectPayment($projectMember, $recipient, $sponsoredRecipient);
            $mailer->sendJoinProjectEmail($project, $projectMember, $sponsoredRecipient);

            Session::put('success','You have sponsored another recipient on this project "'.$project->name.'" Please check your email inbox to make your first payment !');
            return redirect()->route('joinProject');
        } else {
            Session::put('error','Sorry : There is no empty place on this peoject currently. Please retry later ');
            return redirect()->route('joinProject');
        }
    }

    public function sponsorJoinProject($project_id, Mailer $mailer){
        $user = Auth::user();
        if (!$user->isSponsor()) {
            abort(403, 'You are not authorised for this action');
        }
        $project = Project::find($project_id);
        if (is_null($project)) {
            abort(404, 'Project Not Found');
        }

        $recipient = $project->getFreeRecipient();
        if ($recipient){
            $projectMember = new ProjectMember;
            $sponsoredRecipient = $projectMember->addSponsorToProject($user, $project, $recipient);
            $payment = new Transaction;
            $payment->initialiseFirstSponsorProjectPayment($projectMember, $recipient, $sponsoredRecipient);
            $mailer->sendJoinProjectEmail($project, $projectMember, $sponsoredRecipient);

            Session::put('success','You have joined the project "'.$project->name.'" Please check your email inbox to make your first payment !');
            return redirect()->route('joinProject');
        } else {
            Session::put('error','Sorry : There is no empty place on this peoject currently. Please retry later ');
            return redirect()->route('joinProject');
        }
    }


    public function create(){
        $project = new Project();
        $this->render('projects.create','Add new project',
                array(
                    'project' => $project
                ));
        return $this->layout;
    }

    public function store(Request $request){
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

    public function edit($url){
        $project = Project::where('url','=',$url)->first();
        if (is_null($project)) {
            abort(404, 'Project Not Found');
        } else {
            $coordinator = $project->coordinator;
            $this->render('projects.edit','Edit: '.$project->name,
                    array(
                        'project' => $project,
                        'user' => $coordinator->user
                    )
            );
            return $this->layout;
        }
    }

    public function update(Request $request, $id){
        $project = Project::find($id);
        if (is_null($project)) {
            abort(404, 'Project Not Found');
        }
        $result = $project->validateEditProjectData($request);
        if ($result instanceof Validator) {
            Session::put('error','There were some errors Editing this Project!');
            return redirect()->route('projects.edit', $project->url)
                        ->withErrors($result)
                        ->withInput();
        }
        $project->updateProject($request);
        Session::put('success','Project editted successfully !');
        return redirect()->route('projects.show',$project->url);
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
