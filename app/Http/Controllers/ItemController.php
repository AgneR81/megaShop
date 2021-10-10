<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemParameter;
use App\Models\Category;
use App\Models\Photo;
use App\Models\CategoryParameter;
use App\Models\Parameter;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Str;
use Validator;
use Response;


class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    // public function api()
    // {
    //     return Response::json([
    //         'status' => 200,
    //         'msg' => "sveikinu, jus kreipetes i serveriper API ir gavote atsakyma"
    //     ]);
        
    // }

    public function searchBar(Request $request)
    {
        // dd($request->statusas);
        // dd($request->all());
        $items = Item::where('name', 'like', '%'.$request->searchBar.'%' )->get();
        return Response::json([
            'status' => 200,
            'msg' => "sveikinu, jus kreipetes i serveriper API ir gavote atsakyma is apiPost",
            'searchBar' => $request->searchBar,
            'items' => $items
        ]);
        
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Category $category, Parameter $parameter)
    {
    //   dd($category->parameters);
        $parameters = CategoryParameter::where('category_id','=',$category->id)->get();
        $params = [];
                foreach($parameters as $parameter) {
                $params[] = $parameter = Parameter::where('id','=',$parameter->parameter_id)->get();
            }
            return view('item.create',['category' => $category, 'params' => $params]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Category $category )
    {
        $validator = Validator::make($request->all(),
        [
            
            'photos[]' => ['mimes:jpg,bmp,png'],
            'file' => ['max:50120'],
            'attachments' => ['max:3'],
            'photos.*' => ['mimes:jpeg,jpg,png,gif','max:5120'],
        ],
        [
            'photos.*.mimes' => '*Vienas iš failų nėra nuotrauka.',
            'photos.max' => '*Galite turėti ne daugiau 10 nuotraukų.',
            'photos.*.max' => '*Viena nuotrauka turi neviršyti 5MB.',
            'photos.image' => '*Visi failai turi būti nuotraukos',
            'file' => '*Nuotraukos dydis turi neviršyti 5MB  '
        ]);
         if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator);
        }



        // dd($request->input('price'));
            $item = new Item();
            $item->name = $request->name;
            $item->price = $request->price;
            $item->description = $request->description;
            $item->manufacturer = $request->manufacturer;
            $item->quantity = $request->quantity;
            $item->category_id = $request->category_id;
            $item->discount = $request->discount;
            $item->status = 0;
            if(isset($request->show)){
                $item->status = 10;
            }
            $item->save();
            $category = Category::find($request->category_id);
            
            foreach ($category->parameters as $parameter) {
                $item->parameters()->attach($parameter,['data' => $request->input($parameter->id)]);
             }

             if ($request->has('photos')) {
                foreach ($request->file('photos') as  $photo) {
                    //  var_dump($photo);
                    $img = Image::make($photo); //bitu kratinys, be jokios info
                    $fileName = Str::random(5).'.jpg';// random sugalvojau
                    $folder = public_path('images/items');     
                    $img->resize(1200, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $img->save($folder.'/big/'.$fileName, 80, 'jpg');
    
                    // $img = Image::make($photo);
                    $img->resize(200, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $img->save($folder.'/small/'.$fileName, 80, 'jpg');
                    $photo = new Photo();
                    $photo->name = $fileName;
                    $photo->item_id =  $item->id;
                    $photo->save();
                }
            }

            return redirect()->route('category.map',$request->category_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Item::find((((((($id/124)-6)/13)-7)/3)-6)/3);
        return view("item.show",['item'=>$item]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item,Category $category)
    {
        return view('item.edit',['item' => $item, 'category' => $category]);
    }

    public function softDelete(Request $request, Item $item)
    {
        if( $request->softDelete == 1){
            $item->status = 0;
        }else{
            $item->status = 10;
        }
        $item->save();
       return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item, Category $category)
    {
        $item->id = $request->item_id;
        $item->name = $request->name;
        $item->price = $request->price;
        $item->description = $request->description;
        $item->quantity = $request->quantity;
        $item->discount = $request->discount;
        $item->save();
        foreach ($item->parameters as $parameter) {
            $iP =  ItemParameter::where("item_id",'=', $item->id)
            ->where("parameter_id",'=', $parameter->id)->first();
            $iP->data = $request->input($parameter->id);
            $iP->save();
        }
        // return redirect()->route('category.index')->with('success_message', 'Sekmingai pakeistas.');

        $category = Category::find($request->category_id);
        return redirect()->route('category.map',[$category->id])->with('success_message', 'Sekmingai įrašytas.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Item $item)
    {
        foreach ($item->parameters as $parameter) {
            $iP =  ItemParameter::where("item_id",'=', $item->id)
            ->where("parameter_id",'=', $parameter->id)->first();
            $iP->data = $request->input($parameter->id);
            $iP->delete();
        }
        $item->delete();
        return redirect()->back()->with('success_message', 'Preke istrinta.');;
    }
}
