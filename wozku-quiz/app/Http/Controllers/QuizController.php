<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Option;
use App\Models\Attempt;
use App\Models\Answer;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::latest()->get();
        return view('quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        return view('quizzes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable'
        ]);

        Quiz::create($request->only('title', 'description'));

        return redirect('/quizzes')->with('success', 'Quiz Created Successfully');
    }

    public function questionCreate($quizId)
    {
        $quiz = Quiz::with('questions.options')->findOrFail($quizId);
        return view('questions.create', compact('quiz'));
    }

    public function questionStore(Request $request, $quizId)
    {
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('questions', 'public');
        }

        $question = Question::create([
            'quiz_id' => $quizId,
            'type' => $request->type,
            'question_text' => $request->question_text,
            'marks' => $request->marks,
            'correct_answer' => $request->correct_answer,
            'image' => $imagePath,
            'video_url' => $request->video_url
        ]);

        if ($request->options) {

            foreach ($request->options as $index => $text) {

                $optionImage = null;

                if (
                    $request->hasFile('option_images') &&
                    isset($request->file('option_images')[$index])
                ) {
                    $optionImage = $request->file('option_images')[$index]
                        ->store('options', 'public');
                }

                Option::create([
                    'question_id' => $question->id,
                    'option_text' => $text,
                    'image' => $optionImage,
                    'is_correct' => in_array($index, $request->correct_options ?? [])
                ]);
            }
        }

        return back()->with('success', 'Question Added');
    }

    public function attempt($quizId)
    {
        $quiz = Quiz::with('questions.options')->findOrFail($quizId);
        return view('quizzes.attempt', compact('quiz'));
    }

    public function submit(Request $request, $quizId)
    {
        $quiz = Quiz::with('questions.options')->findOrFail($quizId);

        $score = 0;

        $attempt = Attempt::create([
            'quiz_id' => $quizId,
            'score' => 0
        ]);

        foreach ($quiz->questions as $question) {

            $userAnswer = $request->input('answers.' . $question->id);

            Answer::create([
                'attempt_id' => $attempt->id,
                'question_id' => $question->id,
                'answer_text' => is_array($userAnswer)
                    ? json_encode($userAnswer)
                    : $userAnswer
            ]);

            if (
                $question->type == 'binary' ||
                $question->type == 'number' ||
                $question->type == 'text'
            ) {
                if (
                    strtolower(trim($userAnswer)) ==
                    strtolower(trim($question->correct_answer))
                ) {
                    $score += $question->marks;
                }
            }

            if ($question->type == 'single') {
                $correct = $question->options()
                    ->where('is_correct', 1)
                    ->first();

                if ($correct && $userAnswer == $correct->id) {
                    $score += $question->marks;
                }
            }

            if ($question->type == 'multiple') {
                $correctIds = $question->options()
                    ->where('is_correct', 1)
                    ->pluck('id')
                    ->toArray();

                sort($correctIds);

                $userIds = $userAnswer ?? [];
                sort($userIds);

                if ($correctIds == $userIds) {
                    $score += $question->marks;
                }
            }
        }

        $attempt->update([
            'score' => $score
        ]);

        return redirect('/attempts/' . $attempt->id);
    }

    public function result($attemptId)
    {
        $attempt = Attempt::with('quiz')->findOrFail($attemptId);

        $totalMarks = $attempt->quiz->questions()->sum('marks');

        return view('quizzes.result', compact('attempt', 'totalMarks'));
    }

    public function deleteQuestion($id)
    {
        $question = Question::findOrFail($id);
        $quizId = $question->quiz_id;

        $question->delete();

        return redirect('/quizzes/' . $quizId . '/questions/create')
            ->with('success', 'Question Deleted');
    }
}