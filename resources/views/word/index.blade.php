@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @include('partials.alert')
            <div class="panel panel-default">
                <div class="panel-heading"><a class="accordion-toggle"  data-toggle="collapse" href="#add-word-detail">Add new Word</a></div>
                <div class="panel-body collapse{{ $errors->any() ? '  in' : '' }}" id="add-word-detail">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/word/add') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
                            <label for="content" class="col-md-1 control-label">Origin Word</label>
                            <div class="col-md-6">
                                {{ Form::text('content', old('content'), ['required'=>'', 'class' => 'form-control', 'maxlength' => 255, 'id' =>'content']) }}
                                @if ($errors->has('content'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('content') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="content-1" class="col-md-1 control-label">Answer 1</label>
                            <div class="col-md-6">
                                {{ Form::text('answer[1]', old('answer[1]'), ['required'=>'', 'class' => 'form-control', 'maxlength' => 255, 'id' =>'content-1']) }}
                            </div>
                            <div class="col-md-4">
                                {{Form::radio('correct', '1', true)}} Is Correct
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="content-2" class="col-md-1 control-label">Answer 2</label>
                            <div class="col-md-6">
                                {{ Form::text('answer[2]', old('answer[2]'), ['required'=>'', 'class' => 'form-control', 'maxlength' => 255, 'id' =>'content-2']) }}
                            </div>
                            <div class="col-md-4">
                                {{Form::radio('correct', '2', false)}} Is Correct
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="content-3" class="col-md-1 control-label">Answer 3</label>
                            <div class="col-md-6">
                                {{ Form::text('answer[3]', old('answer[3]'), ['required'=>'', 'class' => 'form-control', 'maxlength' => 255, 'id' =>'content-3']) }}
                            </div>
                            <div class="col-md-4">
                                {{Form::radio('correct', '3', false)}} Is Correct
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="content-4" class="col-md-1 control-label">Answer 4</label>
                            <div class="col-md-6">
                                {{ Form::text('answer[4]', old('answer[4]'), ['required'=>'', 'class' => 'form-control', 'maxlength' => 255, 'id' =>'content-4']) }}
                            </div>
                            <div class="col-md-4">
                                {{Form::radio('correct', '4', false)}} Is Correct
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                            <label for="category_id" class="col-md-1 control-label">Category</label>
                            <div class="col-md-6">
                                {{ Form::select('category_id', $categories, null, ['class' => 'form-control', 'required'=>'']) }}
                                @if ($errors->has('category_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('category_id') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-plus"></i> Add
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Filter options</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="GET" action="{{ url('/word') }}">
                        <div class="form-group">
                            <label class="col-md-1 control-label">Category</label>
                            <div class="col-md-4">
                                {{ Form::select('cat', $categories, $request->input('cat'), ['class' => 'form-control']) }}
                            </div>
                            <div class="col-md-4">
                                {{Form::radio('type', 'learned', $request->input('type') == 'learned')}} Learned
                                {{Form::radio('type', 'not-learned', $request->input('type') == 'not-learned')}} Not learned
                                {{Form::radio('type', '', $request->input('type') == '')}} All
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-2">
                                <button name="filter" type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-search"></i> Filter
                                </button>
                                <button name="download" type="submit" class="btn btn-success">
                                    <i class="fa fa-btn fa-download"></i> Pdf
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <div class="row list-word">
        @foreach($words as $word)
        <div class="col-md-6">
            <div class="col-md-4">{{$word->content}}</div>
            <div class="col-md-4">{{$word->correctAnswer->content}}</div>
        </div>
        @endforeach
    </div>
</div>
@endsection
