<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use DB;

class ProductController extends Controller
{
    public function index() {
        if(!Auth::check()) {
            return redirect('login');
        } else {
            $user = Auth::user();
            $product = Product::all();
            return view('products',compact('product','user'));
        }
    }

    public function editProduct($id)
    {
        $data = Product::where('id',$id)->first();
        return view('admin.editProduct',compact('data'));
    }
    public function cart()
    {
        if(!Auth::check()) {
            return redirect('login');
        } else {
            $user = Auth::user();
            return view('cart',compact('user'));
        }
    }

    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart',[]);
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'quantity' => 1,
                'category' => $product->category,
                'description' => $product->description,
                'price' => $product->price,
                'seller' => $product->seller
            ];
        }
        session()->put('cart',$cart);
        return redirect('cart')->withSuccess('Product added in cart successfully.');
    /*$data = Product::where('id',$id)->first();
        return view('admin.editProduct',compact('data'));*/
    }
    public function deleteCartProduct(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart',$cart);
            }
            session()->flash('success','Product is deleted from your cart.');
        }
    }

    /*if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart',$cart);
            }
            session()->flash('success','Product is deleted from your cart.');
        }*/ 

        public function order()
        {

            //check session 
            if(!Auth::check()) {
                return redirect('login');
            }

            $cart = session()->get('cart',[]);
            $user = Auth::user();

            $total=0;
            foreach ($cart as $id => $product )
            {
                $total = $total + $product['price']*$product['quantity'];
            }
            $orders_id = DB::table('orders')->insertGetId([
                'name' => $user->name,
                'email' => $user->email,
                'address' => $user->address,
                'total_amount' => $total
            ]);

            //$sub_total=0;
            foreach ($cart as $id => $product )
            {
                //$sub_total=$sub_total + ;
                DB::table('orders_details')->insert([
                    'orders_id' => $orders_id,
                    'product_name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => $product['quantity'],
                    'sub_amount' => $product['price']*$product['quantity']
                ]);
            }
            return redirect('home');
            
        }

        public function orderSave(Request $request)
        {
            //dd($request->all());
            $random = rand(00000000,99999999);

            if(!Auth::check()) {
                return redirect('login');
            }

            $cart = session()->get('cart',[]);
            $user = Auth::user();

            $total=0;
            foreach ($cart as $id => $product )
            {
                $total = $total + $product['price']*$product['quantity'];
            }
            $orders_id = DB::table('orders')->insertGetId([
                'name' => $user->name,
                'email' => $user->email,
                'address' => $user->address,
                'total_amount' => $total,
                'payment_id' =>$random,
                //'payment_status'=> 'pending',
                //'payment_date' =>'',
                //'payment_card_details' => '',
            ]);

            //$sub_total=0;
            foreach ($cart as $id => $product )
            {
                //$sub_total=$sub_total + ;
                DB::table('orders_details')->insert([
                    'orders_id' => $orders_id,
                    'product_name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => $product['quantity'],
                    'sub_amount' => $product['price']*$product['quantity']
                ]);
            }
            return redirect('payment/'.$random);

        }
        public function payment($payment_id)
        {
            //echo $payment_id; exit;
            if(!Auth::check()) {
                return redirect('login');
            }
            $user = Auth::user();
            $orders_details = DB::table('orders')->where('payment_id','=',$payment_id)->first();
            return view('payment',compact('user','orders_details','payment_id'));
        }

        public function paymentSave(Request $request)
        {
            //dd($request->all());
            //card_details
            $payment_id = $request->payment_id;
            $card_number = $request->card_number;
            $expire_date = $request->expire_date;
            $cvv = $request->cvv;
            $validatePayment = DB::table('card_details')->where('card_number','=',$card_number)->where('expire_date','=',$expire_date)->where('cvv','=',$cvv)->first();
            //echo "card number : ".$validatePayment->card_number; exit;
            if($validatePayment->card_number !='') {
                $paymentupdate = DB::table('orders')->where('payment_id','=',$payment_id)->update(
                    [
                        'payment_status' => 'Complete',
                        'payment_date' => date('Y-m-d'),
                        'payment_card_details' => $card_number,
                    ]
                );
                return redirect('myorder');
            } else {
                return redirect('payment/'.$payment_id);
            }
        }
}
