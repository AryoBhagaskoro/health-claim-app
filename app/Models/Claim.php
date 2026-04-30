<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
        protected $fillable = [
        'member_id',
        'claim_date',
        'claim_amount',
        'approved_amount',
        'excess_amount'
    ];
    public function member()
{
    return $this->belongsTo(Member::class);
}

}
