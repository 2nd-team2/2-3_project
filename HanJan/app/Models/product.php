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
        'w_flg'
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
            return '당신의 향긋한 봄이 여기에';
        } else if($value == '1') {
            return '당신의 시원한 여름이 여기에';
        } else if($value == '2') {
            return '당신의 선선한 가을이 여기에';
        } else {
            return '당신의 포근한 겨울이 여기에';
        }
    }
}
