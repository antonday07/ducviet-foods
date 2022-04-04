<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $data = Cart::content();
        $product = Product::find($request->id);

        return view('frontend.contents.cart', compact('data', 'product'));
    }

    public function addCart(Request $request)
    {
        
            $product = Product::find($request->id);

            $id = $request->id;    
            $price = empty($product->promotion) ? $product->retail_price : $product->price_discount; 
           
            $cart = session()->get('cart');
          
            // if cart is empty then this the first product
            if(!$cart) {
    
                $cart = [
                    $id => [
                        "name" => $product->name,
                        "quantity" => 1,
                        "price" => $price,
                        "photo" => $product->image
                    ]
                ];
    
                session()->put('cart', $cart);
    
                $htmlCart = view('frontend.partials.header_cart')->render();
    
                return response()->json([
                    'message' => 'Thêm sản phẩm thành công !', 
                    'status' => 'success',
                    'data' => $htmlCart
                ]);
    
                //return redirect()->back()->with('success', 'Product added to cart successfully!');
            }

            // if cart not empty then check if this product exist then increment quantity
            if(isset($cart[$id])) {
    
                $cart[$id]['quantity']++;
    
                session()->put('cart', $cart);
    
                $htmlCart = view('frontend.partials.header_cart')->render();
                return response()->json([
                    'message' => 'Thêm sản phẩm thành công !', 
                    'status' => 'success',
                    'data' => $htmlCart
                ]);
    
        
            }
    
            // if item not exist in cart then add to cart with quantity = 1
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $price,
                "photo" => $product->image
            ];
    
            session()->put('cart', $cart);
    
            $htmlCart = view('frontend.partials.header_cart')->render();
            return response()->json([
                'message' => 'Thêm sản phẩm thành công !', 
                'status' => 'success',
                'data' => $htmlCart
            ]);

    }
    public  function removeCart(Request $request)
    {
        if($request->id) {

            $cart = session()->get('cart');

            if(isset($cart[$request->id])) {

                unset($cart[$request->id]);

                session()->put('cart', $cart);
            }

            $total = $this->getCartTotal();

            $htmlCart = view('frontend.partials.header_cart')->render();        
            return response()->json([
                'message' => 'Xóa sản phẩm thành công!', 
                'status' => 'success',
                'data' => $htmlCart,
                'total' => $total,             
            ]);
     
        }
    }
    public function updateCart(Request $request)
    {
        $product = Product::find($request->id);
        if($request->id and $request->quantity)
        {
            if(!empty($product->warehouse)) {
                if($request->quantity > $product->warehouse->quantity) {
                    return response()->json([
                        'message' => 'Không đủ số lượng cho mặt hàng này!', 
                        'status' => 'error',                   
                    ]);
                }
            }


            $cart = session()->get('cart');

            $cart[$request->id]["quantity"] = $request->quantity;



            session()->put('cart', $cart);

            $subTotal = $cart[$request->id]['quantity'] * $cart[$request->id]['price'];

            $total = $this->getCartTotal();

            $htmlCart = view('frontend.partials.header_cart')->render();

            return response()->json([
                'message' => 'Chỉnh sửa giỏ hàng thành công!', 
                'status' => 'success',
                'data' => $htmlCart,
                'total' => $total,
                'subTotal' => $subTotal
            ]);

        }       
    }

    
    /**
     * getCartTotal
     *
     *
     * @return float|int
     */
    private function getCartTotal()
    {
        $total = 0;

        $cart = session()->get('cart');

        foreach($cart as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }

        return $total;
    }
}
