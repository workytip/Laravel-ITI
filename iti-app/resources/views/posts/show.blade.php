<h1>Post Details</h1>
<h3>Title :</h3>
<p>{{$post->title}}</p>
<hr>
<h3>Desctiprion :</h3>
<p>{{$post->description}}</p>
<hr>
<h3>Created By :</h3>
<p>{{$post->user->name}}</p>

<hr>
<h3>Created At :</h3>
<p>{{$post->created_at->isoFormat('dddd Do of MMMM YYYY, h:mm:ss A')}}</p>
<hr> 