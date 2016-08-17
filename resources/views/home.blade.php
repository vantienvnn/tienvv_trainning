@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body home-page">
                    <div class="sidebar col-md-4">
                        <div class="profile">
                            <img width="200" height="200" src="https://pbs.twimg.com/profile_images/735457183211479040/sDPhMxIs_400x400.jpg" alt="avatar" />
                            <p>{{auth()->user()->name}}</p>
                            <p>Leaned {{$learnedWords}} words</p>
                        </div>
                    </div>
                    <div class="content  col-md-8">
                        <div class="head-btn">
                            <a href="{{url('word')}}" class="btn btn-info">Words</a>
                            <a href="{{url('category')}}" class="btn btn-success">Lesson</a>
                        </div>
                        <h2>Activities</h2>
                        <ul>
                            @foreach($activities as $activity)
                            @if($activity->action_type == $learned)
                            <li>Learned {{$activity->target->result}}
                                in lesson "{{$activity->target->category->name}}"
                                <span class="label label-info">{{$activity->created_at->format('d/m/Y')}}</span>
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
