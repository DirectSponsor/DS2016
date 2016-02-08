{!!
    Form::model($project, array('route'=>array('projects.store'), 'method'=>'put'))
    !!}

@include('projects.input_fields')
