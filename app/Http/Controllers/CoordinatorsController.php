<?php
namespace App\Http\Controllers;

use App\Http\Controllers\DirectSponsorBaseController;
use App\Models\Coordinator;
use App\Models\Project;


class CoordinatorsController extends DirectSponsorBaseController {

    public function __construct(){
        $this->middleware('auth',array('only'=> array(
            'index','show'
        )));
    }

    public function index(){
        $coords = Coordinator::all();
        $this->render('coordinators.index','Coordinators',array(
            'coords' => $coords
        ));
        return $this->layout;
    }

    public function show($id){
        $coord = Coordinator::find($id);
        if (is_null($coord)) {
            abort(404, 'Coordinator Not Found');
        }
        $this->render('coordinators.show','',array(
            'coord' => $coord
        ));
        return $this->layout;
    }

    public function edit($project_id) {
        $project = Project::find($project_id);

        if (is_null($project)) {
            abort(404, 'Project Not Found');
        } else {
            $coordinator = $project->coordinator;
            if (is_null($coordinator)) {
                $coordinatorUser = new User();
            } else {
                $coordinatorUser = $project->coordinator->user;
            }
            $this->render('coordinators.edit','Update Coordinator for project '.$project->name,
                    array(
                        'project_id' => $project->id,
                        'coordinatorUser' => $coordinatorUser
                    )
            );
            return $this->layout;
        }

    }


}
