<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    const ENTRY = 1;  // STOK GİRİŞ
    const OUT = 2;  // MÜŞTERİ

    protected $guarded = [];
    protected $table = "stocks";
    protected $primaryKey = "stock_id";

protected $appends = ["stockTypeString"];  // VERI TABANINDA BOYLE KOLON YOK BUNU EKLETTIRDIK

    public function getStockTypeStringAttribute(){
        switch ($this->attributes['stock_type']){
            case 1:
                return "Stok Giriş";
                break;
            case 2:
                return "Stok Çıkış";
                break;
            default:
                return "";
                break;
        }
    }
}
