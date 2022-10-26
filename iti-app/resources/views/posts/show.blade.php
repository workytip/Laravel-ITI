@extends('layouts.app')
@section('title') Show @endsection
@section('content')

<div>
  <img src="/images/{{ $post->image }}" width="500px">
</div>
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
 {{-- show coments with delete --}}
@foreach($post->comments as $comment)
<p class="text-info">{{$comment->body}}</p>
<form method="POST" action="{{route('comment.delete',$comment->id)}}">
  @method('DELETE')
  @csrf
  <button type="submit" class="btn btn-danger">Delete</button>
</form>
{{-- <a href="{{route('comment.edit',$comment->id)}}" class="btn btn-info edit" onclick="show()" >Edit</a> --}}

 {{-- <div style="display: none" class="editComment"> --}}
<form method="POST" action="{{route('comment.update',$comment->id)}}">
  @method('PUT')
  @csrf
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Edit a Comment</label>
      <textarea name="body"  class="form-control" >{{$comment->body}}</textarea>
    </div>
    <button type="submit" class="btn btn-primary" onclick="hide()">Update</button>
  </form>
 {{-- </div> --}}
 @endforeach

<form method="POST" action="{{route('comment.store',$post->id)}}">

    @csrf
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Post a Comment</label>
        <textarea name="body"  class="form-control" ></textarea>
      </div>

   
      <button type="submit" class="btn btn-success">Comment</button>
    </form>
@endsection
