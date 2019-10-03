<?php

namespace App\Composers;

use Illuminate\View\View;

class DashboardComposer
{

    public function compose(View $view)
    {
        $view->with('route', request()->segments()[0]);
    }
}
