<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Auth;
use Validator, Input, Redirect; 

class CartController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Cart::all();
        return response()->json([
            "success" => true,
            "message" => "Products in cart",
            "data" => $products
            ]);
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'user_id' => 'required|numeric',
            'product_id' => 'required|numeric',
            'qty' => 'required|numeric'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }        

        $product = Cart::create($request->all());
        return response()->json([
            "success" => true,
            "message" => "Product added to the Cart.",
            "data" => $product
            ]);
    }

    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {       
        $product = Cart::find($id);
        if ($product === null) {
            $response = [
                'success' => false,
                'message' => 'Product does not Exist in the Cart',
            ];        
    
            return response()->json($response, 404);
        }

        $validator = Validator::make($request->all(),[
            'user_id' => 'required|numeric',
            'product_id' => 'required|numeric',
            'qty' => 'required|numeric',
            'session_id' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }
        
        $product->update($request->all());
        return response()->json([
            "success" => true,
            "message" => "Product updated successfully.",
            "data" => $product
            ]);
    }

    /**
     * Remove the specified products from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Cart::find($id);
        if ($product === null) {
            $response = [
                'success' => false,
                'message' => 'Product does not Exist in the Cart',
            ];        
    
            return response()->json($response, 404);
        }

        $product = cart::where('id', $id)->firstorfail()->delete();
        return response()->json([
            "success" => true,
            "message" => "Product deleted from the Cart successfully."
            ]);
    }
}
