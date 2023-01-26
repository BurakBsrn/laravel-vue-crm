<?php

namespace App\Http\Controllers\api\category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ProductModel;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index(){
        $data = Category::where(array(
            "category_user_id" => auth('api')->user()->id))->paginate(10);
        return response()->json($data,200);
    }

    // KATEGORİ ARAMA KISMI
    public function search(Request $request){
        $aranan = $request->aranan;
        $data = Category::where(array(
            ["category_user_id","=",auth('api')->user()->id],
            ["category_name","like","%$aranan%"]
        ))->orderBy("category_id","desc")->paginate(2);

        $data->appends($aranan);
        return response()->json($data,200);
    }

    // KATEGORI EKLEME ISLEMI
    public function store(Request $request){
        $request->validate(array(
            "category_name" => "required|string|unique:categories|max:255"
        ));

        $data = $request->except("_token");
        $data['category_user_id'] = auth('api')->user()->id;

        Category::create($data);
    }

    // GUNCELLEME KISMI
    public function edit(Category $item){
        return response()->json($item,200);
    }

    // GUNCELLEME ISLEMI
    public function update(Request $request,Category $item){
        $validateData = [];
        $data = $request->except("_token");

        if ($data['category_name'] != $item->category_name){
            $kontrol = Category::where(array(
                "category_name" => $data['category_name']
            ))->first();

            if ($kontrol){
                $validateData['category_name'] = "required|string|unique:categories|max:255";
            }else{
                $validateData['category_name'] = "required|string|max:255";
            }
        }

        $request->validate($validateData);
        $item->update($data);
    }

    // SILME ISLEMI
    public function delete(Category $item){
        $item->delete();
        ProductModel::where(array(
            "product_category_id" => $item->category_id
        ))->delete();
    }
}
