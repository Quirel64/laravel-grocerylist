@extends('layouts.app') {{-- or your actual layout file --}}

@section('content')
    <h1>{{ $user->name }}'s Profile</h1>
    <p>Email: {{ $user->email }}</p>
<a href="{{ route('messages.create', $user->id) }}">Send Message</a>

    <h2>Items Created:</h2>
    @if($items->isEmpty())
        <p>No items created yet.</p>
    @else
    <p>click for info and get to the comments page of the item</p>
        <ul>
            @foreach($items as $item)
                <li>
                      <a href="{{ route('items.comments', ['id' => $item->id]) }}">item: {{ $item->name }}</a>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
