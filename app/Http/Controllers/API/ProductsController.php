<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Libs\Response;
use App\Models\Product;
use App\Models\Image;
use App\Models\Category;

class ProductsController extends Controller
{

    private function filter($query, $filter_params){
        if($filter_params['category'] != "false" && !$filter_params['subcategory'] == "false" && !$filter_params['sub_subcategory'] == "false"){
    
            $categories = Category::where('parent_id', $filter_params['category'])
                        ->where('depth', 2)
                        ->orWhere('depth', 3)
                        ->pluck('id')
                        ->prepend($filter_params['subcategory'])
                        ->toArray(); 

            $query->whereIn('category_id', $categories);
        }

        if($filter_params['category'] != "false" && $filter_params['subcategory'] != "false" && $filter_params['sub_subcategory'] == "false"){

            $categories = Category::where('parent_id', $filter_params['subcategory'])
                                    ->where('depth', 2)
                                    ->pluck('id')
                                    ->prepend($filter_params['subcategory'])
                                    ->toArray(); 

             $query->whereIn('category_id', $categories);
        }
        
        if($filter_params['category'] != "false" && $filter_params['subcategory'] != "false" && $filter_params['sub_subcategory'] != "false"){
            $query->where('products.category_id', $filter_params['subcategory']);
        }

        if($filter_params['price_min'] != "false" && $filter_params['price_max'] != "false"){
            $query->whereBetween('products.price', [$filter_params['price_min'], $filter_params['price_max']]);
        }

        if($filter_params['price_min'] != "false" && $filter_params['price_max'] == "false"){
            $query->where('products.price', ">=", $filter_params['price_min']);
        }

        if($filter_params['price_min'] == "false" && $filter_params['price_max'] != "false"){
            $query->where('products.price', "<=", $filter_params['price_max']);
        }

        return $query;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Product::select(['products.description', 'products.id', 'images.path'])
                        ->join('images','images.product_id','=','products.id')
                        ->where('images.main', 1);

        $filter_params = [
            'category' => $_GET['filter_category_id'],
            'subcategory' => $_GET['filter_subcategory_id'],
            'sub_subcategory' => $_GET['filter_sub_subcategory_id'],
            'price_min' => $_GET['filter_price_min'],
            'price_max' => $_GET['filter_price_max']
        ];

        $query = $this->filter($query, $filter_params);
          
        return $query->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
    
        try {
            $validatedData = $request->validate([
                'description' => 'required|string',
                'images.*' => 'required|image',
                'price' => 'required|numeric',
                'category_id' => 'required|numeric'
            ]);
    
            $mainImageIndex = $request->input('main_image_index');
    
            $product = new Product();
            $product->description = $request->input('description');
            $product->price = $request->input('price');

            if($request->input('category_id')){
                $product->category_id = $request->input('category_id');
            }

            if($request->input('subcategory_id')){
                $product->category_id = $request->input('subcategory_id');
            }

            if($request->input('sub_subcategory_id')){
                $product->category_id = $request->input('subcategory_id');
            }
    
            if ($product->save()) {
                $images = $request->file('images');
                foreach ($images as $index => $value) {
                    $image = new Image();
    
                    $path = uniqid().'.'.$value->getClientOriginalExtension();
                    $value->storeAs('public/img', $path);
                    $image->path = $path;
                    $image->main = ($mainImageIndex == $index) ? 1 : 0;
                    $image->product_id = $product->id;
    
                    if(!$image->save()){
                        DB::rollBack();
                        return Response::response('error', 'Failed to save image.', $image, 500);
                    }
                }
            } else {
                DB::rollBack();
                return response()->json(['error' => 'Failed to save product.'], 500);
                return Response::response('error', 'Failed to save product.', $product, 500);
            }
    
            DB::commit();
            return Response::response('success', 'Product and images saved successfully.', $product, 200);
    
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::response('error', $e->getMessage(), $product, 500);
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Product::with('category')->find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
