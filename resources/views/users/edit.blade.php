@extends('layouts.app')

@section('content')
  @foreach($errors->all() as $message)
    <div>{{ $message }}</div>
  @endforeach

  @if(Session::has('message'))
    <div>{{ Session::get('message') }}</div>
  @endif

  <form method="POST" action="{{ route('users.update') }}">
    @csrf
    <label>名前: </label><input name="name" type="text" value="{{ $user->name }}" />
    <label>メールアドレス: </label><input name="email" type="email" value="{{ $user->email }}" />
    <button type="submit">変更</button>
  </form>
@endsection