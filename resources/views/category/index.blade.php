@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="row list-word">
            @foreach($categories as $category)
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">{{$category->name}} 
                        <label class="label label-success">
                            You've learned {{$user->getLearnedWords($category->id)}}/{{$category->getWordsCount()}}
                        </label>
                    </div>
                    <div class="panel-body">
                        <span class="label label-warning">{!!implode('</span> <span class="label label-warning">' , $category->getWordsList())!!}</span>
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
