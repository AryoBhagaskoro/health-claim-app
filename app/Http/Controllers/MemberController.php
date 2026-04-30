<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         return Member::with('benefitPlan')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->user()->role === 'viewer') {
        return response()->json(['message' => 'Forbidden'], 403);
    }
          $request->validate([
            'name' => 'required',
            'policy_number' => 'required',
            'benefit_plan_id' => 'required|exists:benefit_plans,id'
        ]);

        $member = Member::create([
            'name' => $request->name,
            'policy_number' => $request->policy_number,
            'benefit_plan_id' => $request->benefit_plan_id
        ]);

        return response()->json($member);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $member = Member::findOrFail($id);

        $member->update([
            'name' => $request->name,
            'policy_number' => $request->policy_number,
            'benefit_plan_id' => $request->benefit_plan_id, // 🔥 WAJIB ADA
        ]);

        return response()->json($member);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $member = Member::find($id);

    if (!$member) {
        return response()->json(['message' => 'Not found'], 404);
    }

    $member->delete();

    return response()->json([
        'message' => 'Deleted successfully'
    ]);
    }
}
