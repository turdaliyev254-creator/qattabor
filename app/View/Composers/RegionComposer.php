<?php

namespace App\View\Composers;

use App\Models\Region;
use Illuminate\View\View;

class RegionComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $regions = Region::active()->ordered()->get();
        $view->with('regions', $regions);
    }
}
