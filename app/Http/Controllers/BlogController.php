<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    public function CreateBlog(Request $request)
    {
        $datepublish = NULL;

        if($request->status == "publish")
        {
            $datepublish = Carbon::now();
        }

        Blog::create([
            'userid' => Auth::user()->id,
            'title' => $request->title,
            'content' => htmlentities($request->content),
            'status' => $request->status,
            'publish_date' => $datepublish
        ]);

        return redirect('/home');
    }

    public function DeleteBlog(Request $request)
    {
        Blog::where('id',$request->id)->delete();
        Comment::where('blogid',$request->id)->delete();
        return redirect('/');
    }

    public function Blog(Request $request)
    {
        $result = [];
        $comments = [];
        $blogs = DB::table('blogs')
        ->where('blogs.id',$request->id)
        ->join('users','users.id','blogs.userid')
        ->selectRaw('blogs.id as id, blogs.title as title, blogs.content as content, blogs.publish_date as publish_date, users.name as name')
        ->get();

        

        foreach($blogs as $blog)
        {
            $commentar = DB::table('comments')->join('users','users.id','comments.userid')->where('comments.blogid',$blog->id)
            ->selectRaw('comments.id as id, users.id as userid, users.name as name, comments.date as date, comments.comment as comment')
            ->get();
            foreach($commentar as $item)
            {
                $comments[] = [
                    'id' => $item->id,
                    'userid' => $item->userid,
                    'name' => $item->name,
                    'comment' => $item->comment,
                    'date' => $item->date,
                ];
            }
        }

        // dd($comments);
        // return $comments;
        // return $blogs;
        return view('blog_detail',[
            'blogsss' => $blogs,
            'comments' => $comments
        ]);
    }

    public function EditBlog(Request $request)
    {
        return view('edit_blog',[
            'blog' => Blog::where('id',$request->id)->get()
        ]);
    }

    public function PostEditBlog(Request $request)
    {
        $datepublish = NULL;

        if($request->status == "publish")
        {
            $datepublish = Carbon::now();
        }

        Blog::where('id',$request->id)->update([
            'title' => $request->title,
            'content' => htmlentities($request->content),
            'status' => $request->status,
            'publish_date' => $datepublish
        ]);

        return redirect('/home');
    }
}
