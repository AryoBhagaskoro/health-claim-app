<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BenefitPlan extends Model
{
     protected $fillable = [
        'plan_name',
        'annual_limit'
    ];
    public function members()
{
    return $this->hasMany(Member::class);
}

}
