<?php

namespace hcivelek\Categorizable\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use hcivelek\Categorizable\Entities\Category;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $q = $request->q; //for view (search bar) and pagination
        $categories = Category::filter($request)->paginate();

        if($request->wantsJson())
            return response()->json([
                'data' => $categories
            ]);        
 
        return view('categorizable::index', compact("q","categories"));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request);

        $category = new Category;
        $category->name = $request->name;
        $category->save();

        return response()->json([
            'name' => 'The category saved',
            'category' => $category
        ]);
    }
 
    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Category $category
     * @return Response
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request);

        $category->name = $request->name;
        $category->update();

        return response()->json([
            'name' => 'The category updated',
            'category' => $category
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param Category $category
     * @return Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
            'name' => 'The category deleted',
            'id' => $category->id
        ]);
    }

    public function validate($request)    
    {
        return $request->validate([
            'name' => 'required'
        ]);        
    }
}
