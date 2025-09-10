@extends('layouts.app')

@section('title', 'Page Title')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />

@section('content')
<h1>Item Bewerken</h1>

<form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label for="name">Naam:</label>
    <input type="text" id="name" name="name" value="{{ $item->name }}" required>
    <br>

    <label for="description">Beschrijving:</label>
    <textarea id="description" name="description">{{ $item->description }}</textarea>
    <br>

    <label for="category">Categorie:</label>
    <select name="category_id[]" id="category" multiple>
        @foreach($categories as $category)
            <option value="{{ $category->id }}"
                {{ $item->categories->contains($category->id) ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    <br>

    {{-- Huidige afbeelding tonen indien aanwezig --}}
    @if($item->image_path && file_exists(public_path('images/' . $item->image_path)))
        <p>Huidige afbeelding:</p>
        <img src="{{ asset('images/' . $item->image_path) }}"
             alt="{{ $item->name }}"
             style="max-width:150px; height:auto; margin-bottom:10px;">
    @else
        <p><em>Geen afbeelding gekoppeld</em></p>
    @endif

    {{-- Nieuw afbeeldingsveld --}}
    <label for="image">Nieuwe afbeelding (optioneel):</label>
    <input type="file" name="image" id="image" accept="image/*">
    <br>
    <label for="premium">
    <input type="checkbox" name="premium" id="premium" value="1" {{ $item->premium ? 'checked' : '' }}>
    Markeer als premium content
</label>
<br>

    <button type="submit">Bijwerken</button>
</form>

<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script>
  const element = document.getElementById('category');
  new Choices(element, { removeItemButton: true });
</script>
@endsection
