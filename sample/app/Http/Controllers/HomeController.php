<?php

namespace App\Http\Controllers;
use App\Product;
use App\User;
use App\Cart;
use App\Checkout;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Cart_item;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart_items = Cart_item::all();
        $products = Product::all();
        return view('home',compact('products','cart_items'));
    }

    public function addtocart(Request $request,$product_id){
        $user = Auth::user()->id;
        $cartId = Cart::where('customer_id',$user)->value('id');
        $price = DB::table('products')->where('id',$product_id)->value('price');
        $quantity = 1 ;
        $amount = $price * $quantity;
        $imgpath = Product::where('id',$product_id)->value('imgpath');
        $existing = Cart_item::where('product_id',$product_id)->get();

        \Session::flash('flash_message','Product successfully added to cart.');

        if($existing!="[]"){
            DB::table('cart_items')->where('product_id',$product_id)->increment('quantity');
            $quantity = Cart_item::where('product_id',$product_id)->value('quantity');
            $base = $price * 1;
            $amount = $price * $quantity;
            DB::table('cart_items')->where('product_id',$product_id)->update(['amount' => $amount]);
        }
        if($existing=="[]"){      
        DB::table('cart_items')->insert([
               'product_id' => $product_id,
               'quantity'   => $quantity,
               'cart_id'    => $cartId,
               'amount'     => $amount,
               'imgpath'    => $imgpath
            ]);
        }
        return redirect('/home');
    }

    public function checkoutprocess(){
        $user = Auth::user()->id;
        $cartId = Cart::where('customer_id',$user)->value('id');
        $product_id = Cart_item::where('cart_id',$cartId)->value('product_id');
        $product_name = Product::where('id',$product_id)->value('name');
        $quantity = Cart_item::where('product_id',$product_id)->value('quantity');
        $total_amount = DB::table('cart_items')->sum('amount');
        $total_item = DB::table('cart_items')->sum('quantity');

        DB::table('checkouts')->insert([
                'product_name' => $product_name,
                'quantity' => $quantity,
                'total_item' => $total_item,
                'total_amount' => $total_amount
        ]);
        return redirect('/checkout');
    }

    public function checkout(){
         $checkouts = Checkout::all();

        return view('checkout',compact('checkouts'));
    }
}
