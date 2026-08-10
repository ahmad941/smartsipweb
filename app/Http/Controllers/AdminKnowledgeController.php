<?php

namespace App\Http\Controllers;

use App\Models\KnowledgeQuestion;
use Illuminate\Http\Request;

class AdminKnowledgeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $questions = KnowledgeQuestion::when($search, function($q) use ($search) {
                $q->where('question_text', 'like', "%{$search}%");
            })
            ->orderBy('id', 'asc')
            ->paginate(10);

        return view('admin.knowledge.index', compact('questions', 'search'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question_text' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_option' => 'required|in:A,B,C,D',
            'is_active' => 'required|boolean',
        ]);

        $options = [
            'A' => $validated['option_a'],
            'B' => $validated['option_b'],
            'C' => $validated['option_c'],
            'D' => $validated['option_d'],
        ];

        KnowledgeQuestion::create([
            'question_text' => $validated['question_text'],
            'options' => $options,
            'correct_option' => $validated['correct_option'],
            'is_active' => $validated['is_active'],
        ]);

        return redirect()->route('admin.knowledge.index')->with('success', 'Soal Pengetahuan Gula baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $question = KnowledgeQuestion::findOrFail($id);

        $validated = $request->validate([
            'question_text' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_option' => 'required|in:A,B,C,D',
            'is_active' => 'required|boolean',
        ]);

        $options = [
            'A' => $validated['option_a'],
            'B' => $validated['option_b'],
            'C' => $validated['option_c'],
            'D' => $validated['option_d'],
        ];

        $question->update([
            'question_text' => $validated['question_text'],
            'options' => $options,
            'correct_option' => $validated['correct_option'],
            'is_active' => $validated['is_active'],
        ]);

        return redirect()->route('admin.knowledge.index')->with('success', 'Soal Pengetahuan Gula berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $question = KnowledgeQuestion::findOrFail($id);
        $question->delete();

        return redirect()->route('admin.knowledge.index')->with('success', 'Soal Pengetahuan Gula berhasil dihapus!');
    }
}
