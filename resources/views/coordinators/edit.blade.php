{!!
    Form::model($coordinatorUser,
        array(
            'route' =>
                array(
                    'coordinators.update',
                    $project_id
                ),
            'method' => 'put'
            )
        )
    !!}

@include('coordinators.input_fields')