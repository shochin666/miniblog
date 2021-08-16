@extends('layouts.app')

@section('content')
  <div class="container">
    @foreach($posts as $post)
      <div class="card">
        <div class="card-header">{{ $post->user->name }}</div>
        <div class="card-body">
          <p class="card-text">{{ $post->body }}</p>

          <p class="card-text"><a href="{{ route('posts.show', $post->id) }}">詳細を見る</a></p>

          @if(Auth::id() === $post->user_id)
            <form method="POST" action="{{ route('posts.delete', $post->id) }}">
              @csrf
              <button type="submit" class="btn btn-danger">削除</button>
            </form>
          @endif

          @auth
               @unless($post->bookmarkingUsers->contains(Auth::id()))
               <form method="POST" action="{{ route('bookmarks.add', $post->id) }}">
                    @csrf
                    <button type="submit" class="btn btn-success">ブックマークする</button>
               </form>
               @else
               <form method="POST" action="{{ route('bookmarks.remove', $post->id) }}">
               @csrf
               <button type="submit" class="btn btn-danger">ブックマークを解除する</button>
               </form>

               @endunless
          @endauth
          

        </div>
      </div>


    
    @auth
      <div class="card">
        <div class="card-header">{{ Auth::user()->name }}</div>
          <div class="card-body">
            <form method="POST" action="{{ route('posts.reply', $post->id) }}">
              @csrf
              <div class="form-group">
                <textarea name="body" class="form-control" rows="3"></textarea>
              </div>
              <button type="submit" class="btn btn-primary">返信する</button>
            </form>
          </div>
        </div>
    @endauth
    @endforeach
  </div>
@endsection