@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Filter options</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="GET" action="{{ url('/word') }}">
                        <div class="form-group">
                            <label class="col-md-1 control-label">Category</label>
                            <div class="col-md-4">
                                {{ Form::select('cat', $categories, app('request')->input('cat'), ['class' => 'form-control']) }}
                            </div>
                            <div class="col-md-4">
                                {{Form::radio('type', 'learned', app('request')->input('type') == 'learned')}} Learned
                                {{Form::radio('type', 'not-learned', app('request')->input('type') == 'not-learned')}} Not learned
                                {{Form::radio('type', '', app('request')->input('type') == '')}} All
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
