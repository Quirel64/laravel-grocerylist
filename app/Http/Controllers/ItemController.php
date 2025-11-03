<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Models\user;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    $categories = Category::all();
    $query = Item::query();
$useritem = auth()->user();


    $user = auth()->user();
    if (!$user || !$user->Premium) {
        $query->where('premium', false);
    }



    if ($request->has('category_id')) {
        $categoryIds = $request->input('category_id');
        $query->whereHas('categories', function($q) use ($categoryIds) {
            $q->whereIn('categories.id', $categoryIds);
        });
    }



    if ($request->has('item_id')) {
        $itemIds = $request->input('item_id');
        $query->whereIn('id', $itemIds);
    }

    if ($request->has('search')) {
    $searchTerm = $request->input('search');
    $query->where(function($q) use ($searchTerm) {
        $q->where('name', 'like', "%{$searchTerm}%")
          ->orWhere('description', 'like', "%{$searchTerm}%");
    });
}

$allItems = Item::all(); // for the select box

    $items = Item::orderByDesc('promoted_at')
             ->orderByDesc('created_at')
             ->paginate(10);


    return view('items.index', compact('items', 'categories', 'allItems', 'useritem'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        $categories = Category::all();
      //  $user = User::find($id);
        return view('items.create', compact('categories'));
    }

  /**
     * Store a newly created resource in storage.
     */

  public function store(StoreItemRequest $request) {
    $validated = $request->validated();
  

$validator = Validator::make($request->all(), (new StoreItemRequest())->rules());

if ($validator->fails()) {
    dd($validator->errors()->all());
}

    $validated['user_id'] = Auth::id();
    $validated['premium'] = $request->has('premium');
    //$validated['category_id'] = category::find('category_id'); the problem that overwrites category_id with null 

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
    
if (!empty($validated['category_id'])) {
    $item->categories()->sync($validated['category_id']);
}


//dd($request->all());

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


    public function promote(Item $item)
{
    $item->update(['promoted_at' => now()]);

    return redirect()->route('items.index')->with('success', 'Item promoted to top!');
}

}