@extends('layouts.template')

@section('title', $post->title)
  


@section('content')
<div class="container">
  <header>
    <nav>
      <a href="{{ route('admin.home') }}"><button class="btn btn-show">Home</button></a>
      <a href="{{route('admin.posts.index')}}"><button class="btn btn-show">Back to Posts</button></a>
    </nav>
  </header>

  <main>
    <div class="show">
      <h2>{{$post->title}}</h2>
      <p>{{$post->content}}</p>
      @if($post->image)
      <img src="{{asset("storage/{$post->image}")}}">
      @endif
      <p>Post Category: <span> {{$post->category ? $post->category->name : '-'}}</span></p>
      <div class="buttons">
        <a href="{{route("admin.posts.edit", $post->id)}}"><button class="btn btn-edit">Edit</button></a>
        <form action="{{route("admin.posts.destroy", $post->id)}}" method="POST">
          @csrf
          @method("DELETE")
          <button class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this Post?');">Delete</button>
        </form>
      </div>
    </div>
    
  </main>
</div>
@endsection