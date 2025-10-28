<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function suggestions(Request $request)
    {
        $term = $request->get('term');
        $users = User::where('name', 'LIKE', "%$term%")
            ->select('id', 'name')
            ->limit(10)
            ->get();

        return response()->json($users);
    }
}
