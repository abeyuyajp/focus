<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Post;
use App\Join;

class JoinController extends Controller
{
    public function store(Request $request)
    {
        #dd($request->all());

        $join = new Join;
        $join->from_user_id      =      Auth::user()->id;
        $join->post_id      =      $request->post_id;
        $join->save();

        return redirect(url('/calendar'));
    }
}
