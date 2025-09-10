<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\user;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{

    
    $categories = Category::all();
    $query = Item::query();

$user = auth()->user();
    if (!$user || !$user->Premium) {
        // Alleen niet-premium items tonen aan niet-premium gebruikers
        $query->where('premium', false);
    }

    // Filteren op categorieën als er categorieën zijn geselecteerd
    if ($request->has('category_id')) {
        $categoryIds = $request->input('category_id');
        $query->whereHas('categories', function($q) use ($categoryIds) {
            $q->whereIn('categories.id', $categoryIds);
        });
    }

    $items = $query->get();
    
    return view('items.index', compact('items', 'categories'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        $categories = Category::all();
        
        return view('items.create', compact('categories'));
    }

  /**
     * Store a newly created resource in storage.
     */

  public function store(StoreItemRequest $request) {
    $validated = $request->validated();
    $validated['user_id'] = Auth::id();
    $validated['premium'] = $request->has('premium');


    if ($request->hasFile('image')) {
        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('images'), $imageName);
        $validated['image_path'] = $imageName;
    }

   $item = Item::create([
    'name' => $validated['name'],
    'description' => $validated['description'] ?? null,
    'user_id' => $validated['user_id'],
    'image_path' => $validated['image_path'] ?? null,
    'premium' => $validated['premium'], 
]);


    $item->categories()->attach($validated['category_id']);

    return redirect()->route('items.index');
}

    /**
     * Show the form for editing the specified resource.
     */
public function edit($id) {
    $categories = Category::all();
    $item = Item::with('categories')->findOrFail($id); // eager load categories

    return view('items.edit', compact('item', 'categories'));
}


  /**
     * Update the specified resource in storage.
     */
public function update(UpdateItemRequest $request, Item $item) {
    $validated = $request->validated();
$validated = $request->validated();
$validated['premium'] = $request->has('premium');

    if ($request->hasFile('image')) {
        // Verwijder oude afbeelding als die bestaat
        if ($item->image_path && file_exists(public_path('images/'.$item->image_path))) {
            unlink(public_path('images/'.$item->image_path));
        }

        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('images'), $imageName);
        $validated['image_path'] = $imageName;
    }

    $item->update([
        'name' => $validated['name'],
        'description' => $validated['description'] ?? null,
        'image_path' => $validated['image_path'] ?? $item->image_path,
        'premium' => $validated['premium'],
    ]);

    $item->categories()->sync($validated['category_id']);

    return redirect()->route('items.index');
}

 /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = Item::with('categories')->find($id);
    
        return view('items.show', compact('item'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        $item = Item::find($id);
        if ($item) {
            $item->delete();
        }
        return redirect()->route('items.index');
    }
}