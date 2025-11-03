@extends('layouts.app')

@section('title', 'Page Title')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />

@section('content')


<h1>Artikelen</h1>

<form action="{{ route('items.index') }}" method="GET">
    <h2>filteren op categorieën</h2>
    <select name="category_id[]" id="category" multiple>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ (collect(request()->input('category_id'))->contains($category->id)) ? 'selected' : '' }}>{{ $category->name }}</option>
        @endforeach
    </select>
    <button type="submit">Filter</button>
</form>


<form action="{{ route('items.index') }}" method="GET">
    <h2>zoek een item</h2>
    <select name="item_id[]" id="item" multiple>
        @foreach($allItems as $item)
            <option value="{{ $item->id }}" {{ (collect(request()->input('item_id'))->contains($item->id)) ? 'selected' : '' }}>
                {{ $item->name }}
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
</td>
<td>
    @if($item->user)
        <a href="{{ route('users.show', $item->user->id) }}">
            {{ $item->user->name }}
        </a>
    @else
        Unknown
    @endif
</td>




        </tr>
    @empty
        <tr>
            <td colspan="6"><em>Geen items gevonden.</em></td>
        </tr>
    @endforelse


    
    </tbody>
</table>
<div style= "width:100px; height:10px">
{{ $items->appends(request()->query())->links() }}

</div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script>
    window.onload = function() {
        const categoryElement = document.getElementById('category');
        const itemElement = document.getElementById('item');

        new Choices(categoryElement, { removeItemButton: true });
        new Choices(itemElement, { removeItemButton: true });
    }
</script>
