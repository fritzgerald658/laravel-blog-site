<?php

namespace App\View\Components\Blog;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Like extends Component
{

    public $blog;

    public function __construct($blog)
    {
        $this->blog = $blog;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.blog.like');
    }
}
