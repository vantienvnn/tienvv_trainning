@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @include('partials.alert')
            <!-- end .flash-message -->
            <div class="panel panel-default">
                <div class="panel-heading">{{$lesson->category->name}} &nbsp; {{$learnedCount+1}}/{{$maxQuestionsCount}}</div>
                <div class="panel-body">
                    <div class="col-md-6 origin-word" style="text-align: center;">
                        <h1>{{$word->content}}</h1>
                        <a class="btn btn-info">Speak</a>
                    </div>
                    <div class="col-md-5 answer col-md-offset-1">
                        <form class="form-horizontal" id="answer-form" role="form" method="POST" action="{{ url('/lesson/' . $lesson->id) }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="PUT" />
                            {{Form::hidden('word_id' , $word->id)}}
                            @foreach($word->answers as $answer)
                            <div class="form-group">
                                <label for="answer-{{$answer->id}}" class="btn btn-primary">
                                    {{Form::radio('answer', $answer->id, false , ['class' => 'hide answer-item','id' => 'answer-' . $answer->id])}}
                                    {{$answer->content}}
                                </label>
                            </div>
                            @endforeach
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
