@extends('layouts.master') 
@section('title','Tasks') 
@section('content')
<div class="row">
    <div class="col-md-6">
        <p><a href="{{ route('create_form') }}" class='btn btn-primary'> Create A Field</a></p>
        <ul class="list-unstyled tasks">
            @if($tasks) @foreach($tasks as $task)
            <li class="list-item list-inline-item">
                <a href="javascript:void(0);" class='show-task-form' data-taskId="{{ $task->id }}">{{ $task->name }}</a>
            </li> <code> -> </code>
            @endforeach @endif
        </ul>
    </div>
    <div class="col-md-6">
        <div class="task-form">

        </div>
    </div>
</div>


<a href="{{ route('workflow') }}"><< Back to workflow</a>
@endsection