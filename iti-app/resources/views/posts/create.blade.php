@extends('layouts.app')

@section('title') create @endsection
@section('content')
        <form method="POST" action="{{route('posts.store')}}" enctype="multipart/form-data">
          @csrf
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Title</label>
              <input name="title" type="text" class="form-control"  value="{{ old('title') }}">
            </div>

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Description</label>
                <textarea name="description" class="form-control" >{{ old('description') }}</textarea>
              </div>

              <div class="mb-3">
                <label  class="form-label">Post Creator</label>
                <select name="post_creator" class="form-control">
                  @foreach ($allUsers as $user)
                    <option value="{{$user->id}}">{{ $user->name }}</option>
                  @endforeach
                </select>
              </div>

              <div class="mb-3">
                <label  class="form-label">Image</label>
                <input type="file" name="image" class="form-control" placeholder="image">
              </div>
         
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
   
@endsection
