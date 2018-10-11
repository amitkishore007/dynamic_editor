@extends('layouts.master')

@section('title','Workflow')

@section('content')
<p><a href="{{ route('create_form') }}" class='btn btn-primary'> Create A Form</a></p>

        <ul class="list-unstyled process">
            @if($processes)
                @foreach($processes as $process => $task)
                    <li class="list-item list-inline-item">
                        <a href="{{ route('workflow_single',$task['id']) }}">{{ $process }}</a>
                    </li>
                @endforeach
            @endif
           
        </ul>

@endsection