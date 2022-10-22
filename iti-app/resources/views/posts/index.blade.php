@extends('layouts.app')

@section('title') Index @endsection
@section('content')
<div class="text-center">
  <a href="{{route('posts.create')}}" class="mt-4 btn btn-success">Create Post</a>
</div>
@if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}  
    </div>
  @endif

<table class="table mt-4">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Title</th>
      <th scope="col">Posted By</th>
      <th scope="col">Created At</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($posts as $post)
      <tr>
        <td>{{$post['id']}}</th>
        <td>{{$post['title']}}</td>
        <td>{{$post['posted_by']}}</td>
        <td>{{$post['creation_date']}}</td>
        <td>
            <a href="{{route('posts.show', $post['id'])}}" class="btn btn-info">View</a>
            {{-- <a href="{{route('posts.show', ['post' =>$post['id']])}}" class="btn btn-info">View</a> --}}
            <a href="{{route('posts.edit',$post['id'])}}" class="btn btn-primary">Edit</a>
            <!-- <a href="{{route('posts.delete',$post['id'])}}" class="btn btn-danger">Delete</a> -->
            <a onclick="return confirm('Are you sure?')">
            <form action="{{ route('posts.delete', $post['id'])}}" method="post">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger"   type="submit">Delete</button>
            </form>
          </a>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
@endsection
