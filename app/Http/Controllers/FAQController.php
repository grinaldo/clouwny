<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Faq;

class FAQController extends Controller
{
    public function index()
    {
        $faqs = \Cache::remember('faqs', $this->cacheLong, function () {
            return Faq::published()->asc()->get();
        });
        return view('faqs.index', [
            'faqs' => $faqs
        ]);
    }
    
}
