@extends('layouts.app')

@section('content')
    <h1>Your Inbox</h1>

    @if($messages->isEmpty())
        <p>No messages yet.</p>
    @else
        <ul>
            @foreach($messages as $message)
                <li>
                    <strong>From:</strong> {{ $message->sender->name }}<br>
                    <strong>Sent:</strong> {{ $message->created_at->format('Y-m-d H:i') }}<br>
                    <strong>Message:</strong> {{ $message->content }}
                </li>
                <hr>
            @endforeach
        </ul>
    @endif
@endsection
