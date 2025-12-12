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
        $user = auth()->user();

        // Agar user'da view-lessons permission bo'lsa, barcha guruhlarni ko'rsat
        // Aks holda faqat o'z guruhini ko'rsat
        if ($user->can('view-lessons')) {
            $groups = Group::all();
        } else {
            // Faqat o'z guruhini ko'rsat
            // Agar user'da guruh bo'lmasa, xatolik qaytar
            if (!$user->group) {
                return redirect()->back()
                    ->with('error', 'Sizga guruh biriktirilmagan. Iltimos, avval guruh biriktiring.');
            }
            $groups = collect([$user->group]);
        }

        $instructors = User::all();
        return view('admin.lessons.create', compact('groups', 'instructors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        // Agar user'da view-lessons permission bo'lmasa va guruh bo'lmasa, xatolik qaytar
        if (!$user->can('view-lessons') && !$user->group) {
            return redirect()->back()
                ->with('error', 'Sizga guruh biriktirilmagan. Iltimos, avval guruh biriktiring.')
                ->withInput();
        }

        // Validation rules
        $rules = [
            'topic' => 'required|string|max:255',
            'lesson_date' => 'required|date',
            'lesson_duration' => 'required|integer|min:1',
            'start_at' => 'required|date_format:H:i',
        ];

        // Agar user'da view-lessons permission bo'lsa, guruh va o'qituvchini so'ra
        // Aks holda default qiymatlar ishlatiladi
        if ($user->can('view-lessons')) {
            $rules['id_group'] = 'required|exists:groups,id_group';
            $rules['id_user'] = 'required|exists:users,id';
        }

        $validated = $request->validate($rules);

        // Oddiy user uchun default qiymatlar
        if (!$user->can('view-lessons')) {
            $validated['id_group'] = $user->id_group;
            $validated['id_user'] = $user->id;
        }

        // start_at ni to'g'ri formatga o'tkazish (agar H:i:s formatida bo'lsa)
        if (isset($validated['start_at']) && strlen($validated['start_at']) > 5) {
            $validated['start_at'] = substr($validated['start_at'], 0, 5);
        }

        // End time-ni hisoblash
        $startTime = \DateTime::createFromFormat('H:i', $validated['start_at']);
        $startTime->modify('+' . $validated['lesson_duration'] . ' minutes');
        $validated['end_at'] = $startTime->format('H:i');

        $lesson = Lesson::create($validated);

        // Agar user'da view-lessons permission bo'lmasa, group journal sahifasiga redirect qil
        if (!$user->can('view-lessons')) {
            return redirect()->route('admin.group-journals.show', $user->group)
                ->with('success', 'Dars muvaffaqiyatli yaratildi!');
        }

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
        $user = auth()->user();

        // Agar user'da edit-lessons permission bo'lmasa, faqat o'zi qo'shgan lessonni tahrirlash imkoniyatiga ega
        if (!$user->can('edit-lessons')) {
            if ($lesson->id_user != $user->id) {
                abort(403, 'Siz faqat o\'zingiz qo\'shgan darslarni tahrirlashingiz mumkin');
            }
        }

        // Agar user'da view-lessons permission bo'lsa, barcha guruhlarni ko'rsat
        // Aks holda faqat o'z guruhini ko'rsat
        if ($user->can('view-lessons')) {
            $groups = Group::all();
        } else {
            // Faqat o'z guruhini ko'rsat
            $groups = $user->group ? collect([$user->group]) : collect();
        }

        $instructors = User::all();
        return view('admin.lessons.edit', compact('lesson', 'groups', 'instructors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lesson $lesson)
    {
        $user = auth()->user();

        // Agar user'da edit-lessons permission bo'lmasa, faqat o'zi qo'shgan lessonni tahrirlash imkoniyatiga ega
        if (!$user->can('edit-lessons')) {
            if ($lesson->id_user != $user->id) {
                abort(403, 'Siz faqat o\'zingiz qo\'shgan darslarni tahrirlashingiz mumkin');
            }
        }

        // Validation rules
        $rules = [
            'topic' => 'required|string|max:255',
            'lesson_date' => 'required|date',
            'lesson_duration' => 'required|integer|min:1',
            'start_at' => 'nullable|date_format:H:i',
        ];

        // Agar user'da view-lessons permission bo'lsa, guruh va o'qituvchini so'ra
        // Aks holda default qiymatlar ishlatiladi
        if ($user->can('view-lessons')) {
            $rules['id_group'] = 'required|exists:groups,id_group';
            $rules['id_user'] = 'required|exists:users,id';
        }

        $validated = $request->validate($rules);

        // Oddiy user uchun default qiymatlar
        if (!$user->can('view-lessons')) {
            $validated['id_group'] = $user->id_group;
            $validated['id_user'] = $user->id;
        }

        // start_at ni to'g'ri formatga o'tkazish (agar H:i:s formatida bo'lsa yoki bo'sh bo'lsa)
        if (empty($validated['start_at']) || !isset($validated['start_at'])) {
            // Agar bo'sh bo'lsa yoki o'zgartirilmagan bo'lsa, eski qiymatni ishlatish
            $validated['start_at'] = $lesson->start_at ? substr($lesson->start_at, 0, 5) : '00:00';
        } elseif (strlen($validated['start_at']) > 5) {
            // Agar H:i:s formatida bo'lsa, faqat H:i qismini olish
            $validated['start_at'] = substr($validated['start_at'], 0, 5);
        }

        // End time-ni hisoblash
        $startTime = \DateTime::createFromFormat('H:i', $validated['start_at']);
        if ($startTime === false) {
            // Agar format noto'g'ri bo'lsa, eski qiymatni ishlatish
            $oldStartTime = $lesson->start_at ? substr($lesson->start_at, 0, 5) : '00:00';
            $startTime = \DateTime::createFromFormat('H:i', $oldStartTime);
        }
        $startTime->modify('+' . $validated['lesson_duration'] . ' minutes');
        $validated['end_at'] = $startTime->format('H:i');

        $lesson->update($validated);

        // Agar user'da view-lessons permission bo'lmasa, group journal sahifasiga redirect qil
        if (!$user->can('view-lessons')) {
            return redirect()->route('admin.group-journals.show', $user->group)
                ->with('success', 'Dars muvaffaqiyatli yangilandi!');
        }

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

    /**
     * Show group journal - lessons grouped by months
     */
    public function groupJournal(Group $group)
    {
        $user = auth()->user();

        // Agar user'da view-lessons permission bo'lmasa, faqat o'z guruhidagi darslarni ko'ra oladi
        if (!$user->can('view-lessons')) {
            if ($group->id_group != $user->id_group) {
                abort(403, 'Siz faqat o\'z guruhingizdagi darslarni ko\'ra olasiz');
            }
        }

        $lessons = Lesson::where('id_group', $group->id_group)
            ->with('instructor')
            ->orderBy('lesson_date', 'desc')
            ->get();

        // Oylarga bo'lib guruhlash
        $monthNames = [
            1 => 'Yanvar', 2 => 'Fevral', 3 => 'Mart', 4 => 'Aprel',
            5 => 'May', 6 => 'Iyun', 7 => 'Iyul', 8 => 'Avgust',
            9 => 'Sentabr', 10 => 'Oktabr', 11 => 'Noyabr', 12 => 'Dekabr'
        ];

        $lessonsByMonth = $lessons->groupBy(function ($lesson) {
            return $lesson->lesson_date->format('Y-m');
        })->map(function ($monthLessons, $monthKey) use ($monthNames) {
            $date = \Carbon\Carbon::createFromFormat('Y-m', $monthKey);
            $monthName = $monthNames[$date->month] ?? $date->format('F');
            return [
                'month' => $monthName . ' ' . $date->year,
                'monthKey' => $monthKey,
                'lessons' => $monthLessons->sortBy('lesson_date')
            ];
        })->sortKeysDesc();

        return view('admin.group-journals.show', compact('group', 'lessonsByMonth'));
    }
}
