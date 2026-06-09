<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizOption;
use App\Models\QuizAttempt;
use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    protected function getTeacherCourseIds()
    {
        return Course::where('instructor_id', auth()->id())->orWhere('user_id', auth()->id())->pluck('id')->toArray();
    }

    public function index()
    {
        $courseIds = $this->getTeacherCourseIds();
        $quizzes = Quiz::whereIn('course_id', $courseIds)->with(['course', 'module'])->orderBy('sort_order')->get();
        return view('teacher.quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        $courses = Course::where('instructor_id', auth()->id())->orWhere('user_id', auth()->id())->get();
        $modules = Module::whereIn('course_id', $courses->pluck('id'))->get();
        return view('teacher.quizzes.create', compact('courses', 'modules'));
    }

    public function store(Request $request)
    {
        $courseIds = $this->getTeacherCourseIds();
        if (!in_array($request->course_id, $courseIds)) {
            abort(403);
        }

        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'module_id' => 'nullable|exists:modules,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_minutes' => 'nullable|integer|min:1',
            'pass_percentage' => 'required|integer|min:1|max:100',
            'max_attempts' => 'required|integer|min:1',
            'sort_order' => 'required|integer',
            'is_published' => 'nullable|boolean',
        ]);

        Quiz::create($request->all());

        return redirect()->route('teacher.quizzes.index')->with('success', __('Test created successfully!'));
    }

    public function edit(Quiz $quiz)
    {
        $courseIds = $this->getTeacherCourseIds();
        if (!in_array($quiz->course_id, $courseIds)) {
            abort(403);
        }

        $courses = Course::where('instructor_id', auth()->id())->orWhere('user_id', auth()->id())->get();
        $modules = Module::whereIn('course_id', $courses->pluck('id'))->get();
        return view('teacher.quizzes.edit', compact('quiz', 'courses', 'modules'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $courseIds = $this->getTeacherCourseIds();
        if (!in_array($quiz->course_id, $courseIds) || !in_array($request->course_id, $courseIds)) {
            abort(403);
        }

        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'module_id' => 'nullable|exists:modules,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_minutes' => 'nullable|integer|min:1',
            'pass_percentage' => 'required|integer|min:1|max:100',
            'max_attempts' => 'required|integer|min:1',
            'sort_order' => 'required|integer',
            'is_published' => 'required|boolean',
        ]);

        $quiz->update($request->all());

        return redirect()->route('teacher.quizzes.index')->with('success', __('The test has been updated!'));
    }

    public function destroy(Quiz $quiz)
    {
        $courseIds = $this->getTeacherCourseIds();
        if (!in_array($quiz->course_id, $courseIds)) {
            abort(403);
        }

        $quiz->delete();

        return redirect()->route('teacher.quizzes.index')->with('success', __('Test disabled.'));
    }

    public function questions(Quiz $quiz)
    {
        $courseIds = $this->getTeacherCourseIds();
        if (!in_array($quiz->course_id, $courseIds)) {
            abort(403);
        }

        $questions = QuizQuestion::where('quiz_id', $quiz->id)->with('options')->orderBy('sort_order')->get();
        return view('teacher.quizzes.questions', compact('quiz', 'questions'));
    }

    public function storeQuestion(Request $request, Quiz $quiz)
    {
        $courseIds = $this->getTeacherCourseIds();
        if (!in_array($quiz->course_id, $courseIds)) {
            abort(403);
        }

        $request->validate([
            'question' => 'required|string',
            'points' => 'required|integer|min:1',
            'explanation' => 'nullable|string',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
            'correct_option' => 'required|integer',
        ]);

        $qq = QuizQuestion::create([
            'quiz_id' => $quiz->id,
            'question' => $request->question,
            'points' => $request->points,
            'explanation' => $request->explanation,
            'sort_order' => QuizQuestion::where('quiz_id', $quiz->id)->count() + 1,
        ]);

        foreach ($request->options as $index => $optText) {
            QuizOption::create([
                'question_id' => $qq->id,
                'option_text' => $optText,
                'is_correct' => $request->correct_option == $index,
                'sort_order' => $index + 1,
            ]);
        }

        return redirect()->route('teacher.quizzes.questions', $quiz->id)->with('success', __('Question added successfully!'));
    }

    public function updateQuestion(Request $request, Quiz $quiz, $questionId)
    {
        $courseIds = $this->getTeacherCourseIds();
        if (!in_array($quiz->course_id, $courseIds)) {
            abort(403);
        }

        $question = QuizQuestion::where('quiz_id', $quiz->id)->findOrFail($questionId);

        $request->validate([
            'question' => 'required|string',
            'points' => 'required|integer|min:1',
            'explanation' => 'nullable|string',
            'options' => 'required|array|min:2',
            'options.*' => 'nullable|string',
            'correct_option' => 'required|integer',
        ]);

        $question->update([
            'question' => $request->question,
            'points' => $request->points,
            'explanation' => $request->explanation,
        ]);

        // Delete old options and insert new ones
        $question->options()->delete();

        foreach ($request->options as $index => $optText) {
            if ($optText !== null && trim($optText) !== '') {
                QuizOption::create([
                    'question_id' => $question->id,
                    'option_text' => $optText,
                    'is_correct' => $request->correct_option == $index,
                    'sort_order' => $index + 1,
                ]);
            }
        }

        return redirect()->route('teacher.quizzes.questions', $quiz->id)->with('success', __('Question updated successfully!'));
    }

    public function destroyQuestion(Quiz $quiz, $questionId)
    {
        $courseIds = $this->getTeacherCourseIds();
        if (!in_array($quiz->course_id, $courseIds)) {
            abort(403);
        }

        $question = QuizQuestion::where('quiz_id', $quiz->id)->findOrFail($questionId);
        $question->options()->delete();
        $question->delete();

        return redirect()->route('teacher.quizzes.questions', $quiz->id)->with('success', __('Question deleted successfully!'));
    }

    public function results(Quiz $quiz)
    {
        $courseIds = $this->getTeacherCourseIds();
        if (!in_array($quiz->course_id, $courseIds)) {
            abort(403);
        }

        $attempts = QuizAttempt::where('quiz_id', $quiz->id)->with('user')->orderBy('created_at', 'desc')->get();
        return view('teacher.quizzes.results', compact('quiz', 'attempts'));
    }
}