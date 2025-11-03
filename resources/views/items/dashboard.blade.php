@extends('layouts.app')

@section('title', 'Dashboard')

{{-- Choices.js CSS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />

@section('content')
<h1>Dashboard</h1>
@if(auth()->user()->Premium)
    <div style="color: gold; font-weight: bold;">
        ⭐ Je bent een premium gebruiker!
    </div>
@else
    <div style="color: gray;">
        Je hebt nog geen premium status.
    </div>
@endif


<a href=""></a>

<p>Welkom, {{ Auth::user()->name ?? 'gast' }}!</p>

{{-- FILTER FORM --}}
<form action="{{ route('dashboard') }}" method="GET" style="margin-bottom:1em;">
    <h2>Filteren op categorieën</h2>
    <select name="category_id[]" id="category" multiple>
        @foreach($categories as $category)
            <option value="{{ $category->id }}"
                {{ (collect(request()->input('category_id'))->contains($category->id)) ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    <button type="submit">Filter</button>
</form>

<table>
    <thead>
        <tr>
            <th>promoted</th>
            <th>premium</th>
            <th>imgage</th>
            <th>Naam artikel</th>
            <th>beschrijving</th>
            <th>categorie</th>
            <th>datum toevoeging</th>
            
            <th>commentaar toevoegen</th>
            <th>gemaakt door</th>
        </tr>
    </thead>
   <tbody>
    @forelse($items as $item)
    
        <tr>
            {{-- Afbeeldingskolom met check op bestaan --}}
          
            @if($item->promoted_at)
    <td style="color: green;">Promoted</td>
    @else <td>standaard</td>
@endif

@if($item->premium)
<td style="color: gold;"> Premium</td>
@else <td>openbaar</td>
@endif
            <td>
                @if($item->image_path && file_exists(public_path('images/' . $item->image_path)))
                    <img src="{{ asset('images/' . $item->image_path) }}"
                         alt="{{ $item->name }}"
                         style="max-width:80px; height:auto;">
                @else
                    <em>Geen afbeelding</em>
                @endif
            </td>



            {{-- Naam --}}
            <td>{{ $item->name }}</td>

            {{-- Inhoud / beschrijving --}}
            <td>{{ $item->description ?? '-' }}</td>

            {{-- Meerdere categorieën in één cel --}}
            <td>
                @if ($item->categories && $item->categories->count())
                    @foreach ($item->categories as $category)
                        {{ $category->name }}@if (!$loop->last), @endif
                    @endforeach
                @else
                    <em>Geen categorieën</em>
                @endif
            </td>

            {{-- Datum toevoeging --}}
            <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>

            {{-- Acties: bewerken + verwijderen --}}
            <td>
               <a href="{{ route('items.comments', ['id' => $item->id]) }}">Comment</a>
           <td>
    @if($item->user)
        <a href="{{ route('users.show', $item->user->id) }}">
            {{ $item->user->name }}
        </a>
    @else
        Unknown
    @endif
</td>


<td><form action="{{ route('items.promote', $item->id) }}" method="POST">
    @csrf
    <button type="submit">Promote to Top</button>
</form>
</td>

        </tr>
    @empty
        <tr>
            <td colspan="6"><em>Geen items gevonden.</em></td>
        </tr>
    @endforelse


    
    </tbody>
</table>


@endsection

{{-- Choices.js script --}}
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script>
    window.onload = function() {
        const element = document.getElementById('category');
        if(element){
            new Choices(element, { removeItemButton: true });
        }
    }
</script>
