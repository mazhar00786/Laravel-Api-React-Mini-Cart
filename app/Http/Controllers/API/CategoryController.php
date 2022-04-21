<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $category = Category::all();

        return response()->json([
            'status' => 200,
            'category' => $category
        ]);
    }
    
    public function allCategory(Request $request)
    {
        # code...
        $category = Category::where('status', 0)->get();
        
        return response()->json([
            'status' => 200,
            'category' => $category
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
        $validation = Validator::make($request->all(),[
            'slug' => 'required|max:255',
            'name' => 'required|max:255',
            'meta_title' => 'required|max:255',
        ]);

        //
        if ($validation->fails()) {
            # code...
            return response()->json([
                'status' => 400,
                'errors' => $validation->messages()
            ]);
        } else {
            # code...
            $category = new Category();
            $category->name = $request->input('name');
            $category->slug = $request->input('slug');
            $category->description = $request->input('description');
            $category->status = $request->input('status') == true ? true : false;
            $category->meta_title = $request->input('meta_title');
            $category->meta_keyword = $request->input('meta_keyword');
            $category->meta_description = $request->input('meta_description');
            // return $category;
            $category->save();

            return response()->json([
                'status' => 200,
                'message' => 'Category Added Successfully..'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category  $category,$id)
    {
        //
        $category = Category::findOrFail($id);

        if ($category) {
            # code...
            return response()->json([
                'status' => 200,
                'category' => $category
            ]);
        } else {
            # code...
            return response()->json([
                'message' => 'Category not found..'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category, $id)
    {
        //
        $validation = Validator::make($request->all(),[
            'slug' => 'required|max:255',
            'name' => 'required|max:255',
            'meta_title' => 'required|max:255',
        ]);

        //
        if ($validation->fails()) {
            # code...
            return response()->json([
                'status' => 422,
                'errors' => $validation->messages()
            ]);
        } else {
            # code...
            $category = Category::findOrFail($id);

            if ($category) {
                # code...
                $category->name = $request->input('name');
                $category->slug = $request->input('slug');
                $category->description = $request->input('description');
                $category->status = $request->input('status') == true ? true : false;
                $category->meta_title = $request->input('meta_title');
                $category->meta_keyword = $request->input('meta_keyword');
                $category->meta_description = $request->input('meta_description');
                // return $category;
                $category->save();
    
                return response()->json([
                    'status' => 200,
                    'message' => 'Category Updated Successfully..'
                ]);
            } else {
                # code...
                return response()->json([
                    'message' => 'Category not found.'
                ]);
            }
        }        
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category, $id)
    {
        //
        $category = Category::findOrFail($id);

        if ($category) {
            # code...
            $category->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Category Deleted Successfully..'
            ]);
        } else {
            # code...
            return response()->json([
                'message' => 'Category not found..'
            ]);
        }
        
    }
}
