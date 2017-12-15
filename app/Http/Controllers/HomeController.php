<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Banner;
use App\Model\Category;
use App\Model\Page;
use App\Model\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners    = \Cache::remember('home-banners', $this->cacheShort, function () {
            return Banner::published()->asc()->take(3)->get();
        });
        $categories = \Cache::remember('home-categories', $this->cacheShort, function () {
            return Category::published()->asc()->take(4)->get();
        });
        $products   = \Cache::remember('home-featured-products', $this->cacheShort, function () {
            return Product::published()->featured()->asc()->take(3)->get();
        });
        $static     = \Cache::remember('home-statices', $this->cacheShort, function () {
            return Page::where('name', '=', 'home-static')->first();
        });
        return view('home.index', [
            'banners'    => $banners,
            'categories' => $categories,
            'products'   => $products,
            'static'     => $static
        ]);
    }
}
