@extends('layouts.app')

@section('content')
    <h1>Send Message to {{ $receiver->name }}</h1>

    <form method="POST" action="{{ route('messages.store') }}">
        @csrf
        <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">

        <div>
            <label for="content">Message:</label>
            <textarea name="content" id="content" rows="4" required></textarea>
        </div>

        <button type="submit">Send</button>
    </form>
@endsection
