<?php

namespace App\Http\Controllers\api\customer;

use App\Http\Controllers\Controller;
use App\Models\CustomerModel;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index()
    {
        $data = CustomerModel::where(array(
            "customer_user_id" => auth('api')->user()->id
        ))->orderBy("customer_id", "desc")->paginate(10);
        return response()->json($data, 200);
    }

    // ARAMA KISMI
    public function search(Request $request){
        $aranan = $request->aranan;
        $data = CustomerModel::where(array(
            ["customer_user_id","=",auth('api')->user()->id],
            ["customer_name","like","%$aranan%"],
        ))->orderBy("customer_id","desc")->paginate(1);

        return response()->json($data, 200);
    }

    // EKLEME KISMI
    public function store(Request $request)
    {
        $request->validate(array(
            "customer_type" => "required|max:11",
            "customer_name" => "required|string|max:255",
            "customer_email" => "required|string|email|unique:customers|max:255",
            "customer_phone" => "required|string|unique:customers|max:255",
            "customer_address" => "required|string|max:255",
            "customer_note" => "required|string"
        ));

        $data = $request->except("_token");
        $data['customer_user_id'] = auth('api')->user()->id;

        CustomerModel::create($data);
    }

    // GUNCELLEME KISMI
    public function edit(CustomerModel $item){
        return response()->json($item,200);
    }

    // GUNCELLEME ISLEMI
    public function update(Request $request,CustomerModel $item){
        $validateData = [
            "customer_type" => "required|max:11",
            "customer_name" => "required|string|max:255",
            "customer_address" => "required|string|max:255",
            "customer_note" => "required|string"
        ];

        $data = $request->except("_token");

        // EMAIL KONTROL ETTIRME
        if ($data['customer_email'] != $item->customer_email){
            $kontrol = CustomerModel::where(array(
                "customer_email" => $data['customer_email']
            ))->first();

            if ($kontrol){
                $validateData['customer_email'] = "required|string|email|unique:customers|max:255";
            }else{
                $validateData['customer_email'] = "required|string|email|max:255";
            }
        }

        // TELEFON KONTROL ETTIRME
        if ($data['customer_phone'] != $item->customer_phone){
            $kontrol = CustomerModel::where(array(
                "customer_phone" => $data['customer_phone']
            ))->first();

            if ($kontrol){
                $validateData['customer_phone'] = "required|string|unique:customers|max:255";
            }else{
                $validateData['customer_phone'] = "required|string|max:255";
            }
        }

        $request->validate($validateData);

        $item->update($data);
    }

    // SILME KISMI
    public function delete(CustomerModel $item)
    {
        $item->delete();
    }
}
