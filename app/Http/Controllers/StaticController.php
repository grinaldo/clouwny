<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Page;

class StaticController extends Controller
{
    public function aboutIndex()
    {
        $about = \Cache::remember('abouts', $this->cacheLong, function () {
            return Page::where('name', '=', 'about-static')->first();
        });
        return view('statics.about', [
            'about' => $about
        ]);
    }
    
}
