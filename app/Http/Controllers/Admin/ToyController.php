<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Toy;
use App\Models\User;
use Illuminate\Http\Request;

class ToyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $toys = Toy::with('user')->latest()->paginate(15);
        return view('admin.toys.index', compact('toys'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('admin.toys.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:toys',
            'made_at' => 'nullable|integer|min:1900|max:' . date('Y'),
            'made_in' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'id_user' => 'nullable|exists:users,id',
        ]);

        Toy::create($validated);

        return redirect()->route('admin.toys.index')
            ->with('success', 'Qurol muvaffaqiyatli yaratildi!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Toy $toy)
    {
        $toy->load('user');
        return view('admin.toys.show', compact('toy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Toy $toy)
    {
        $users = User::all();
        return view('admin.toys.edit', compact('toy', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Toy $toy)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:toys,code,' . $toy->id_toy . ',id_toy',
            'made_at' => 'nullable|integer|min:1900|max:' . date('Y'),
            'made_in' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'id_user' => 'nullable|exists:users,id',
        ]);

        $toy->update($validated);

        return redirect()->route('admin.toys.show', $toy)
            ->with('success', 'Qurol muvaffaqiyatli yangilandi!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Toy $toy)
    {
        $toy->delete();

        return redirect()->route('admin.toys.index')
            ->with('success', 'Qurol muvaffaqiyatli o\'chirildi!');
    }
}
