<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\user;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userCategories = Category::orderBy('created_at', 'asc')->where('user_id', Auth::id())->get(); 
        $Categories = Category::orderBy('created_at', 'asc')->get(); 
        return view('items.category', compact('Categories'), compact('userCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        $categories = Category::all();
        
        return view('items.category', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(StoreCategoryRequest $request) {
        $validated = $request->validated();
        
        $validated['user_id'] = Auth::id();
        Category::create($validated);
       
       
        return redirect()->route('items.category');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
    $category = Category::find($id);

    if ($category) {
        $category->delete();
    }

    return redirect()->route('items.category')->with('success', 'Categorie verwijderd!');
}

}
