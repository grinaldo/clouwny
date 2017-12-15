<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\Product;
use App\Model\Wishlist;

class WishlistController extends Controller
{
    public function index()
    {
        if (\Auth::check()) {
            $wishlists = Wishlist::where('user_id', '=', \Auth::user()->id)->get();
            return view('wishlists.index', [
                'profileNav' => 'wishlist',
                'products'   => $wishlists
            ]);
        } else {
            return redirect()->route('home');
        }
    }

    public function store(Request $request) 
    {
        $response = [
            'status'  => 'failed',
            'message' => 'Please make sure you are logged in.'
        ];
        if(\Auth::check()) {
            $product = Product::select('id')->where('slug', '=', $request->product)->first();
            \Log::info($product->id);
            if (!empty($product)) {
                $wishlist = Wishlist::firstOrNew([
                    'user_id'    => \Auth::user()->id,
                    'product_id' => $product->id
                ]);
                if (!$wishlist->id) {
                    $wishlist->save();
                    $response = [
                        'status'  => 'success',
                        'type'    => 'success',
                        'message' => 'Product has been added',
                    ];
                } else {
                    $response = [
                        'status'  => 'success',
                        'type'    => 'info',
                        'message' => 'Product is already in wishlist',
                    ];
                }

            }
        }
        return response()->json($response); 
    }

    public function remove(Request $request)
    {
        $response = [
            'status'  => 'failed',
            'message' => 'Invalid Request'
        ];
        if(\Auth::check()) {
            $product = Product::select('id')->where('slug', '=', $request->product)->first();
            if (!empty($product)) {
                $wishlist = Wishlist::where('user_id', '=', \Auth::user()->id)
                    ->where('product_id', '=', $product->id)
                    ->first();
                if ($wishlist->id) {
                    $wishlist->delete();
                    $response = [
                        'status'  => 'success',
                        'type'    => 'success',
                        'message' => 'Product has been removed',
                        'target'  => $request->target
                    ];
                }
            }
        }
        return response()->json($response); 
    }
}
