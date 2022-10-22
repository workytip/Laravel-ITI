@extends('layouts.app')
@extends('layouts.nav')


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
          
            <a href="{{route('posts.show', $post['id'])}}" >
            <x-button typee="info" msg="View"></x-button>

            </a>
            <a href="{{route('posts.edit',$post['id'])}}" >
            <x-button typee="Primary" msg="Edit"></x-button>
            </a>
            <a onclick="return confirm('Are you sure?')">
            <form action="{{ route('posts.destroy', $post['id'])}}" method="post">
                  @csrf
                  @method('DELETE')
                  <x-button typee="danger" msg="Delete" type="submit"></x-button>
            </form>
          </a>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
@endsection
