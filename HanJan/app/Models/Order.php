<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'or_id';
    public $timestamps = false;

    protected $fillable = [
        'u_id',
        'or_buy_name',
        'or_buy_tel',
        'or_get_name',
        'or_get_tel',
        'or_get_addr',
        'or_get_det_addr',
        'or_get_post',
        'or_sum',
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
        return $date->format('Y-m-d'); //시분초 없어도 괜찮아서 뺐습니다
    }
}
