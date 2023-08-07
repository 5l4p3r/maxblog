<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function CreateComment(Request $request)
    {
        Comment::create([
            'userid' => Auth::user()->id,
            'blogid' => $request->blogid,
            'comment' => $request->commentar,
            'date' => Carbon::now()
        ]);

        return redirect('/blog?id='.$request->blogid);
    }

    public function DeleteComment(Request $request)
    {
        return Comment::where('id',$request->id)->delete();
    }
}
