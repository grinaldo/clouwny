<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Category;
use App\Model\Product;

class ProductController extends Controller
{
    public function index(Request $request) 
    {

        $products = Product::published()->asc()->newest();
        if ($request->has('name')) {
            $products = $products->where('name', 'like', '%'.$request->name.'%');
        }
        $products = $products->paginate(12);
        return view('products.index', [
            'products' => $products
        ]);
    }

    public function indexCategory($category)
    {
        $categoryGet = Category::where('slug', '=', $category)->first();
        if (empty($categoryGet)) {
            session()->flash(NOTIF_DANGER, 'Product category not found!');
            return redirect()->route('products');
        }
        $products = \Cache::remember(
            'products-pagination-'.$categoryGet->slug,
            $this->cacheShort,
            function () use ($categoryGet) {
                return Product::where('category_id', '=', $categoryGet->id)
                    ->published()
                    ->asc()
                    ->newest()
                    ->paginate(12);
            }
        );
        return view('products.index', [
            'products'         => $products,
            'categorySelected' => $categoryGet
        ]);
    }

    public function show($category, $product)
    {
        $productGet = \Cache::remember('products-detail-'.$product, $this->cacheShort, function () use ($product) {
            return Product::where('slug', '=', $product)->first();
        });
        if (empty($productGet)) {
            session()->flash(NOTIF_DANGER, 'Product not found!');
            return redirect()->back();
        }
        $variants   = ['-' => '-'];
        $stock      = 0;
        foreach ($productGet->variants()->get() as $variant) {
            $variants[$variant->id] = $variant->name . " (Stok: $variant->stock)";
            $stock += $variant->stock;
        }
        return view('products.show', [
            'product'  => $productGet,
            'variants' => $variants,
        ]);
    }
}
