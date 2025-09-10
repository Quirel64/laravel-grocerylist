@extends('layouts.app')

@section('content')

    <h1>Nieuwe category Aanmaken</h1>
<form action="{{ route('category.store') }}" method="POST">
    @csrf
    <label for="name">Naam:</label>
    <input type="text" id="name" name="name" required>
    <br>
    <label for="description">Beschrijving:</label>
    <textarea id="description" name="description"></textarea>
    <br>


    <br>
    <button type="submit">Opslaan</button>

 
</form>



<h1>huidige categorieën</h1>

<table style='border:solid; border-color:blue; padding:10px; background-color: lavender;'>
<tr> 
    <td>naam &nbsp;</td>
    <td>Beschrijving</td>
</tr>
@foreach($Categories as $category)
<tr>
    <td>{{ $category->name }} &nbsp;&nbsp;</td>
    <td>{{ $category->description }}&nbsp;&nbsp;</td>
    
    <td>{{ $category->created_at->format('d-m-Y H:i') }}</td> <!-- Created At -->
    <td>{{ $category->updated_at->format('d-m-Y H:i') }}</td> <!-- Updated At -->
    <td>
        <!--<a href="{{ route('items.edit', $category->id) }}">Bewerken</a>-->
    </td>
    
</tr>
@endforeach

</table>
<h1>jouw categorieën</h1>

<table style='border:solid; border-color:blue; padding:10px; background-color: lavender;'>
<tr> 
    <td>naam &nbsp;</td>
    <td>Beschrijving</td>
</tr>
@foreach($userCategories as $category)
<tr>
    <td>{{ $category->name }} &nbsp;&nbsp;</td>
    <td>{{ $category->description }}&nbsp;&nbsp;</td>
    
    <td>{{ $category->created_at->format('d-m-Y H:i') }}</td> <!-- Created At -->
    <td>{{ $category->updated_at->format('d-m-Y H:i') }}</td> <!-- Updated At -->
    <td>
        <!--<a href="{{ route('items.edit', $category->id) }}">Bewerken</a>-->
    </td>
    <td>
        <form action="{{ route('category.destroy', $category->id)}}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Verwijderen</button>
        </form>
    </td>
</tr>
@endforeach
</table>
@endsection

