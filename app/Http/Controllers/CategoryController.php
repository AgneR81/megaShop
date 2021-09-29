<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Parameter;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(){
        session_start();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $_SESSION['chain'] = [];
        $categories = Category::whereNull('category_id')->get();
        $chain = [];
        $chain[] = $categories;
    //    dd($categories);
       
        return view('category.index',['categories'=> $categories,'chain'=>$_SESSION['chain']]);
    }

    public function map(Category $category)
    { $_SESSION['chain'][] =  $category;
        $tmpSs = [];
        foreach ($_SESSION['chain'] as $ssCat) {
            $tmpSs[] = $ssCat;
            if($ssCat->id == $category->id){
                break;
            }
        }
        $_SESSION['chain'] = $tmpSs;
        // dd($_SESSION['chain'][0]->id);
        $categories = Category::where('category_id','=',$category->id)->get();
        return view('category.index',['categories'=> $categories,'chain'=>$_SESSION['chain']]);
    }   


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create( $categoryId)
    {
        $parameters = Parameter::all();
       return view('category.create',['categoryId'=>$categoryId,'parameters'=>$parameters]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        {
            $category = new Category();
            $category->name = $request->name;
            if($request->category_id != 0){
                $category->category_id = $request->category_id;
            }
            $category->save();
            foreach ($request->parameters as $parameter) {
                $category->parameters()->attach($parameter);
             }
            return redirect()->route('category.map',$request->category_id);
        }   
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $parameters = Parameter::all();
        $categories = Category::where('id','!=',$category->id)->get();
        return view('category.edit', ['category' => $category, 'parameters'=>$parameters, 'categories'=>$categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $category->name = $request->name;
        $category->category_id = $request->category_id;
        $category->save();
        foreach ($request->parameters as $parameter) {
            $category->parameters()->attach($parameter);
         }
         return redirect()->route('category.index')->with('success_message', 'Sėkmingai pakeistas.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
