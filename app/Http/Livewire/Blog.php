<?php

namespace App\Http\Livewire;

use App\Models\Blog as ModelsBlog;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Blog extends Component
{
    use WithPagination;
 
    public $search = '';
 
    public function updatingSearch()
    {
        $this->resetPage();
    }
 
    
    public function render()
    {
        return view('livewire.blog',[
            'blogs' => DB::table('blogs')
            ->join('users','users.id','blogs.userid')
            ->selectRaw('blogs.userid as userid, blogs.id as id, blogs.title as title, blogs.content as content, users.name as name, blogs.publish_date as publish_date')
            ->where('blogs.title', 'like', '%'.$this->search.'%')
            ->where('status','publish')->orderBy('id','DESC')->paginate(10)
        ]);
    }
}
