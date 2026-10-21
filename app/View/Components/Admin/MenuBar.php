<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MenuBar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $menus = [
            [
                'label' => 'Dashboard',
                'url' => route('admin.dashboard'),
                'icon' => 'ri-dashboard-3-line',
                'active' => request()->routeIs('admin.dashboard'),
            ],
            [
                'label' => 'Registration',
                'url' => route('admin.register.index'),
                'icon' => 'ri-user-add-line',
                'active' => request()->routeIs('admin.register.*'),
            ],
            [
                'label' => 'Enquiries',
                'url' => route('admin.enquiry.index'),
                'icon' => 'ri-mail-open-line',
                'active' => request()->routeIs('admin.enquiry.*'),
            ],
            [
                'label' => 'Services',
                'url' => route('admin.service.index'),
                'icon' => 'ri-service-line',
                'active' => request()->routeIs('admin.service.*'),
            ],
            [
                'label' => 'FAQs',
                'url' => route('admin.faq.index'),
                'icon' => 'ri-question-answer-line',
                'active' => request()->routeIs('admin.faq.*'),
            ],
            [
                'label' => 'Pages',
                'url' => route('admin.page.index'),
                'icon' => 'ri-pages-line',
                'active' => request()->routeIs('admin.page.*'),
            ],
        ];

        return view('components.admin.menu-bar', compact('menus'));
    }
}
