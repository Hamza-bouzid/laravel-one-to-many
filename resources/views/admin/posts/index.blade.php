@extends('layouts.app')

@section('title', 'Posts')
  


@section('content')
<div class="container">
  <header>
    <nav>
      <a href="{{ route('admin.home') }}"><button class="btn btn-show">Home</button></a>
      <a href="{{route('admin.posts.create')}}"><button class="btn btn-edit">New Post</button></a>
    </nav>
    <h1>Posts</h1>
  </header>

  <main>
    <div class="posts">
      @foreach ($posts as $post)
      <div class="post">
        <div class="post-title">
         <h2>{{$post->title}}</h2>
        </div>
        <div class="post-content">
         <p>{{$post->content}}</p>
        </div>
        <div class="post-category">
         <p>Post Category: <span> {{$post->category ? $post->category->name : '-'}}</span></p>
        </div>
     
        <div class="buttons">
          <a href="{{route("admin.posts.show", $post->id)}}"><button class="btn btn-show">Show</button></a>
          <a href="{{route("admin.posts.edit", $post->id)}}"><button class="btn btn-edit">Edit</button></a>
          <form action="{{route("admin.posts.destroy", $post->id)}}" method="POST">
            @csrf
            @method("DELETE")
            <button class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this Post?');">Delete</button>
        </form>
        </div>
      </div> 
      @endforeach   
     </div>
  </main>

</div>
@endsection