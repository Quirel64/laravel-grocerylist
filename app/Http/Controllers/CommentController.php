<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Models\Comment;

class CommentController extends Controller
{


public function create($id)
{
    $item = Item::with('comments.user')->findOrFail($id);
    return view('items.comments', compact('item'));
}



    public function store(Request $request)
{
    $request->validate([
        'content' => 'required|string|max:1000',
        'item_id' => 'required|exists:items,id',
    ]);

    Comment::create([
        'user_id' => auth()->id(),
        'item_id' => $request->item_id,
        'content' => $request->content,
    ]);

    return back()->with('success', 'Comment added successfully!');
}

}
