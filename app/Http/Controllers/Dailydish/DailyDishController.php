<?php

namespace App\Http\Controllers\Dailydish;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\DailyDish;
use App\Models\Item;
use Illuminate\Http\Request;

class DailyDishController extends Controller
{
    public function save(Request $request){
        try{
            $data = $request->all();  
        $category = Category::where("description", "Prato do Dia")->first();
        
        $imageString = '';
        
        if($data["category_id"] == $category->id){

            $newItem =  Item::create([
                'barcode'=>$request->barcode,
                'description'=>$request->description,
                'price'=>$request->price,
                'cost'=>$request->cost,
                'quantity'=> 1,
                'iva'=>$request->iva,
                'image'=>$imageString,
                'category_id'=>$request->category_id,
                'company_id'=>auth()->user()->company_id,
            ]);

            DailyDish::create([
                "entrance" => $data["entrance"]  ?? "",
                "maindish" => $data["maindish"] ?? "",
                 "dessert" => $data["dessert"] ?? "",
                // "drink" => $data["drink"] ?? "",
                // "coffe" => $data["coffe"] ?? "",
                // "item_id" => $newItem['id'] ?? ""
            ]);

            dd("saved");
        }else{
            $newItem =  Item::create([
                'barcode'=>$request->barcode,
                'description'=>$request->description,
                'price'=>$request->price,
                'cost'=>$request->cost,
                'quantity'=> $request->quantity,
                'iva'=>$request->iva,
                'image'=>$imageString,
                'category_id'=>$request->category_id,
                'company_id'=>auth()->user()->company_id,
            ]);
        }

        }catch(\Exception $e){
            dd($e->getMessage());
        }
        
    }
}
