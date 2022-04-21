<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $product = Product::all();

        return response()->json([
            'status' => 200,
            'product' => $product
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validation = Validator::make($request->all(), [
            'category_id' => 'required',
            'meta_title' => 'required',
            'slug' => 'required',
            'name' => 'required',
            'brand' => 'required|max:20',
            'selling_price' => 'required',
            'original_price' => 'required',
            'quantity' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'         
        ]);

        if ($validation->fails()) {
            # code...
            return response()->json([
                'status' => 422,
                'errors' => $validation->messages(),
            ]);
        } else {
            # code...
            $product = new Product();
            $product->name = $request->input('name');
            $product->slug = $request->input('slug');
            $product->category_id = $request->input('category_id');           
            $product->description = $request->input('description');

            $product->meta_title = $request->input('meta_title');
            $product->meta_keyword = $request->input('meta_keyword');
            $product->meta_description = $request->input('meta_description');

            $product->brand = $request->input('brand');
            $product->selling_price = $request->input('selling_price');
            $product->original_price = $request->input('original_price');
            $product->quantity = $request->input('quantity');

            if ($request->hasFile('image')) {
                # code...
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $fileName = time() . '.' . $extension;
                $file->move('uploads/products/', $fileName);
                $product->image = 'uploads/products/'. $fileName;
            }

            $product->featured = $request->input('featured') == true ? '1' : '0';
            $product->popular = $request->input('popular') == true ? '1' : '0';
            $product->status = $request->input('status') == true ? '1' : '0';

            // return $product;

            $product->save();

            return response()->json([
                'status' => 200,
                'message' => 'Product Added Successfully.',
            ]);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product, $id)
    {
        //
        $product = Product::findOrFail($id);

        if ($product) {
            # code...
            return response()->json([
                'status' => 200,
                'product' => $product
            ]);
        } else {
            # code...
            return response()->json([
                'message' => "Product not found"
            ]);
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validation = Validator::make($request->all(), [
            'category_id' => 'required',
            'meta_title' => 'required',
            'slug' => 'required',
            'name' => 'required',
            'brand' => 'required|max:20',
            'selling_price' => 'required',
            'original_price' => 'required',
            'quantity' => 'required',       
        ]);

        if ($validation->fails()) {
            # code...
            return response()->json([
                'status' => 422,
                'errors' => $validation->messages(),
            ]);
        } else {
            # code...
            // return $request->meta_desc;
            $product = Product::findOrFail($id);

            if ($product) {
                # code...
                $product->name = $request->input('name');
                $product->slug = $request->input('slug');
                $product->category_id = $request->input('category_id');           
                $product->description = $request->input('description');

                $product->meta_title = $request->input('meta_title');
                $product->meta_keyword = $request->input('meta_keyword');
                $product->meta_description = $request->input('meta_desc');

                $product->brand = $request->input('brand');
                $product->selling_price = $request->input('selling_price');
                $product->original_price = $request->input('original_price');
                $product->quantity = $request->input('quantity');

                if ($request->hasFile('image')) {
                    # code...
                    $path = $product->image;

                    if (File::exists($path)) {
                        # code...
                        File::delete($path);
                    }

                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $fileName = time() . '.' . $extension;
                    $file->move('uploads/products/', $fileName);
                    $product->image = 'uploads/products/'. $fileName;
                }

                $product->featured = $request->input('featured') == true ? '1' : '0';
                $product->popular = $request->input('popular') == true ? '1' : '0';
                $product->status = $request->input('status') == true ? '1' : '0';

                // return $product;

                $product->update();

                return response()->json([
                    'status' => 200,
                    'message' => 'Product Updated Successfully.',
                ]);
            } else {
                # code...
                return response()->json([
                    'message' => "Product not found."
                ]);
            }    
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, $id)
    {
        //
        $product = Product::findOrFail($id);

        if ($product) {
            # code...
        } else {
            # code...
        }
        
    }
}
