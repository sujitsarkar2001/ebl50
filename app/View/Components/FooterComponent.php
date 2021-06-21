<?php

namespace App\View\Components;

use App\Models\Page;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FooterComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        $pages = Page::select(['name', 'slug'])->where('status', true)->get();
        return view('components.footer-component', compact('pages'));
    }
}
