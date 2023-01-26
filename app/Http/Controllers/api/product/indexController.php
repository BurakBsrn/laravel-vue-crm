<?php

namespace App\Http\Controllers\api\product;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ProductImageModel;
use App\Models\ProductModel;
use App\Models\ProductPropertyModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class indexController extends Controller
{
    public $path;

    public function __construct()
    {
        $this->path = "product/";
    }

    public function index()
    {
        $data = ProductModel::where(array(
            "product_user_id" => auth('api')->user()->id
        ))->orderBy("product_id", "desc")->paginate(10);
        return response()->json($data, 200);
    }

    // ARAMA SAYFASI
    public function search(Request $request){
        $aranan = $request->aranan;
        $data = ProductModel::where(array(
            ["product_barcode","like","%$aranan%"],
            ["product_user_id","=",auth('api')->user()->id]
        ))->orderBy("product_id","desc")->paginate(10);

        $data->appends($aranan);
        return response()->json($data, 200);
    }

    // EKLEME SAYFASI
    public function create()
    {
        $categories = Category::where("category_user_id", auth('api')->user()->id)->get();
        return response()->json($categories, 200);
    }

    // EKLEME ISLEMI
    public function store(Request $request)
    {
        $request->validate(array(
            "product_category_id" => "required|string|max:255",
            "product_name" => "required|string|max:255",
            "product_barcode" => "required|string|unique:products|max:255",
            "product_model_code" => "required|string|unique:products|max:255",
            "product_brand" => "required|string|max:255",
            "product_stock" => "required|string|max:11",
            "product_tax" => "required|string|max:11",
            "product_buying_price" => "required|string|max:10",
            "product_selling_price" => "required|string|max:10",
        ));

        $data = $request->except("_token");

        $productCreate = ProductModel::create(array(
            "product_user_id" => auth('api')->user()->id,
            "product_category_id" => $data['product_category_id'],
            "product_name" => $data['product_name'],
            "product_barcode" => $data['product_barcode'],
            "product_model_code" => $data['product_model_code'],
            "product_brand" => $data['product_brand'],
            "product_stock" => $data['product_stock'],
            "product_tax" => $data['product_tax'],
            "product_buying_price" => $data['product_buying_price'],
            "product_selling_price" => $data['product_selling_price'],
            "product_description" => $data['product_description'],
        ));

        // RESIM YUKLEME KISIMLARI
        $productImageData = [];
        if (!empty($data['image'])) {
            foreach ($data['image'] as $image) {
                $base64_image = $image; // your base64 encoded
                @list($type, $file_data) = explode(';', $base64_image);
                @list(, $file_data) = explode(',', $file_data);
                $imageName = $this->path . Str::slug($data['product_name']) . "-" . uniqid();
                Image::make(base64_decode($file_data))->encode("webp", 90)->resize(350, 350)->save(public_path("storage/" . $imageName . ".webp"));

                $productImageData[] = $imageName . ".webp";
            }

            $this->uploadImageCreate($productImageData, $productCreate->product_id);
        }

        // OZELLIK EKLEME KISIMLARI
        $productProperty = json_decode($data['product_property']);
        $this->uploadPropertyCreate($productProperty, $productCreate->product_id);

    }

    // URUN RESIMLERI YUKLEME KISMI (CREATE)
    public function uploadImageCreate($productImageData, $productId)
    {
        if (!empty($productImageData)) {
            foreach ($productImageData as $image) {
                ProductImageModel::create(array(
                    "pi_product_id" => $productId,
                    "pi_path" => $image
                ));
            }
        }
    }

    // URUN OZELLIK YUKLEME KISM
    public function uploadPropertyCreate($productPropertyData, $productId)
    {
        if (!empty($productPropertyData)) {
            foreach ($productPropertyData as $property) {
                ProductPropertyModel::create(array(
                    "pp_product_id" => $productId,
                    "pp_property" => $property->property,
                    "pp_value" => $property->value
                ));
            }
        }
    }

    // GUNCELLEME KISMI
    public function edit(ProductModel $item)
    {
        $data['product'] = $item;
        $data['property'] = [];
        $data['images'] = [];

        // OZELLIKLER KISMI
        $ozellikler = json_decode(ProductPropertyModel::where("pp_product_id", $item->product_id)->get());
        foreach ($ozellikler as $ozellik) {
            $data['property'][] = [
                "property" => $ozellik->pp_property,
                "value" => $ozellik->pp_value
            ];
        }

        // RESIM KISMI
        $imageData = ProductImageModel::where("pi_product_id", $item->product_id)->get();
        foreach ($imageData as $image) {
            $code = base64_encode(File::get("storage/" . $image->pi_path));
            $data['images'][] = [
                "name" => explode("/",$image->pi_path)[1],
                "path" => "data:image/jpeg;base64,".$code
            ];
        }


        return response()->json($data, 200);
    }

    // GUNCELLEME KISMI
    public function update(Request $request,ProductModel $item){
        $data = $request->except("_token","_method");

        $validateData = [
            "product_category_id" => "required|string|max:255",
            "product_name" => "required|string|max:255",
            "product_brand" => "required|string|max:255",
            "product_stock" => "required|string|max:11",
            "product_tax" => "required|string|max:11",
            "product_buying_price" => "required|string|max:10",
            "product_selling_price" => "required|string|max:10",
        ];


        // BARKOD SORGULAMA
        if ($item->product_barcode!=$data['product_barcode']){
            $kontrol = ProductModel::where(array(
                "product_barcode"=>$data['product_barcode']
            ))->first();

            if ($kontrol){
                $validateData['product_barcode'] = "required|string|unique:products|max:255";
            }else{
                $validateData['product_barcode'] = "required|string|max:255";
            }
        }

        // MODEL KODU SORGULAMA
        if ($item->product_model_code!=$data['product_model_code']){
            $kontrol = ProductModel::where(array(
                "product_model_code"=>$data['product_model_code']
            ))->first();

            if ($kontrol){
                $validateData['product_model_code'] = "required|string|unique:products|max:255";
            }else{
                $validateData['product_model_code'] = "required|string|max:255";
            }
        }

        $request->validate($validateData);


        // GUNCELLEME KISMI
        $item->update(array(
            "product_category_id" => $data['product_category_id'],
            "product_name" => $data['product_name'],
            "product_barcode" => $data['product_barcode'],
            "product_model_code" => $data['product_model_code'],
            "product_brand" => $data['product_brand'],
            "product_stock" => $data['product_stock'],
            "product_tax" => $data['product_tax'],
            "product_buying_price" => $data['product_buying_price'],
            "product_selling_price" => $data['product_selling_price'],
            "product_description" => $data['product_description'],
        ));


        // RESIM YUKLEME ISLEMLERI
        $productImageData = [];
        if (!empty($data['image'])) {
            // O RESME AIT BUTUN KAYITLARI BI SILDIRELIM
            $this->deleteProductImages($item->product_id);

            foreach ($data['image'] as $image) {
                $base64_image = $image; // your base64 encoded
                @list($type, $file_data) = explode(';', $base64_image);
                @list(, $file_data) = explode(',', $file_data);
                $imageName = $this->path . Str::slug($data['product_name']) . "-" . uniqid();
                Image::make(base64_decode($file_data))->encode("webp", 90)->resize(350, 350)->save(public_path("storage/" . $imageName . ".webp"));

                $productImageData[] = $imageName . ".webp";
            }

            $this->uploadImageCreate($productImageData, $item->product_id);
        }

        // OZELLIK GUNCELLEME KISIMLARI
        if (!empty($data['product_property'])){
            // BU KAYDA AIT OLAN OZELLIKLERIN SILDIRILMESINI GERCEKLESTIRELIM
            $this->deleteProductProperties($item->product_id);

            $productProperty = json_decode($data['product_property']);
            $this->uploadPropertyCreate($productProperty, $item->product_id);
        }

    }
    // URUN FOTOGRAFLARINI SILME KISMI
    public function deleteProductImages($product_id){
        $productImages = ProductImageModel::where(array(
            "pi_product_id" => $product_id
        ))->get();

        if (!empty($productImages)){
            foreach ($productImages as $image){
                if ($image->pi_path != "" && File::exists("storage/".$image->pi_path)){
                    File::delete("storage/".$image->pi_path);
                }
            }

            ProductImageModel::where(array(
                "pi_product_id" => $product_id
            ))->delete();
        }
    }

    // URUN OZELLIKLERININ SILDIRILME KISMI
    public function deleteProductProperties($product_id){
        ProductPropertyModel::where(array(
            "pp_product_id" => $product_id
        ))->delete();
    }

    // DELETE KISMI
    public function delete(ProductModel $item)
    {
        $item->delete();

        ProductPropertyModel::where(array(
            "pp_product_id" => $item->product_id
        ))->delete();

        // RESIMLERI CEKIP SILDIRELIM
        $imageData = ProductImageModel::where(array(
            "pi_product_id" => $item->product_id
        ))->get();

        foreach ($imageData as $image) {
            if ($image->pi_path != "" && File::exists("storage/" . $image->pi_path)) {
                File::delete("storage/" . $image->pi_path);
            }
        }

        ProductImageModel::where(array(
            "pi_product_id" => $item->product_id
        ))->delete();
    }
}
