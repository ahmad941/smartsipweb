<?php

namespace App\Http\Controllers;

use App\Models\Beverage;
use App\Models\BeverageCategory;
use Illuminate\Http\Request;

class BeverageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $beverages = Beverage::with('category')
            ->when($search, function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('category', function($catQ) use ($search) {
                      $catQ->where('name', 'like', "%{$search}%");
                  });
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        $categories = BeverageCategory::orderBy('name')->get();
        
        return view('admin.beverages.index', compact('beverages', 'categories', 'search'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:beverage_categories,id',
            'sugar_per_100ml' => 'required|numeric|min:0',
            'image_url' => 'nullable|string|max:255',
        ]);

        Beverage::create($validated);

        return redirect()->route('beverages.index')->with('success', 'Minuman baru berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Beverage $beverage)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:beverage_categories,id',
            'sugar_per_100ml' => 'required|numeric|min:0',
            'image_url' => 'nullable|string|max:255',
        ]);

        $beverage->update($validated);

        return redirect()->route('beverages.index')->with('success', 'Data minuman berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Beverage $beverage)
    {
        // Pastikan tidak ada dependensi konsumsi sebelum menghapus
        if ($beverage->sugarConsumptions()->exists()) {
            return redirect()->route('beverages.index')->with('error', 'Minuman ini tidak dapat dihapus karena sudah dicatat dalam konsumsi siswa.');
        }

        $beverage->delete();

        return redirect()->route('beverages.index')->with('success', 'Minuman berhasil dihapus!');
    }
}
