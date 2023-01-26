<?php

namespace App\Http\Controllers\api\stock;

use App\Http\Controllers\Controller;
use App\Models\CustomerModel;
use App\Models\ProductModel;
use App\Models\StockModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class indexController extends Controller
{
    public function index()
    {
        $data = StockModel::
        leftJoin("products", "products.product_id", "=", "stocks.stock_product_id")
            ->leftJoin("customers", "customers.customer_id", "=", "stocks.stock_customer_id")->where(array(
                "stocks.stock_user_id" => auth('api')->user()->id
            ))->orderBy("stocks.stock_id", "desc")->paginate(10);
        return response()->json($data, 200);
    }

    // FİLTRELEME KISMI
    public function search(Request $request)
    {
        $aranan = $request->aranan;
        $data = StockModel::
        leftJoin("products", "products.product_id", "=", "stocks.stock_product_id")
            ->leftJoin("customers", "customers.customer_id", "=", "stocks.stock_customer_id")->where(array(
                ["stocks.stock_user_id", "=", auth('api')->user()->id],
                ["stocks.stock_date", "like", "%$aranan%"]
            ))->orderBy("stocks.stock_id", "desc")->paginate(10);

        $data->appends($aranan);
        return response()->json($data, 200);
    }

    // EKLEME KISMI
    public function create()
    {
        $data['products'] = ProductModel::where(array(
            "product_user_id" => auth('api')->user()->id
        ))->get();
        $data['stockType'] = [
            [
                "id" => StockModel::ENTRY,
                "name" => "Giriş"
            ],
            [
                "id" => StockModel::OUT,
                "name" => "Çıkış"
            ],
        ];
        $data['customers'] = CustomerModel::all();
        return response()->json($data, 200);
    }

    // EKLEME ISLEMI
    public function store(Request $request)
    {
        $request->validate(array(
            "stock_customer_id" => "required|max:11",
            "stock_product_id" => "required|max:11",
            "stock_quantity" => "required|max:11",
            "stock_total_price" => "required|max:15",
            "stock_date" => "required|max:10",
        ));


        $isStock = $request->stock_isStock;  // STOĞA YANSIMA KISMI
        $changeStockType = $request->stock_type; // STOK EKLEME Mİ ÇIKARMA MI ONA BAKALIM

        $data = $request->except("_token");

        $data['stock_user_id'] = auth('api')->user()->id;
        $stock = StockModel::create($data);

        if ($isStock == "true") {
            if ($changeStockType == StockModel::ENTRY) {
                ProductModel::where(array(
                    "product_id" => $stock->stock_product_id
                ))->increment("product_stock", $stock->stock_quantity);
            } else {
                ProductModel::where(array(
                    "product_id" => $stock->stock_product_id
                ))->decrement("product_stock", $stock->stock_quantity);
            }
        }
    }

    // GUNCELLEME KISMI
    public function edit(StockModel $item)
    {
        $data['products'] = ProductModel::where(array(
            "product_user_id" => auth('api')->user()->id
        ))->get();
        $data['stockType'] = [
            [
                "id" => StockModel::ENTRY,
                "name" => "Giriş"
            ],
            [
                "id" => StockModel::OUT,
                "name" => "Çıkış"
            ],
        ];
        $data['item'] = $item;
        $data['customers'] = CustomerModel::all();
        return response()->json($data, 200);
    }

    // GUNCELLEME KISMI
    public function update(Request $request, StockModel $item)
    {
        $request->validate(array(
            "stock_customer_id" => "required|max:11",
            "stock_product_id" => "required|max:11",
            "stock_quantity" => "required|max:11",
            "stock_total_price" => "required|max:15",
            "stock_date" => "required|max:10",
        ));

        $isStock = $request->stock_isStock;  // STOĞA YANSIMA KISMI
        $changeStockType = $request->stock_type; // STOK EKLEME Mİ ÇIKARMA MI ONA BAKALIM

        $data = $request->except("_token", "stockTypeString");

        if ($isStock) {
            $this->restartProductStock($item);

            /** YENİ STOK GUNCELLEMESI **/
            $item->update($data);
            if ($item->stock_type == StockModel::ENTRY) {
                ProductModel::where(array(
                    "product_user_id" => auth('api')->user()->id,
                    "product_id" => $item->stock_product_id
                ))->increment('product_stock', $item->stock_quantity);
            } else {
                ProductModel::where(array(
                    "product_user_id" => auth('api')->user()->id,
                    "product_id" => $item->stock_product_id
                ))->decrement('product_stock', $item->stock_quantity);
            }
        }
    }

    // STOK DUZELTME KISMI AYARLANMASI
    public function restartProductStock(StockModel $item)
    {
        // URUNU BI DUZELTELIM
        if ($item->stock_type == StockModel::ENTRY) {
            ProductModel::where(array(
                "product_user_id" => auth('api')->user()->id,
                "product_id" => $item->stock_product_id
            ))->decrement('product_stock', $item->stock_quantity);
        } else {
            ProductModel::where(array(
                "product_user_id" => auth('api')->user()->id,
                "product_id" => $item->stock_product_id
            ))->increment('product_stock', $item->stock_quantity);
        }
    }

    // SILME KISMI
    public function delete(StockModel $item)
    {
        if ($item->stock_isStock == 1) {
            if ($item->stock_type == StockModel::OUT) {
                ProductModel::where(array(
                    "product_id" => $item->stock_product_id,
                    "product_user_id" => auth('api')->user()->id
                ))->increment("product_stock", $item->stock_quantity);
            }

            if ($item->stock_type == StockModel::ENTRY) {
                ProductModel::where(array(
                    "product_id" => $item->stock_product_id,
                    "product_user_id" => auth('api')->user()->id
                ))->decrement("product_stock", $item->stock_quantity);
            }
        }

        $item->delete();
    }
}
