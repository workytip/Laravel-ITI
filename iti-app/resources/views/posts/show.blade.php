@extends('layouts.nav')
@section('title') Show @endsection
@section('content')

{{dd($post)}}



<h3>{{$post->title}}</h3>
<hr>
<h3>Desctiprion :</h3>
<p>{{$post->description}}</p>
<hr>
<h5>Created By :</h5>
<p>{{$post->user->name}}</p>
<h5>Created At :</h5>
<p>{{$post->created_at->isoFormat('dddd Do of MMMM YYYY, h:mm:ss A')}}</p>
<hr> 
{{-- @foreach($post->comments as $comment)
<p>{{$comment}}</p>
@endforeach --}}

<form method="POST" action="{{route('comment.store',$post->id)}}">

    @csrf
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Post a Comment</label>
        <textarea name="body"  class="form-control" ></textarea>
      </div>

   
      <button type="submit" class="btn btn-success">Comment</button>
    </form>
    @endsection
