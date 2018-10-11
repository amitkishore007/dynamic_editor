@if($task)
    <h3>{{ ucwords($task->name) }}</h3>
    @if($task->datarows()->count()) 
        {!! Form::open(['url' => $task->action,'class'=>'dynamic-form']) !!}
            @foreach($task->datarows as $row)
                <div class="form-group">
                    {!! Form::label($row->name, $row->lebel) !!}
                    {!! Form::{strtolower($row->type)}($row->name, null, ['class'=>'form-control','placeholder'=>$row->label]) !!}
                </div>
            @endforeach
        {!! Form::close() !!}
        @else
        <h5>No Field Created here !</h5>
    @endif
@endif