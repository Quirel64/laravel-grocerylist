@extends('layouts.app')

@section('content')


<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="btn btn-link">Logout</button>
</form>

<h1>login page</h1>

<h2>what does logging in do?</h2>
<h2>when you log in or create an account you can:</h2>
<h3>have your own personal dashboard so you can see your own posts.</h3>
<h3>you can also edit your posts whenever you see fit from the dashboard page.</h3>
<h3>and you can comment on all posts.</h3>

<form method="POST" action="{{ route('login') }}">
    @csrf
    <label for="email">E-mail:</label>
    <input type="email" name="email" required>

    <label for="password">Wachtwoord:</label>
    <input type="password" name="password" required>

    <button type="submit">Inloggen</button>
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