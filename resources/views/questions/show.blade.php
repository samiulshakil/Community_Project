@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                    <div class="card-title">
                        <div class="d-flex align-items-center">
                            <h3>{{$question->title}}</h3>
                            <h3 class="ml-auto">
                                <a class="btn btn-outline-secondary" href="{{route('questions.index')}}">
                                    Back To All Question
                                </a>
                            </h3>
                        </div>
                    </div>
                    <hr>

                <div class="media">
                    <div class="d-flex flex-column votes-control">
                        <a class="vote-up {{Auth::guest() ? 'off' : ''}}" onclick="event.preventDefault(); document.getElementById('questions-vote-up{{$question->id}}').submit();">
                            <i class="fas fa-caret-up fa-3x"></i>
                        </a>

                        <span class="votes-count">{{$question->votes_count}}</span>

                        <form action="{{route('questions.vote', $question->id)}}" id="questions-vote-up{{$question->id}}"  method="post" style="display: none">
                            @csrf
                            <input type="hidden" name="vote" value="1">
                        </form>

                        <a href="" class="votes-down {{Auth::guest() ? 'off' : ''}}" onclick="event.preventDefault(); document.getElementById('questions-vote-down{{$question->id}}').submit();">
                            <i class="fas fa-caret-down fa-3x"></i>
                        </a>

                        <form action="{{route('questions.vote', $question->id)}}" id="questions-vote-down{{$question->id}}"  method="post" style="display: none">
                            @csrf
                            <input type="hidden" name="vote" value="-1">
                        </form>

                            <a class="favorite mt-3 
                                {{Auth::guest() ? 'off' :($question->is_favorited) ? 'fabs':''}}"
                                onclick="event.preventDefault(); document.getElementById('questions-favorite-{{$question->id}}').submit()">
                                <i class="fas fa-star fa-2x"></i>
                                <span class="faborite">
                                   {{$question->favorites_count}}
                                </span>
                            </a>
                             <form id="questions-favorite-{{$question->id}}"  method="post" action="{{route('questions.favorites', $question->id)}}" style="display: none">
                                    @csrf
                                    @if($question->is_favorited)
                                        @method('DELETE')
                                    @endif
                             </form>

                    </div>

                    <div class="media-body">
                        {!!$question->body_html!!}
                        <div class="float-right">
                            <span class="text-success">Questioned {{$question->user->name}}</span> <span class="text-muted">{{$question->create_date}}</span>
                            <div class="media">
                                <a class="pr-2" href="{{$question->user->url}}">
                                    <img src="{{$question->user->avatar}}">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>

    <!--  answers row -->
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h2>Your Answer</h2>
                        @include('layouts._message')
                        <hr>
                        <form method="post" action="{{route('questions.answers.store', $question->id)}}">
                            @csrf
                            <div class="form-group">
                                <textarea value="{{ old('body') }}" rows="7" class="form-control {{ $errors->has('body') ? ' is-invalid' : '' }}" name="body"></textarea>
                                @if ($errors->has('body'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-outline-success">Answer</button>
                            </div>
                        </form>
                        <hr>
                        <h3>{{$question->answers_count}}
                        {{str_plural('answer', $question->answers_count)}}
                        </h3>
                        <hr>
                        @foreach($question->answers as $answer)
                            <div class="media">
                                <div class="d-flex flex-column votes-control">

                                    <a class="vote-up {{Auth::guest() ? 'off' : ''}}" onclick="event.preventDefault(); document.getElementById('answers-vote-up{{$answer->id}}').submit();">
                                        <i class="fas fa-caret-up fa-3x"></i>
                                    </a>

                                    <span class="votes-count">{{$answer->votes_count}}</span>

                                    <form action="{{route('answers.vote', $answer->id)}}" id="answers-vote-up{{$answer->id}}"  method="post" style="display: none">
                                        @csrf
                                        <input type="hidden" name="vote" value="1">
                                    </form>

                                    <a href="" class="votes-down {{Auth::guest() ? 'off' : ''}}" onclick="event.preventDefault(); document.getElementById('answers-vote-down{{$answer->id}}').submit();">
                                        <i class="fas fa-caret-down fa-3x"></i>
                                    </a>

                                    <form action="{{route('answers.vote', $answer->id)}}" id="answers-vote-down{{$answer->id}}"  method="post" style="display: none">
                                        @csrf
                                        <input type="hidden" name="vote" value="-1">
                                    </form>

                                    @can('accept', $answer)
                                    <a href="" class="favourite mt-3 {{$answer->status}}" onclick="event.preventDefault(); document.getElementById('accept-answer-{{$answer->id}}').submit();">
                                        <i class="fas fa-check fa-2x"></i>
                                    </a>

                                    <form id="accept-answer-{{$answer->id}}" action="{{route('accept.answers', $answer->id)}}" method="post" style="display: none;">
                                        @csrf
                                    </form>

                                    @else
                                    @if($answer->is_best)
                                    <a class="favourite mt-3 {{$answer->status}}">
                                        <i class="fas fa-check fa-2x"></i>
                                    </a>
                                    @endif
                                    @endcan


                                </div>
                                <div class="media-body">
                                    {!! $answer->body_html !!}
                                    <div class="row">

                                        <div class="col-xl-4">
                                            <div class="float-right">
                                                <span class="text-success">Answered {{$answer->user->name}}</span> <span class="text-muted">{{$answer->create_date}}</span>
                                                <div class="media">
                                                <a href="{{$answer->user->url}}">
                                                    <img src="{{$answer->user->avatar}}">
                                                </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4"></div>

                                        <div class="col-xl-4">
                                            <div class="ml-auto d-inline">
                                                @can('update', $answer)
                                                <a href="{{route('questions.answers.edit', [$question->id, $answer->id])}}" class="btn btn-outline-primary">
                                                   Edit
                                                </a>
                                               @endcan
                                              </div>
                                            @can('delete', $answer)
                                            <form class="form-delete" action="{{route('questions.answers.destroy', [$question->id, $answer->id])}}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-secondary">Delete</button>
                                            </form>
                                            @endcan
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                     <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
