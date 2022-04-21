<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    //
    public function category()
    {
        # code...
        $category = Category::where('status', 0)->get();

        return response()->json([
            'status' => 200,
            'category' => $category
        ]);
    }

    /**
     * 
     */
    public function product($slug)
    {
        # code...
        $category = Category::where('slug', $slug)->where('status', 0)->first();

        if ($category) {
            # code...
            $product = Product::where('category_id', $category->id)->get();

            if ($product) {
                # code...
                return response()->json([
                    'status' => 200,
                    'product_data' => [
                        'product' => $product,
                        'category' => $category
                    ],
                ]);
            } else {
                # code...
                return response()->json([
                    'status' => 400,
                    'message' => 'Product Not Found',
                ]);
            }
        } else {
            # code...
            return response()->json([
                'status' => 404,
                'message' => 'Category Not Found',
            ]);
        }
        
    }

    /** */
    public function productDetails($category_slug, $product_slug)
    {
        # code...
        $category = Category::where('slug', $category_slug)->where('status', 0)->first();

        if ($category) {
            # code...
            $product = Product::where('category_id', $category->id)
                              ->where('slug', $product_slug)
                              ->where('status', 0)
                              ->first();

            if ($product) {
                # code...
                return response()->json([
                    'status' => 200,
                    'product' => $product,
                ]);
            } else {
                # code...
                return response()->json([
                    'status' => 400,
                    'message' => 'Product Not Found',
                ]);
            }
        } else {
            # code...
            return response()->json([
                'status' => 404,
                'message' => 'Category Not Found',
            ]);
        }
    }
}
