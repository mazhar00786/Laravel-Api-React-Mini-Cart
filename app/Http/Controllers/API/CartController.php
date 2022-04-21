<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCart()
    {
        //
        if (auth('sanctum')->check()) {
            # code...
            $user_id = auth('sanctum')->user()->id;
            $cart = Cart::where('user_id', $user_id)->get();

            return response()->json([
                'status' => 200,
                'cart' => $cart
            ]);
        } else {
            # code...
            return response()->json([
                'status' => 401,
                'message' => 'Please login to access your cart.'
            ]);
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addToCart(Request $request)
    {
        //
        if (auth('sanctum')->check()) {
            # code...
            $user_id = auth('sanctum')->user()->id;
            $product_id = $request->input('product_id');
            $product_quantity = $request->input('quantity');

            $product = Product::where('id', $product_id)->first();
            if ($product) {
                # code...
                if (Cart::where('product_id', $product_id)->where('user_id', $user_id)->exists()) {
                    # code...
                    return response()->json([
                        'status' => 409,
                        'message' => $product->name . ' Already added to cart.'
                    ]);
                } else {
                    # code...
                    $cart = new Cart();
                    $cart->user_id = $user_id;
                    $cart->product_id = $product_id;
                    $cart->product_quantity = $product_quantity;
                    $cart->save();

                    return response()->json([
                        'status' => 200,
                        'message' => 'Product added to cart'
                    ]);
                }
            } else {
                # code...
                return response()->json([
                    'status' => 404,
                    'message' => 'Product not found.'
                ]);
            }
        } else {
            # code...
            return response()->json([
                'status' => 401,
                'message' => 'Login before adding product to cart'
            ]);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function updateCartQuantity($cart_id, $scope)
    {
        //
        if (auth('sanctum')->check()) {
            # code...
            $user_id = auth('sanctum')->user()->id;
            $cart = Cart::where('id', $cart_id)->where('user_id', $user_id)->first();

            if ($scope == "inc") {
                # code...
                if ($cart->product_quantity < 10) {
                    # code...
                    $cart->product_quantity += 1;

                    $cart->update();

                    return response()->json([
                        'status' => 200,
                        'message' => "Cart Quantity Incremented successfully."
                    ]);
                } else {
                    # code...
                    return response()->json([
                        'status' => 401,
                        'message' => "Quantity cannot be incremented above 10."
                    ]);
                }
                
                
            } else if ($scope == "dec") {
                # code...
                if ($cart->product_quantity > 1) {
                    # code...
                    $cart->product_quantity -= 1;

                    $cart->update();

                    return response()->json([
                        'status' => 200,
                        'message' => "Cart Quantity Decremented successfully."
                    ]);
                } else {
                    # code...                   
                    return response()->json([
                        'status' => 401,
                        'message' => "Quantity cannot be decremented below 1."
                    ]);
                }
                
                
            }
           


        } else {
            # code...
            return response()->json([
                'status' => 401,
                'message' => "Login to access your Cart"
            ]);
        }
        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart  $cart, $id)
    {
        //
        if (auth('sanctum')->check()) {
            # code...
            $user_id = auth('sanctum')->user()->id;

            $cart = Cart::where('id', $id)->where('user_id', $user_id)->first();

            if ($cart) {
                # code...
                $cart->delete();

                return response()->json([
                    'status' => 200,
                    'message' => "Cart Item deleted successfully."
                ]);
            } else {
                # code...
                return response()->json([
                    'status' => 404,
                    'message' => "Cart Item not found."
                ]);
            }
            
        } else {
            # code...
            return response()->json([
                'status' => 401,
                'message' => "Login to access your Cart"
            ]);
        }
    }
}
