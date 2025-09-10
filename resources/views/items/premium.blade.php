@extends('layouts.app')

@section('title', 'page title')

@section('content')

<H1>become a member</H1>
<h2>als een premium gebruiker kan je naar premium gemarkeerde posts kijken</h2>

<form method="POST" action="{{ route('premium.activate') }}">
    @csrf
    <button type="submit">Word nu een Premium gebruiker (gratis)</button>
</form>

premium status verwijderen
<form method="POST" action="{{ route('premium.deactivate') }}">
    @csrf
    <button type="submit">verwijder de Premium status (ook gratis)</button>
</form>

@endsection

@if(auth()->user()->Premium)
    <div style="color: gold; font-weight: bold;">
         Je bent een premium gebruiker!
    </div>
@else
    <div style="color: gray;">
        Je hebt nog geen premium status.
    </div>
@endif
