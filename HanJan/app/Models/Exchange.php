<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exchange extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'ex_id';
    // public $timestamps = false;

    protected $fillable = [
        'u_id',
        'orp_id',
        'ex_name',
        'ex_tel',
        'ex_addr',
        'ex_det_addr',
        'ex_post',
        'ex_reason',
        'ex_reason_etc',
        'ex_flg',
        'created_at',
    ];


    /**
     * JSON으로 시리얼라이즈 할때, 날짜를 원하는 형식으로 포맷
     * 이 메소드가 없으면 디폴트는 UTC
     * 
     * @param \DataTimeInterface $date
     * 
     * @return String('Y-m-d')
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d'); //시분초 없어도 괜찮아서 뺐습니다
    }

    /**
     * Accessor : Column type
     */
    
    public function getExReasonAttribute($value) {
        if ($value == '0') {
            return '단순변심';
        } else if ($value == '1') {
            return '상품 배송 오류';
        } else if ($value == '2') {
            return '구성 품족';
        } else if ($value == '3') {
            return '파손, 결함';
        } else {
            return '기타';
        }
    }
    public function getExFlgAttribute($value) {
        if ($value == '0') {
            return '신청완료';
        } else if ($value == '1') {
            return '상품처리중';
        } else if ($value == '2') {
            return '처리완료';
        } else {
            return '미신청';
        }
    }
}
