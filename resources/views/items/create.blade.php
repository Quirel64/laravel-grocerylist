@extends('layouts.app')

@section('title', 'Page Title')
@if ($errors->any()) ... @endif

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />

    <h1>Nieuw Item Aanmaken</h1>
<form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label for="name">Naam:</label>
    <input type="text" id="name" name="name" required>

    <label for="description">Beschrijving:</label>
    <textarea id="description" name="description"></textarea>

    <label for="category">Categorie:</label>
    <select name="category_id[]" id="category" required multiple>
        @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>

    <label for="image">Afbeelding:</label>
    <input type="file" name="image" id="image" accept="image/*">

    <label for="premium">
    <input type="checkbox" name="premium" id="premium" value="1">
    Markeer als premium content
</label>

 <br>
    <button type="submit">Opslaan</button>
</form>


<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script>
  const element = document.getElementById('category');
  const choices = new Choices(element, {
    removeItemButton: true,
  });
</script>

@endsection

