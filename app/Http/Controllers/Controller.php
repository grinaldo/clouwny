<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $cacheShort;
    protected $cacheMedium;
    protected $cacheLong;

    public function __construct() 
    {
        $this->cacheShort  = env('CACHE_BUFFER_SHORT', 1);
        $this->cacheMedium = env('CACHE_BUFFER_MEDIUM', 15);
        $this->cacheLong   = env('CACHE_BUFFER_LONG', 60);
        $allCategories     = \Cache::remember('nav-all-categories', $this->cacheMedium, function () {
            return \App\Model\Category::asc()->published()->get();
        });

        \View::share([
            'allCategories' => $allCategories,
            'baseRoute'     => $this->getControllerName() 
        ]);
    }

    /**
     * Get Controller name without 'Controller' postfix
     * @return string
     */
    protected function getControllerName()
    {
        return preg_replace("/(.*)[\\\\](.*)(Controller)/", '$2', get_class($this));
    }

}
