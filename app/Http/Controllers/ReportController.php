<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function claims()
    {
       $data = DB::table('claims')
        ->join('members', 'claims.member_id', '=', 'members.id')
        ->join('benefit_plans', 'members.benefit_plan_id', '=', 'benefit_plans.id')
        ->select(
            'members.id as member_id',
            'members.name',
            'benefit_plans.plan_name',
            DB::raw('SUM(claim_amount) as total_claim'),
            DB::raw('SUM(approved_amount) as total_approved'),
            DB::raw('SUM(excess_amount) as total_excess')
        )
        ->groupBy('members.name', 'benefit_plans.plan_name', 'members.id')
        ->get();

    return response()->json($data);
    }
}