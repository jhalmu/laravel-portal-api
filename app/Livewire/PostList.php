<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\Tag;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class PostList extends Component
{
    use WithPagination;

    #[Url()]
    public $sort = 'desc';

    #[Url()]
    public $search = '';

    #[Url()]
    public $tag = '';

    public function setSort($sort)
    {
        $this->sort = ($sort === 'desc') ? 'desc' : 'asc';
    }

    #[On('search')]
    public function updateSearch($search)
    {
        $this->search = $search;
        $this->resetPage();
    }

   public function clearFilters()
   {
        $this->search = '';
        $this->tag = '';
        $this->resetPage();
   }


    #[Computed()]
    public function posts()
    {
        return Post::published()
        ->orderBy('published_at', $this->sort)
        ->when($this->activeTag, function ($query) {
            $query->withTag($this->tag);
    })
        ->where('title', 'like', "%{$this->search}%")
        ->paginate(3);
    }

    #[Computed()]
    public function activeTag()
    {
        return Tag::where('slug', $this->tag)->first();
    }


    public function render()
    {
        return view('livewire.post-list');
    }
}
