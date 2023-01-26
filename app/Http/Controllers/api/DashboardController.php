<?php

namespace App\Http\Controllers\api;

use App\Helpers\FlashMessage\FlashMessageParameters;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CustomerModel;
use App\Models\ProductModel;
use App\Models\StockModel;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke(): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $data['hesaplar'] = CustomerModel::query()->where("customer_user_id", $user)->count();
        $data['urunler'] = ProductModel::where('product_user_id', $user)->count();
        $data['islemler'] = StockModel::where('stock_user_id', $user)->count();
        $data['kategoriler'] = Category::where('category_user_id', $user)->count();
        $data['instock'] = ProductModel::where(array(
            ["product_user_id", "=", $user],
            ["product_stock",">",0]
        ))->count();
        $data['outstock'] = ProductModel::where(array(
            ["product_user_id", "=", $user],
            ["product_stock","<=",0]
        ))->count();

        // STOK GİRİŞ DATALARI
        $stok_giris = StockModel::leftJoin("customers","customers.customer_id","=","stocks.stock_customer_id")
            ->where(array(
                ["stocks.stock_type","=",StockModel::ENTRY],
                ["stocks.stock_user_id","=",$user],
                ["stocks.stock_date",">=",DB::raw('(NOW() - INTERVAL 6 DAY)')]
            ))
            ->orderby("stocks.stock_id","desc")
            ->get();

        $stokGirisData['labels'] = [];
        $stokGirisData['data'] = [];

        if (!empty($stok_giris)){
            foreach ($stok_giris as $giris){
                $stokGirisData['labels'][] = $giris->customer_name;
                $stokGirisData['data'][] = $giris->stock_quantity;
            }
        }

        // STOK ÇIKIŞ DATALARI
        $stok_cikis = StockModel::leftJoin("customers","customers.customer_id","=","stocks.stock_customer_id")
            ->where(array(
                ["stocks.stock_type","=",StockModel::OUT],
                ["stocks.stock_user_id","=",$user],
                ["stocks.stock_date",">=",DB::raw('(NOW() - INTERVAL 6 DAY)')]
            ))
            ->orderby("stocks.stock_id","desc")
            ->get();

        $stokCikisData['labels'] = [];
        $stokCikisData['data'] = [];

        if (!empty($stok_cikis)){
            foreach ($stok_cikis as $cikis){
                $stokCikisData['labels'][] = $cikis->customer_name;
                $stokCikisData['data'][] = $cikis->stock_quantity;
            }
        }

        $data['stockGiris'] = $stokGirisData;
        $data['stockCikis'] = $stokCikisData;

        return FlashMessageParameters::success($data)->toJson();
    }
}
