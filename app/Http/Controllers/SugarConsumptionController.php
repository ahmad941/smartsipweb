<?php

namespace App\Http\Controllers;

use App\Models\SugarConsumption;
use Illuminate\Http\Request;

class SugarConsumptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $beverages = \App\Models\Beverage::with('category')->get();
        return view('sugar-consumptions.create', compact('beverages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'beverage_id' => 'required|exists:beverages,id',
            'volume_ml' => 'required|numeric|min:1',
        ]);

        $beverage = \App\Models\Beverage::findOrFail($validated['beverage_id']);
        
        $totalSugarGrams = ($validated['volume_ml'] / 100) * $beverage->sugar_per_100ml;

        SugarConsumption::create([
            'user_id' => auth()->id(),
            'beverage_id' => $beverage->id,
            'volume_ml' => $validated['volume_ml'],
            'total_sugar_grams' => $totalSugarGrams,
            'consumed_at' => now(),
        ]);

        if ($totalSugarGrams > 25) {
            return redirect()->back()->with('warning', 'Hati-hati! Asupan gulamu kali ini cukup tinggi. Kamu pasti bisa menguranginya besok!');
        }

        return redirect()->back()->with('success', 'Konsumsi gula berhasil dicatat! Pertahankan kebiasaan sehatmu.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SugarConsumption $sugarConsumption)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SugarConsumption $sugarConsumption)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SugarConsumption $sugarConsumption)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $consumption = SugarConsumption::where('user_id', auth()->id())->findOrFail($id);
        $consumption->delete();

        return redirect()->back()->with('success', 'Catatan konsumsi gula berhasil dihapus!');
    }
}
