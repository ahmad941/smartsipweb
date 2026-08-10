<?php

namespace App\Http\Controllers;

use App\Models\BeverageCategory;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $categories = BeverageCategory::withCount('beverages')
            ->when($search, function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('admin.categories.index', compact('categories', 'search'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:beverage_categories,name',
        ]);

        BeverageCategory::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori minuman baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $category = BeverageCategory::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:beverage_categories,name,' . $id,
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori minuman berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $category = BeverageCategory::findOrFail($id);

        if ($category->beverages()->exists()) {
            return redirect()->route('admin.categories.index')->with('error', 'Kategori ini tidak dapat dihapus karena masih digunakan oleh produk minuman.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori minuman berhasil dihapus!');
    }
}
