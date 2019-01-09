<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Slider;
use App\Product;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LandingPageController extends Controller
{
    public function index()
    {
        $popular_products = Product::limit(10)
            ->get();

        $sliders = Slider::limit(10)
            ->get();

        return response()
            ->json([
                'currency_info' => currency_changer(),
                'popular_products' => $popular_products,
                'sliders' => $sliders
            ]);

    }

    public function shop($category_name)
    {
        //gets categories and brands ids that are related to category name
        $category_id = Category::where('slug', $category_name)->firstOrFail();
        $category_products = DB::table('category_product')
            ->where('parent_id', $category_id->id)
            ->orWhere('category_id', $category_id->id)
            ->join('brand_product', 'category_product.product_id', '=', 'brand_product.product_id');

        $brands = Brand::whereIn('id', $category_products->pluck('brand_id'))->get();
        $categories = Category::whereIn('id', $category_products->pluck('category_id'))->get();

        //pushing all related categories names together in case of selecting the parent id
        $categories_slugs = Category::where('category_id', $category_id->id)
            ->pluck('slug');
        $categories_slug = $categories_slugs->push($category_name);

        //a mix of search for related products
        $products = Product::category($categories_slug)
            ->brand(request()->brand_name)
            ->search(request()->q)
            ->price(request()->selected)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()
            ->json([
                'currency_info' => currency_changer(),
                'products' => $products,
                'brands' => $brands,
                'categories' => $categories,
            ]);

    }
}
