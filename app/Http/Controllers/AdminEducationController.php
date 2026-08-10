<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\Request;

class AdminEducationController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $educations = Education::when($search, function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        $educations->getCollection()->transform(function($edu) {
            $edu->append('embed_url');
            return $edu;
        });

        return view('admin.educations.index', compact('educations', 'search'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:artikel,video,tips',
            'content' => 'required|string',
            'media_url' => 'nullable|string|max:255',
            'is_published' => 'required|boolean',
        ]);

        Education::create($validated);

        return redirect()->route('admin.educations.index')->with('success', 'Materi edukasi baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $education = Education::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:artikel,video,tips',
            'content' => 'required|string',
            'media_url' => 'nullable|string|max:255',
            'is_published' => 'required|boolean',
        ]);

        $education->update($validated);

        return redirect()->route('admin.educations.index')->with('success', 'Materi edukasi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $education = Education::findOrFail($id);
        $education->delete();

        return redirect()->route('admin.educations.index')->with('success', 'Materi edukasi berhasil dihapus!');
    }
}
