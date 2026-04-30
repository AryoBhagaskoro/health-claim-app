<?php

namespace App\Http\Controllers;
use App\Models\Member;
use App\Models\Claim;

use Illuminate\Http\Request;

class ClaimController extends Controller
{
    public function index()
{
    $claims = Claim::with('member.benefitPlan')->get();

    return response()->json($claims);
}
    public function store(Request $request)
{
    $request->validate([
        'member_id' => 'required|exists:members,id',
        'claim_date' => 'required|date',
        'claim_amount' => 'required|numeric|min:0'
    ]);

    $member = Member::with('benefitPlan')->findOrFail($request->member_id);

    if (!$member->benefitPlan) {
        return response()->json([
            'message' => 'Member tidak memiliki benefit plan'
        ], 400);
    }

    // Total approved sebelumnya
    $totalApproved = Claim::where('member_id', $member->id)
        ->sum('approved_amount');

    $annualLimit = $member->benefitPlan->annual_limit;

    // Hitung sisa limit
    $remainingLimit = $annualLimit - $totalApproved;

    // Approved
    $approved = min($request->claim_amount, max($remainingLimit, 0));

    // Excess
    $excess = $request->claim_amount - $approved;

    $claim = Claim::create([
        'member_id' => $member->id,
        'claim_date' => $request->claim_date,
        'claim_amount' => $request->claim_amount,
        'approved_amount' => $approved,
        'excess_amount' => $excess
    ]);

    return response()->json($claim);
}
}
