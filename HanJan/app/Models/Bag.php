<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bag extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'ba_id';
    // public $timestamps = false;

    protected $fillable = [
        'u_id',
        'p_id',
        'ba_count',
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
