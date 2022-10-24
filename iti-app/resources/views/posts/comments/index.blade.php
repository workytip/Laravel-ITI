@extends('layouts.app')

@section('title') Index @endsection
@section('content')
<div class="text-center">
  <a href="{{route('posts.create')}}" class="mt-4 btn btn-success">Create Post</a>
</div>

@if(request()->has('view_deleted'))

<a href="{{ route('posts.index') }}" class="btn btn-info">View All posts</a>

<a href="{{ route('posts.restore.all') }}" class="btn btn-success">Restore All</a>

@else

<a href="{{ route('posts.index', ['view_deleted' => 'DeletedRecords']) }}" class="btn btn-primary">View Delete Records</a>

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
        <td>{{$post->title}}</td>
        @if($post->user)
          <td>{{$post->user->name}}</td>
        @else
          <td>Not Defined</td>
        @endif
        <td>{{$post->created_at->toDateString()}}</td>
        <td>
            <a href="{{route('posts.show', $post['id'])}}" class="btn btn-info">View</a>
            <a href="{{route('posts.edit',$post['id'])}}" class="btn btn-primary">Edit</a>
            {{-- <x-button typee="info" msg="Delete"></x-button> --}}

             @if(request()->has('view_deleted'))

            <a href="{{ route('posts.restore', $post->id) }}" class="btn btn-success">Restore</a>

        @else
             
                <button class="btn btn-danger" data-toggle="modal" data-target="#delete">Delete</button> 

<!-- Modal -->
 <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Deleting Post</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are You Sure You Want Delete This Post ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

        <form action="{{ route('posts.delete', $post['id'])}}" method="post">
          @csrf
          @method('DELETE')
          <button class="btn btn-danger"  type="submit">Delete</button>
        </form>
            </div>
    </div>
  </div>
</div> 
             
       @endif

        </td>
      </tr>
    @endforeach
  </tbody>
</table> 

<div class="d-flex justify-content-center">
  {{ $posts->links() }}

</div>
@endsection

