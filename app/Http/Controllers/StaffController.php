<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display all staff members.
     */
    public function index(Request $request)
    {
        $query = Staff::query();

        /*
         * Search staff by name or phone number.
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

        $staff = $query
            ->latest()
            ->get();

        return view(
            'staff.index',
            compact('staff')
        );
    }


    /**
     * Show the form for creating a staff member.
     */
    public function create()
    {
        return view('staff.create');
    }


    /**
     * Store a new staff member.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'name' => 'required|string|max:255',

            'phone' => 'required|string|max:30',

        ]);


        Staff::create($validated);


        return redirect()
            ->route('staff.index')
            ->with(
                'success',
                'Staff member added successfully.'
            );
    }


    /**
     * Display a staff member.
     */
    public function show(Staff $staff)
    {
        $staff->load('borrowings.book');

        return view(
            'staff.show',
            compact('staff')
        );
    }


    /**
     * Show the form for editing a staff member.
     */
    public function edit(Staff $staff)
    {
        return view(
            'staff.edit',
            compact('staff')
        );
    }


    /**
     * Update a staff member.
     */
    public function update(
        Request $request,
        Staff $staff
    ) {
        $validated = $request->validate([

            'name' => 'required|string|max:255',

            'phone' => 'required|string|max:30',

        ]);


        $staff->update($validated);


        return redirect()
            ->route('staff.index')
            ->with(
                'success',
                'Staff member updated successfully.'
            );
    }


    /**
     * Delete a staff member.
     */
    public function destroy(Staff $staff)
    {
        /*
         * Prevent deletion if the staff member
         * currently has a borrowed or overdue book.
         */
        if (
            $staff->borrowings()
                ->whereIn(
                    'status',
                    ['borrowed', 'overdue']
                )
                ->exists()
        ) {

            return redirect()
                ->route('staff.index')
                ->with(
                    'error',
                    'This staff member cannot be deleted because they currently have a borrowed or overdue book.'
                );

        }


        $staff->delete();


        return redirect()
            ->route('staff.index')
            ->with(
                'success',
                'Staff member deleted successfully.'
            );
    }
}
