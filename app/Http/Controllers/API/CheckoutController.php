<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
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
    public function placeOrder(Request $request)
    {
        //
        if (auth('sanctum')->check()) {
            # code...
            $validation = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'address' => 'required',
                'city' => 'required',
                'state' => 'required',
                'zip_code' => 'required',
            ]);

            if ($validation->fails()) {
                # code...
                return response()->json([
                    'status' => 422,
                    'errors' => $validation->messages()
                ]);
            } else {
                # code...
                $user_id = auth('sanctum')->user()->id;

                $order = new Order();
                $order->user_id = $user_id;
                $order->first_name = $request->input('first_name');
                $order->last_name = $request->input('last_name');
                $order->email = $request->input('email');
                $order->phone = $request->input('phone');
                $order->address = $request->input('address');
                $order->city = $request->input('city');
                $order->state = $request->input('state');
                $order->zip_code = $request->input('zip_code');

                $order->payment_mode = $request->payment_mode;

                // if ($request->payment_mode == 'razorpay') {
                //     # code...
                //     $order->payment_id = $request->payment_id;
                // } else if ($request->payment_mode == 'razorpay')  {
                //     # code...
                //     $str = Str::random(14);
                //     $order->payment_id = 'cas_' . $str;
                //     $order->payment_id = "";
                // }

                $order->payment_id = $request->payment_id;
                
                $order->tracking_no  = '#ORD'. mt_rand(10000000, 99999999);
                $order->save();

                $carts = Cart::where('user_id', $user_id)->get();

                $orderItems = []; 
                foreach ($carts as $cart) {
                    # code...
                    $orderItems[] = [
                        'product_id' => $cart->product_id,
                        'quantity' => $cart->product_quantity,
                        'price' => $cart->product->selling_price,
                    ];

                    $cart->product->update([
                        'quantity' => $cart->product->quantity - $cart->product_quantity
                    ]);
                }

                $order->orderitems()->createMany($orderItems);

                //Empty cart Items after opder placed
                Cart::destroy($carts);

                return response()->json([
                    'status' => 200,
                    'message' => 'Order Placed Successfully..'
                ]);
            }
            

        } else {
            # code...
            return response()->json([
                'status' => 401,
                'errors' => 'Login for this action.'
            ]);
        }
        
    }

    /**
     * Validate the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function validateOrder(Request $request)
    {
        //
        if (auth('sanctum')->check()) {
            # code...
            $validation = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'address' => 'required',
                'city' => 'required',
                'state' => 'required',
                'zip_code' => 'required',
            ]);

            if ($validation->fails()) {
                # code...
                return response()->json([
                    'status' => 422,
                    'errors' => $validation->messages()
                ]);
            } else {
                # code...
                return response()->json([
                    'status' => 200,
                    'message' => 'Form Validated Successfully..'
                ]);
            }
            
        } else {
            # code...
            return response()->json([
                'status' => 401,
                'errors' => 'Login for this action.'
            ]);
        }        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
