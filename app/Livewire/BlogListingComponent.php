<?php

namespace App\Livewire;

use App\Models\Blog;
use Carbon\Carbon;
use Livewire\Component;

class BlogListingComponent extends Component
{

    public $blogs = [];
    public $featuredBlog;

    public function mount()
    {
        $this->featuredBlog = Blog::orderBy('id', 'desc')->first();
        $this->blogs = Blog::orderBy('id', 'desc')->skip(1)->take(3)->get();
    }
    public function formateDate($date)
    {
        return Carbon::parse($date)->format('M ,d Y'); // e.g. 29-07-2025
    }

    public function render()
    {

        return view('livewire.blog-listing-component');
    }
}
