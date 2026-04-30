<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'name',
        'policy_number',
        'benefit_plan_id'
    ];

    public function benefitPlan()
    {
        return $this->belongsTo(BenefitPlan::class);
    }

    public function claims()
    {
        return $this->hasMany(Claim::class);
    }
}