<?php

namespace App\Http\Controllers;

use App\Models\TpbQuestion;
use App\Models\Challenge;
use Illuminate\Http\Request;

class TpbQuestionController extends Controller
{
    /**
     * Display the instruments management dashboard (Questions & Challenges).
     */
    public function instrumentsIndex(Request $request)
    {
        $search = $request->get('search');

        $questions = TpbQuestion::when($search, function($q) use ($search) {
                $q->where('question_text', 'like', "%{$search}%")
                  ->orWhere('construct_type', 'like', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(10, ['*'], 'questions_page');

        $challenges = Challenge::when($search, function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(10, ['*'], 'challenges_page');

        return view('admin.instruments.index', compact('questions', 'challenges', 'search'));
    }

    /**
     * Store a new TPB Question.
     */
    public function storeQuestion(Request $request)
    {
        $validated = $request->validate([
            'construct_type' => 'required|in:attitude,subjective_norm,pbc,intention',
            'question_text' => 'required|string',
            'is_active' => 'required|boolean',
        ]);

        TpbQuestion::create($validated);

        return redirect()->route('admin.instruments.index')->with('success', 'Pertanyaan TPB baru berhasil ditambahkan!');
    }

    /**
     * Update a TPB Question.
     */
    public function updateQuestion(Request $request, $id)
    {
        $question = TpbQuestion::findOrFail($id);

        $validated = $request->validate([
            'construct_type' => 'required|in:attitude,subjective_norm,pbc,intention',
            'question_text' => 'required|string',
            'is_active' => 'required|boolean',
        ]);

        $question->update($validated);

        return redirect()->route('admin.instruments.index')->with('success', 'Pertanyaan TPB berhasil diperbarui!');
    }

    /**
     * Delete a TPB Question.
     */
    public function destroyQuestion($id)
    {
        $question = TpbQuestion::findOrFail($id);

        if ($question->tpbResponses()->exists()) {
            return redirect()->route('admin.instruments.index')->with('error', 'Pertanyaan ini tidak dapat dihapus karena sudah diisi oleh responden/siswa.');
        }

        $question->delete();

        return redirect()->route('admin.instruments.index')->with('success', 'Pertanyaan TPB berhasil dihapus!');
    }

    /**
     * Store a new Challenge.
     */
    public function storeChallenge(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'reward_points' => 'required|integer|min:1',
            'is_active' => 'required|boolean',
        ]);

        Challenge::create($validated);

        return redirect()->route('admin.instruments.index')->with('success', 'Tantangan mingguan baru berhasil ditambahkan!');
    }

    /**
     * Update a Challenge.
     */
    public function updateChallenge(Request $request, $id)
    {
        $challenge = Challenge::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'reward_points' => 'required|integer|min:1',
            'is_active' => 'required|boolean',
        ]);

        $challenge->update($validated);

        return redirect()->route('admin.instruments.index')->with('success', 'Tantangan berhasil diperbarui!');
    }

    /**
     * Delete a Challenge.
     */
    public function destroyChallenge($id)
    {
        $challenge = Challenge::findOrFail($id);

        if ($challenge->pointHistories()->exists()) {
            return redirect()->route('admin.instruments.index')->with('error', 'Tantangan ini tidak dapat dihapus karena siswa sudah mengklaim poin dari misi ini.');
        }

        $challenge->delete();

        return redirect()->route('admin.instruments.index')->with('success', 'Tantangan berhasil dihapus!');
    }
}
