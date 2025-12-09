<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lessons = Lesson::with('group', 'instructor')->latest()->paginate(15);
        return view('admin.lessons.index', compact('lessons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $groups = Group::all();
        $instructors = User::all();
        return view('admin.lessons.create', compact('groups', 'instructors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'topic' => 'required|string|max:255',
            'id_group' => 'required|exists:groups,id_group',
            'id_user' => 'required|exists:users,id',
            'lesson_date' => 'required|date',
            'lesson_duration' => 'required|integer|min:1',
            'start_at' => 'required|date_format:H:i',
        ]);

        // End time-ni hisoblash
        $startTime = \DateTime::createFromFormat('H:i', $validated['start_at']);
        $startTime->modify('+' . $validated['lesson_duration'] . ' minutes');
        $validated['end_at'] = $startTime->format('H:i');

        Lesson::create($validated);

        return redirect()->route('admin.lessons.index')
            ->with('success', 'Dars muvaffaqiyatli yaratildi!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lesson $lesson)
    {
        $lesson->load('group', 'instructor');
        return view('admin.lessons.show', compact('lesson'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lesson $lesson)
    {
        $groups = Group::all();
        $instructors = User::all();
        return view('admin.lessons.edit', compact('lesson', 'groups', 'instructors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lesson $lesson)
    {
        $validated = $request->validate([
            'topic' => 'required|string|max:255',
            'id_group' => 'required|exists:groups,id_group',
            'id_user' => 'required|exists:users,id',
            'lesson_date' => 'required|date',
            'lesson_duration' => 'required|integer|min:1',
            'start_at' => 'required|date_format:H:i',
        ]);

        // End time-ni hisoblash
        $startTime = \DateTime::createFromFormat('H:i', $validated['start_at']);
        $startTime->modify('+' . $validated['lesson_duration'] . ' minutes');
        $validated['end_at'] = $startTime->format('H:i');

        $lesson->update($validated);

        return redirect()->route('admin.lessons.show', $lesson)
            ->with('success', 'Dars muvaffaqiyatli yangilandi!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson)
    {
        $lesson->delete();

        return redirect()->route('admin.lessons.index')
            ->with('success', 'Dars muvaffaqiyatli o\'chirildi!');
    }
}
