@extends('layouts.app')

@section('content')
<h2>om een account aan te maken hebben we je naam, email en een wachtwoord nodig</h2>
<form method="POST" action="{{ route('register') }}">
    @csrf
    <label for="name">Naam:</label>
    <input type="text" name="name" required>

    <label for="email">E-mail:</label>
    <input type="email" name="email" required>

    <label for="password">Wachtwoord:</label>
    <input type="password" name="password" required>

    <label for="password_confirmation">Bevestig Wachtwoord:</label>
    <input type="password" name="password_confirmation" required>

    <button type="submit">Registreren</button>
</form>

@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@endsection
