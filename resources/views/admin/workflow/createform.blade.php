@extends('layouts.master') 
@section('title','Form Field') 
@section('content')
<div class="row">
    <div class="col-md-6">
        <p> Create A Form Field</p>
        <form action="{{ route('create_form') }}" class="create-form" id='create-form' method="POST">
            <div class="form-group">
                <label for="process">Process</label>
                <select name="process" class='form-control' id="process">
                    <option value="">Select Process</option>
                    @if($process)
                        @foreach($process as $p)
                            <option value="{{ $p->id }}">{{ ucwords($p->name) }}</option>
                        @endforeach
                    @endif
                </select>
                <span class='text-danger process-error'></span>
            </div>
            <div class="form-group">
                <label for="task">Task Type</label>
                <select name="task" class='form-control' id="task">
                    <option value="">Select Task</option>
                </select>
                <span class='text-danger task-error'></span>
            </div>
            <div class="form-group">
                <label for="order">Field Order</label>
                <input type="number" id='w_order' name='w_order' placeholder='order' class='form-control'>
                <span class='text-danger order-error'></span>
            </div>
            <div class="form-group">
                <label for="name">Field Name</label>
                <input type="text" placeholder="Enter Field Name" name='field_name' id='field_name' class='form-control'>
                <span class='text-danger name-error'></span>
            </div>
            <div class="form-group">
                <label for="fieldType">Field Type</label>
                <select name="type" class='form-control' id="fieldType">
                    <option value="">Select Field type</option>
                    <option value="text">Text</option>
                    <option value="textarea">TextArea</option>
                    <option value="number">Number</option>
                    <option value="dropdown">Dropdown</option>
                    <option value="file">File</option>
                </select>
                <span class='text-danger type-error'></span>
            </div>
            <div class="form-group validtion_rules_div">
                <label for="validation_rules">Validaion Rules</label>
                <br/>
                @if($validation_rules)
                    @foreach($validation_rules as $rule)
                        <label for=""> <input type="checkbox" data-type='{{ $rule->name }}' name='rules[]' data-requireValue='{{ $rule->value_required }}' class='form-control' value='{{ $rule->id }}' />{{ $rule->name }}  </label>
                    @endforeach
                @else 
                    <code>No validation Rule found!</code>
                @endif
                <span class='text-danger validation_rules-error'></span>
            </div>
            <div class="form-group">
                <label for="fieldLabel">Field Label</label>
                <input type="text" placeholder="field Label" id='fieldLabel' class='form-control'>
                <span class='text-danger label-error'></span>
            </div>
            <div class="form-group">
                {!! csrf_field() !!}
                <input type="button" value='Create Field' class='btn btn-primary' id='createFormBtn'>
            </div>
        </form>
    </div>
    <div class="col-md-6">
        <div class="task-form">
            @foreach($process as $pro)
            <ul class="list-group">
                <li class="list-group-item active"><a style="color:#fff;" href='javascript:void(0);'> {{ ucwords($pro->name) }} </a></li>
                @if($pro->tasks)
                    <ul class="list-group">
                        @foreach($pro->tasks as $task)
                            <li class="list-group-item list-group-item-success">
                            <a href='javascript:void(0);' data-title='{{ $pro->name }}' data-taskId='{{ $task->id }}' class='task-list-item'>
                                    {{ $task->name }}  <code>( {{ $task->action }} )</code> 
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
               
            </ul>
            @endforeach
        </div>
    </div>
</div>

<li class="list-group-item" id='dynamic-list-item' style="display:none;"></li>
<a href="{{ route('workflow') }}">
    << Back to workflow</a>
@endsection