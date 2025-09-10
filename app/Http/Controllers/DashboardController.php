<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\models\category;


class DashboardController extends Controller
{
    public function index(Request $request)
{
    $categories = Category::all();

    $query = Item::where('user_id', Auth::id());

    // Filter op categorieën
    if ($request->filled('category_id')) {
        $query->whereHas('categories', function ($q) use ($request) {
            $q->whereIn('categories.id', $request->category_id);
        });
    }

    // Sorteren
    if ($request->filled('sort_by') && in_array($request->sort_by, ['name','created_at','updated_at'])) {
        $query->orderBy($request->sort_by, $request->order === 'desc' ? 'desc' : 'asc');
    } else {
        $query->orderBy('created_at', 'desc');
    }

    $items = $query->get();

    return view('items.dashboard', compact('items', 'categories'));
}

}
