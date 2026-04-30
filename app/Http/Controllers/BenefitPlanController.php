<?php

namespace App\Http\Controllers;
use App\Models\BenefitPlan;

use Illuminate\Http\Request;

class BenefitPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
          return BenefitPlan::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
        'plan_name' => 'required',
        'annual_limit' => 'required|numeric'
    ]);

    $plan = BenefitPlan::create([
        'plan_name' => $request->plan_name,
        'annual_limit' => $request->annual_limit
    ]);

    return response()->json($plan);
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
        $request->validate([
        'plan_name' => 'required',
        'annual_limit' => 'required|numeric'
    ]);

    $plan = BenefitPlan::findOrFail($id);

    $plan->update([
        'plan_name' => $request->plan_name,
        'annual_limit' => $request->annual_limit
    ]);

    return response()->json($plan);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $plan = BenefitPlan::findOrFail($id);
        $plan->delete();

    return response()->json([
        'message' => 'Plan berhasil dihapus'
    ]);
    }
}
