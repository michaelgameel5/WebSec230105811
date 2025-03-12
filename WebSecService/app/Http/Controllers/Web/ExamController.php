<?php
namespace App\Http\Controllers\Web;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ExamController extends Controller
{
    public function list() {
        $questions = Question::all();
        return view('questions.list', compact('questions'));
    }

    public function create() {
        return view('questions.form');
    }

    public function store(Request $request) {
        Question::create([
            'text' => $request->text,
            'options' => explode(',', $request->options),
            'correct_answer' => $request->correct_answer,
        ]);

        return redirect()->route('questions.list')->with('success', 'Question added successfully!');
    }

    public function edit(Question $question) {
        return view('questions.form', compact('question'));
    }

    public function update(Request $request, Question $question) {
        $question->update([
            'text' => $request->text,
            'options' => explode(',', $request->options),
            'correct_answer' => $request->correct_answer,
        ]);

        return redirect()->route('questions.list')->with('success', 'Question updated!');
    }

    public function destroy(Question $question) {
        $question->delete();
        return redirect()->route('questions.list')->with('success', 'Question deleted!');
    }

    public function start() {
        $questions = Question::all();
        return view('questions.start', compact('questions'));
    }

    public function submit(Request $request) {
        $score = 0;
        $total = Question::count();

        foreach ($request->answers as $id => $answer) {
            $question = Question::find($id);
            if ($question->correct_answer == $answer) {
                $score++;
            }
        }

        return view('questions.result', compact('score', 'total'));
    }

    public function result() {
        return view('questions.result');
    }
}
