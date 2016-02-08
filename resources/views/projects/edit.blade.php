{!!
    Form::model($project,array('route'=>array('projects.update',$project->id), 'method'=>'put'))
    !!}

@include('projects.input_fields')