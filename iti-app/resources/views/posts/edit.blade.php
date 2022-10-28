@extends('layouts.app')

@section('title') Edit @endsection
@section('content')
        <form method="POST" action="{{route('posts.update',$post->id)}}" enctype="multipart/form-data">
          @csrf
          @method('PUT')
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Title</label>
              <input type="text" name="title" class="form-control" value="{{$post->title}}">
            </div>

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Description</label>
                <input type="text" name="description" class="form-control" value="{{$post->description}}" >
              </div>

              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Post Creator</label>
                <select class="form-control" name="post_creator">
                  @foreach ($allUsers as $user)
                  <option value="{{$user->id}}">{{ $user->name }}</option>
                 @endforeach
                </select>
              </div>
              <div class="mb-3">
                <label  class="form-label">Image</label>
                <img src="{{ url('storage/images/'.$post->image )}}" width="300px">
                <input type="file" name="image" class="form-control" placeholder="image">
              </div>
            <button type="submit" class="btn btn-primary">Update</button>
          </form>
   
@endsection
