<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;
use Auth;
use Validator, Input, Redirect; 

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = product::all();
        return response()->json([
            "success" => true,
            "message" => "Product List",
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
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category' => 'required',
            'description' => 'required',
            'avatar'=>'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }        

        $product = Product::create($request->all());
        return response()->json([
            "success" => true,
            "message" => "Product added successfully.",
            "data" => $product
            ]);
    }

    /**
     * Display the specified product.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if (is_null($product)) {
            $response = [
                'success' => false,
                'message' => 'Product not found.',
            ];             
    
            return response()->json($response, 404);
        }
        return response()->json([
            "success" => true,
            "message" => "Product retrieved successfully.",
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
        $product = product::find($id);
        if ($product === null) {
            $response = [
                'success' => false,
                'message' => 'Product does not Exist',
            ];        
    
            return response()->json($response, 404);
        }

         $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category' => 'required',
            'description' => 'required',
            'avatar'=>'required'
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
        $product = product::find($id);
        if ($product === null) {
            $response = [
                'success' => false,
                'message' => 'Product does not Exist',
            ];        
    
            return response()->json($response, 404);
        }

        $product = product::where('id', $id)->firstorfail()->delete();
        return response()->json([
            "success" => true,
            "message" => "Product deleted successfully."
            ]);
    }
}
