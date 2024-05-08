<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libs\Response;
use App\Models\Category;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [];
        $count = 0;
        $categories = Category::whereNull('parent_id')->get();

        foreach($categories as $category){
            $data[$count]['title'] = $category['title'];
            
            $subcategories = $this->getSubcategories($category['id']);

            foreach($subcategories as $subcategory){
                $data[$count]['subcategories'][$subcategory['id']]['title'] = $subcategory['title'];

                $sub_subcategories = $this->getSubcategories($subcategory['id']);

                foreach($sub_subcategories as $sub_subcategory){
                    $data[$count]['subcategories'][$subcategory['id']]['sub_subcategories'][$sub_subcategory['id']] = $sub_subcategory['title'];
                }
            }

            $count++;
        }

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string'
        ]);

        $categoryDetails = $this->getCategoryDetails($request->input('category_id'), $request->input('subcategory_id'));

        $category = new Category();
        $category->title = $request->input('title');
        $category->depth = $categoryDetails['depth'];
        $category->parent_id = $categoryDetails['parent_id'];

        if($category->save()){
            // success
            return Response::response('success', 'Category added successfully!', $category, 200);
        }else{
            // error
            return Response::response('error', 'Category could not be added!', $category, 409);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

    public function getCategories(){
        $categories = Category::whereNull('parent_id')->get();

        return $categories;
    }

    public function getSubcategories($category_id)
    {
        $subcategories = Category::where('parent_id', $category_id)->get();

        return $subcategories;
    }

    private function getCategoryDetails($categoryId, $subcategoryId) {
        if (!$categoryId && !$subcategoryId) {
            return ['depth' => 0, 'parent_id' => null];
        }
    
        if ($categoryId && !$subcategoryId) {
            return ['depth' => 1, 'parent_id' => $categoryId];
        }
    
        if ($categoryId && $subcategoryId) {
            return ['depth' => 2, 'parent_id' => $subcategoryId];
        }
    }
}
