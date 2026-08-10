<?php

namespace App\Http\Controllers;

use App\Models\ResearchTeam;
use Illuminate\Http\Request;

class AdminTeamController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $teams = ResearchTeam::when($search, function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('role', 'like', "%{$search}%")
                  ->orWhere('institution', 'like', "%{$search}%");
            })
            ->orderBy('id', 'asc')
            ->paginate(10);

        return view('admin.teams.index', compact('teams', 'search'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'institution' => 'nullable|string|max:255',
            'photo_url' => 'nullable|string|max:255',
        ]);

        ResearchTeam::create($validated);

        return redirect()->route('admin.teams.index')->with('success', 'Anggota Tim Peneliti baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $member = ResearchTeam::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'institution' => 'nullable|string|max:255',
            'photo_url' => 'nullable|string|max:255',
        ]);

        $member->update($validated);

        return redirect()->route('admin.teams.index')->with('success', 'Data Tim Peneliti berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $member = ResearchTeam::findOrFail($id);
        $member->delete();

        return redirect()->route('admin.teams.index')->with('success', 'Anggota Tim Peneliti berhasil dihapus!');
    }
}
