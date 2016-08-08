@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @include('partials.alert')
            <!-- end .flash-message -->
            <div class="panel panel-default">
                <div class="panel-heading"><a class="accordion-toggle"  data-toggle="collapse" href="#add-category-detail">Add new Category</a></div>
                <div class="panel-body collapse{{ $errors->any() ? '  in' : '' }}" id="add-category-detail">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/category/add') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-1 control-label">Name</label>
                            <div class="col-md-6">
                                {{ Form::text('name', old('name'), ['class' => 'form-control', 'maxlength' => 255, 'id' => 'name']) }}
                                @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
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
        <div class="row list-word">
            @foreach($categories as $category)
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">{{$category->name}} 
                        <label class="label label-success">
                            You've learned {{$category->learnedCount()}}/{{$category->wordsCount()}}
                        </label>
                    </div>
                    <div class="panel-body">   
                        <span class="label label-warning">{!!implode('</span>&nbsp;<span class="label label-warning">' , $category->wordsList())!!}</span>
                    </div>
                    <div class="panel-footer clearfix">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/lesson') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="category_id" value="{{$category->id}}" />
                            <button type="submit" class="btn btn-info pull-right">Start</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
