@extends('layouts.app')

@section('title') Edit @endsection
@section('content')
        <form method="POST" action="{{route('profile.update',auth()->user()->id)}}" enctype="multipart/form-data">
          @csrf
          @method('PUT')
            <div class="mb-3">
              <label  class="form-label">Name</label>
              <input type="text" name="name" class="form-control" value="{{$user->name}}">
            </div>

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email</label>
                <input type="text" name="email" class="form-control" value="{{$user->email}}" >
              </div>
              <div class="mb-3">
                <label  class="form-label">Password</label>
                <input type="password" name="password" class="form-control" >
              </div>

     
              {{-- <div class="mb-3">
                <label  class="form-label">Image</label>
                <img src="/images/{{ $user->image }}" width="300px">
                <input type="file" name="image" class="form-control" placeholder="image">
              </div> --}}
            <button type="submit" class="btn btn-primary">Update</button>
          </form>
   
@endsection
