<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display all teachers.
     */
    public function index(Request $request)
    {
        $query = Teacher::query();

        /*
         * Search teachers by name or phone number.
         */
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where(
                    'name',
                    'like',
                    "%{$search}%"
                )
                ->orWhere(
                    'phone',
                    'like',
                    "%{$search}%"
                );

            });
        }

        $teachers = $query
            ->latest()
            ->get();

        return view(
            'teachers.index',
            compact('teachers')
        );
    }


    /**
     * Show the form for creating a teacher.
     */
    public function create()
    {
        return view('teachers.create');
    }


    /**
     * Store a new teacher.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'name' => 'required|string|max:255',

            'phone' => 'required|string|max:30',

        ]);


        Teacher::create($validated);


        return redirect()
            ->route('teachers.index')
            ->with(
                'success',
                'Teacher added successfully.'
            );
    }


    /**
     * Display a teacher.
     */
    public function show(Teacher $teacher)
    {
        $teacher->load('borrowings');

        return view(
            'teachers.show',
            compact('teacher')
        );
    }


    /**
     * Show the form for editing a teacher.
     */
    public function edit(Teacher $teacher)
    {
        return view(
            'teachers.edit',
            compact('teacher')
        );
    }


    /**
     * Update a teacher.
     */
    public function update(
        Request $request,
        Teacher $teacher
    ) {
        $validated = $request->validate([

            'name' => 'required|string|max:255',

            'phone' => 'required|string|max:30',

        ]);


        $teacher->update($validated);


        return redirect()
            ->route('teachers.index')
            ->with(
                'success',
                'Teacher updated successfully.'
            );
    }


    /**
     * Delete a teacher.
     */
    public function destroy(Teacher $teacher)
    {
        /*
         * Prevent deletion if the teacher
         * currently has a book that has not been returned.
         */
        $hasActiveBorrowings = $teacher->borrowings()
            ->whereNull('returned_date')
            ->exists();


        if ($hasActiveBorrowings) {

            return redirect()
                ->route('teachers.index')
                ->with(
                    'error',
                    'This teacher cannot be deleted because they still have a book that has not been returned.'
                );

        }


        $teacher->delete();


        return redirect()
            ->route('teachers.index')
            ->with(
                'success',
                'Teacher deleted successfully.'
            );
    }
}