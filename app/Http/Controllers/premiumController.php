<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\user;

class premiumController extends Controller
{
  public function upgrade(Request $request)
{
$user = auth()->user();

if (!$user->premium) {
    $user->premium = true;
    $user->save();
}

    return redirect()->back()->with('success', 'Je bent nu premium!');
}




  public function downgrade(Request $request) 
  {
$user = auth()->user();

if ($user->Premium) {
    $user->Premium = 0;
    $user->save();
}

    return redirect()->back()->with('success', 'Je bent nu niet meer premium!');
}

}
