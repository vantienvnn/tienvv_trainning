@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{$lesson->category->name}} &nbsp; {{$lesson->result}}/{{$maxQuestionsCount}}</div>
                <div class="panel-body lesson-result">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>Correct</th>
                                <th>Origin Word</th>
                                <th>Your Answer</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lesson->getLearnedWords() as $learnedWord)
                            <tr>
                                <td>
                                    <span class="item fa {{($correct=$learnedWord->isCorrectAnswer())?'fa-circle-o' :'fa-close'}}"></span>
                                </td>
                                <td>
                                    {{$learnedWord->word->content}}
                                </td>
                                <td>
                                    {{$learnedWord->wordAnswer->content}}
                                </td>
                                <td><a class="btn btn-info">Speak</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
