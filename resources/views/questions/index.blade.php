@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  <h3 class="float-left">All Quesions</h3>
                  <h3 class="float-right"><a href="{{route('questions.create')}}" class="btn btn-outline-secondary">Create Questions</a></h3>
                </div>
                    <div class="card-body">
                      @include('layouts._message')
                      @foreach($questions as $question) 
                       <div class="media">
                             <div class="d-flex flex-column counters">
                                <div class="votes">
                                  <strong>{{$question->votes_count}} Votes</strong>
                                  
                                </div>                                
                                <div class="views">
                                  <strong>{{$question->views}} </strong>
                                  {{str_plural('view', $question->views)}}
                                </div>                                
                                <div class="status {{$question->status}}">
                                  <strong>{{$question->answers_count}} Answers</strong>
                                </div>
                              </div>
                           <div class="media-body">
                               <div class="d-flex align-items-center">
                                  <h3 class="mt-0 text-info">
                                    <a href="{{$question->url}}">{{$question->title}}</a>
                                  </h3>
                                  <div class="ml-auto">
                                    @can('update', $question)
                                    <a href="{{route('questions.edit', $question->id)}}" class="btn btn-outline-primary">
                                       Edit
                                  </a>
                                    @endcan
                                  </div>
                                    @can('delete', $question)
                                    <form class="form-delete" action="{{route('questions.destroy', $question->id)}}" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-secondary">Delete</button>
                                    </form>
                                    @endcan
                               </div>
                               <p>Asked By <a class="text-danger">{{$question->user->name}} &nbsp;</a><span class="text-muted">{{$question->create_date}}</span></p>
                               <p>{{str_limit($question->body, 250)}}</p>
                           </div>
                           <hr>
                       </div> 
                       <hr>
                       @endforeach
                       <div class="pagination justify-content-center">
                          {{$questions->links()}}
                      </div>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
