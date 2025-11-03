<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Item;

class UserController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        $items = Item::where('user_id', $id)->get();

        return view('items.profile', compact('user', 'items'));
    }
}
