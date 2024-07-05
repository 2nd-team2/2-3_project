<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'price',
        'count',
        'ml',
        'img',
        'info',
        'type',
        'season'
        
    ];


    /**
     * JSON으로 시리얼라이즈 할때, 날짜를 원하는 형식으로 포맷
     * 이 메소드가 없으면 디폴트는 UTC
     * 
     * @param \DataTimeInterface $date
     * 
     * @return String('Y-m-d H:i:s')
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        // return $date->format('Y-m-d H:i:s');
        return $date->format('Y-m-d'); // TODO월일만 필요해서 변경했습니다
    }

    /**
     * Accessor : Column type
     */
    public function getTypeAttribute($value) {
        return $value == '0' ? '탁주' : ($value == '1' ? '과일주' : '증류주');
    }

    public function getSeasonAttribute($value) {
        if ($value == '0') {
            return '봄';
        } else if ($value == '1') {
            return '여름';
        } else if ($value == '2') {
            return '가을';
        } else {
            return '겨울';
        }
    }
}
