<?php

namespace App\Services;

use App\Models\{Cart, CartItem, Size};
use Illuminate\Support\Facades\{Auth, DB};
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CartService {

    /** add product to cart
     * @return \Illuminate\Auth\Access\Response|bool
    */

    public function add_to_cart(\App\Http\Requests\StoreCartRequest $request)
    {
        return DB::transaction(function() use ($request) {
            if(Auth::guard('sanctum')->check()) {
                $user_id = auth('sanctum')->user()->id;
            }
            $cart = Cart::where('user_id', $user_id)->first();
            
            if(!$cart) {
                
                $created_cart = Cart::create([
                    'id' => md5(uniqid(rand(), true)),
                    'key' => md5(uniqid(rand(), true)),
                    'user_id' => isset($user_id) ? $user_id : null,
                ]);
                $this->create_cart_item($request, $created_cart);
                return $created_cart;
            }
            
            // return $cart->id;
            $this->create_cart_item($request, $cart);

            return $cart;
        });
    }

    /** create cart item
     * @param App\Models\Cart $cart
     * @return \Illuminate\Auth\Access\Response|bool
    */
    public function create_cart_item(\App\Http\Requests\StoreCartRequest $request, Cart $cart)
    {
        return DB::transaction(function() use ($request, $cart) {            
            $item = CartItem::updateOrCreate(
                ['cart_id' => $cart->id, 'product_id' => $request['product_id']],
                ['qty' => $request['qty'], 'size_id' => $request['size_id']]
            );

            $this->update_stock($request);

            return $item;
        });
    }

    /** check if requested size is available
    */

    public function size_is_available(\App\Http\Requests\StoreCartRequest $request)
    {
        $size = Size::findOrFail($request['size_id']);
        try {$size;} catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'The size you\'re trying to add does not exist.',
            ], 404);
        }

        ($size->available > $request['qty']) ? true : false;
    }

    public function update_stock(\App\Http\Requests\StoreCartRequest $request)
    {
        $stock = Size::findOrFail($request['size_id'])->stock;

        return $stock->update([
            'available_qty' => $stock->available_qty - $request['qty'],
            'in_cart' => $request['qty']
        ]);
    }
}