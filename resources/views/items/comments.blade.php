
@section('content')

@extends('layouts.app')
<a href="{{ route('messages.show', $item->user->id) }}" style='float:right;'>
    Stuur persoonlijk bericht naar {{ $item->user->name }}
</a>

<h2>naam artikel: {{ $item->name }}</h2>

<h3>gemaakt door: {{ $item->user->name }}</h3>
<p> beschrijving: {{ $item->description }}</p>

<h3>Laat commentaar achter of doe een openbaar bod</h3>
<form action="{{ route('comments.store') }}" method="POST">
    @csrf
    <input type="hidden" name="item_id" value="{{ $item->id }}">
    
    <textarea name="content" required></textarea>
    <button type="submit">Post Comment</button>
</form>





<h3>Comments</h3>
@foreach($item->comments as $comment)
<div>
    <strong>{{ $comment->user->name }}</strong> said:
    <p>{{ $comment->content }}</p>
    <small>{{ $comment->created_at->diffForHumans() }}</small>
</div>
@endforeach

@endsection