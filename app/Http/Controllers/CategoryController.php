<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Parameter;
use App\Models\CategoryParameter;
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
        $parameters = Parameter::all();
        $items = Item::where('category_id','=',$category->id)->get();
        // $items = Item::where('category_id','=',$category->id)->where('status','=',10)->get(); // su siuo bus atvaizduojama tik aktyvios prekes, nepriklausomai kas ziur
        return view('category.index',[
            'categories'=> $categories,
            'chain'=>$_SESSION['chain'],
            'parameters'=>$parameters,
            'items'=>$items
            ]);
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
        
            // $category = new Category();
            // $category->name = $request->name;
            // if($request->category_id != 0){
            //     $category->category_id = $request->category_id;
            // }
            // $category->save();
            // foreach ($request->parameters as $parameter) {
            //     $category->parameters()->attach($parameter);
            //  }
            // return redirect()->route('category.map',$request->category_id);
          
        $category = new Category();
        $category->name = $request->name;
        if($request->category_id != 0) {
            $category->category_id = $request->category_id;
        }
        $category->save();

        if ($request->filled('parameters')) {
            foreach ($request->parameters as $parameter) {
                $category->parameters()->attach($parameter);
            }
        }

        if ($request->category_id =="0") {
            return redirect()->route('category.index')->with('success_message', 'Kategorija s??kmingai ??ra??yta.');
        } else {
            return redirect()->route('category.map',$request->category_id)->with('success_message', 'Kategorija s??kmingai ??ra??yta.');
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
        $categoryParameters = CategoryParameter::where('category_id', '=', $category->id)->get();
        $ctParams = [];

        foreach ($categoryParameters as $ctParam) {
            $ctParams[] = $ctParam->parameter_id;
        }


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
        // $category->name = $request->name;
        // $category->category_id = $request->category_id;
        // $category->save();
        // //istrink visus many to many lenteles irasus susijusius su cia konkrecia kategorija
        
        // foreach ($request->parameters as $parameter) {
        //     $category->parameters()->attach($parameter);
        //  }
        //  return redirect()->route('category.index')->with('success_message', 'S??kmingai pakeistas.');
            // dd($category);
        $category->name = $request->name;
        if($request->category_id == "0"){
            // dd($request->category_id);
            $category->category_id = null;
        }
        else{
        $category->category_id = $request->category_id;
        }
        $category->save();
        foreach ($category->parameters as $parameter) {
            $iP =  CategoryParameter::where('category_id', '=', $category->id)
            ->where("parameter_id",'=', $parameter->id)->first();
            // $iP->data = $request->input($parameter->id);
            $iP->delete();
        }
        if ($request->filled('parameters')) {
            foreach ($request->parameters as $parameter) {
                $category->parameters()->attach($parameter);
            }
        }
        return redirect()->route('category.index')->with('success_message', 'Kategorija s??kmingai atnaujinta.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        // $items = Item::where('category_id', '=', $category->id)->get();
        // if (count($items)>0) {
        //     return redirect()->back()->withErrors("Pa??alinti negalima, nes kategorijoje yra preki??.");
        // }

        // CategoryParameter::where('category_id', '=', $category->id)->delete();


        // $category->delete();
        // return redirect()->back()->with('success_message', 'Kategorija s??kmingai pa??alinta.');
    
////////////////////////////////////////////////////////////////////////


      //+  //jeigu yra tos kategorijos prekiu, grizti su eroru, kad negalima trinti nes yra prekiu
        // nesigilinant trinam category_parameters duomenis.
        // $category->delete();
        // return redirect()->route('category.index')->with('error_message', 'Vajeezau! kas cia nutiko?!');
        
        if(Item::where("category_id","=",$category->id)->get()->count() > 0){
            return redirect()->back()->with('error_message', 'There are items in this category');

        }
        CategoryParameter::where("category_id","=",$category->id)->delete();

        $category->delete();
        return redirect()->route('category.index')->with('success_message', 'sekmingai istrinta');
        
////////////////////////////////////////////////////////////////////////////////////////////////////
    //     $category = Category::findOrFail($category);
    //     if(count($category->parameters))
    // {
    //     $parameters = $category->parameters;
    //     foreach($parameters as $par)
    //     {
    //         $par = Category::findOrFail($par->category);
    //         $par->parent_id = null;
    //         $par->save();
    //     }
    // }
    //     $category->delete();
    //     return redirect()->back()->with('error_message', 'Category has been deleted successfully.');
    }


    

}
