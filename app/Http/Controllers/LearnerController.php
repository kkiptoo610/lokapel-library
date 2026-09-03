<?php

namespace App\Http\Controllers;

use App\Models\Learner;

use Illuminate\Http\Request;

class LearnerController extends Controller
{

    /**
     * Display all learners.
     */

    public function index(Request $request)
    {

        $query = Learner::query();

        /*
         * Search learners.
         */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('name', 'like', "%{$search}%")

                    ->orWhere(
                        'admission_number',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'assessment_number',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'grade_class',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'stream',
                        'like',
                        "%{$search}%"
                    );

            });

        }


        /*
         * Arrange learners by:
         *
         * 1. Grade/Class number from smaller to bigger.
         * 2. Stream: West, then East.
         * 3. Admission number from smaller to bigger.
         */

        $learners = $query

            ->orderByRaw(
                "CAST(REGEXP_REPLACE(grade_class, '[^0-9]', '') AS UNSIGNED)"
            )

            ->orderByRaw(
                "
                CASE stream
                    WHEN 'West' THEN 1
                    WHEN 'East' THEN 2
                    ELSE 3
                END
                "
            )

            ->orderByRaw(
                "CAST(REGEXP_REPLACE(admission_number, '[^0-9]', '') AS UNSIGNED)"
            )

            ->get();


        return view(
            'learners.index',
            compact('learners')
        );

    }



    /**
     * Show the form for adding one learner.
     */

    public function create()
    {

        return view('learners.create');

    }



    /**
     * Store one learner.
     */

    public function store(Request $request)
    {

        $validated = $request->validate([

            'name' => 'required|string|max:255',

            'admission_number' =>
                'required|string|max:100|unique:learners,admission_number',

            'assessment_number' =>
                'nullable|string|max:100|unique:learners,assessment_number',

            'grade_class' =>
                'required|string|max:100',

            'stream' =>
                'required|in:East,West',

        ]);


        Learner::create($validated);


        return redirect()
            ->route('learners.index')
            ->with(
                'success',
                'Learner added successfully.'
            );

    }



    /**
     * Display one learner.
     */

    public function show(Learner $learner)
    {

        $learner->load('borrowings.book');

        return view(
            'learners.show',
            compact('learner')
        );

    }



    /**
     * Show the form for editing a learner.
     */

    public function edit(Learner $learner)
    {

        return view(
            'learners.edit',
            compact('learner')
        );

    }



    /**
     * Update learner information.
     */

    public function update(
        Request $request,
        Learner $learner
    ) {

        $validated = $request->validate([

            'name' =>
                'required|string|max:255',

            'admission_number' =>
                'required|string|max:100|unique:learners,admission_number,' .
                $learner->id,

            'assessment_number' =>
                'nullable|string|max:100|unique:learners,assessment_number,' .
                $learner->id,

            'grade_class' =>
                'required|string|max:100',

            'stream' =>
                'required|in:East,West',

        ]);


        $learner->update($validated);


        return redirect()
            ->route('learners.index')
            ->with(
                'success',
                'Learner updated successfully.'
            );

    }



    /**
     * Delete learner.
     */

    public function destroy(Learner $learner)
    {

        /*
         * Prevent deletion if the learner
         * currently has a borrowed or overdue book.
         */

        if (

            $learner->borrowings()

                ->whereIn(
                    'status',
                    [
                        'borrowed',
                        'overdue',
                    ]
                )

                ->exists()

        ) {

            return redirect()
                ->route('learners.index')
                ->with(
                    'error',
                    'This learner cannot be deleted because they currently have a borrowed or overdue book.'
                );

        }


        $learner->delete();


        return redirect()
            ->route('learners.index')
            ->with(
                'success',
                'Learner deleted successfully.'
            );

    }



    /**
     * Show the batch upload page.
     */

    public function showImportForm()
    {

        return view('learners.import');

    }



    /**
     * Import learners from CSV.
     */

    public function import(Request $request)
    {

        $request->validate([

            'grade_class' =>
                'required|string|max:100',

            'stream' =>
                'required|in:East,West',

            'csv_file' =>
                'required|file|mimes:csv,txt|max:5120',

        ]);


        $file = $request->file('csv_file');


        $handle = fopen(
            $file->getRealPath(),
            'r'
        );


        if ($handle === false) {

            return back()->with(
                'error',
                'Unable to read the uploaded CSV file.'
            );

        }


        /*
         * Read the first row as headers.
         */

        $headers = fgetcsv($handle);


        if ($headers === false) {

            fclose($handle);

            return back()->with(
                'error',
                'The CSV file is empty.'
            );

        }


        /*
         * Remove BOM and spaces.
         */

        $headers = array_map(

            function ($header) {

                return trim(
                    preg_replace(
                        '/^\xEF\xBB\xBF/',
                        '',
                        $header
                    )
                );

            },

            $headers

        );


        /*
         * Required CSV headers.
         */

        $requiredHeaders = [

            'name',

            'admission_number',

            'assessment_number',

        ];


        foreach ($requiredHeaders as $requiredHeader) {

            if (

                !in_array(
                    $requiredHeader,
                    $headers,
                    true
                )

            ) {

                fclose($handle);

                return back()->with(
                    'error',
                    'CSV file must contain these columns: name, admission_number, assessment_number.'
                );

            }

        }


        /*
         * Get positions of the columns.
         */

        $nameIndex = array_search(
            'name',
            $headers,
            true
        );


        $admissionIndex = array_search(
            'admission_number',
            $headers,
            true
        );


        $assessmentIndex = array_search(
            'assessment_number',
            $headers,
            true
        );


        $imported = 0;

        $skipped = 0;

        $rowNumber = 1;


        while (
            ($row = fgetcsv($handle))
            !== false
        ) {

            $rowNumber++;


            /*
             * Skip completely empty rows.
             */

            if (

                empty(

                    array_filter(

                        $row,

                        fn ($value) =>

                            trim(
                                (string) $value
                            ) !== ''

                    )

                )

            ) {

                continue;

            }


            $name = trim(
                (string) (
                    $row[$nameIndex] ?? ''
                )
            );


            $admissionNumber = trim(
                (string) (
                    $row[$admissionIndex] ?? ''
                )
            );


            $assessmentNumber = trim(
                (string) (
                    $row[$assessmentIndex] ?? ''
                )
            );


            /*
             * Name and admission number are required.
             */

            if (

                $name === '' ||

                $admissionNumber === ''

            ) {

                $skipped++;

                continue;

            }


            /*
             * Skip duplicate admission numbers.
             */

            if (

                Learner::where(
                    'admission_number',
                    $admissionNumber
                )->exists()

            ) {

                $skipped++;

                continue;

            }


            /*
             * Skip duplicate assessment numbers.
             */

            if (

                $assessmentNumber !== '' &&

                Learner::where(
                    'assessment_number',
                    $assessmentNumber
                )->exists()

            ) {

                $skipped++;

                continue;

            }


            /*
             * Create learner.
             */

            Learner::create([

                'name' =>
                    $name,

                'admission_number' =>
                    $admissionNumber,

                'assessment_number' =>

                    $assessmentNumber !== ''
                        ? $assessmentNumber
                        : null,

                'grade_class' =>
                    $request->grade_class,

                'stream' =>
                    $request->stream,

            ]);


            $imported++;

        }


        fclose($handle);


        return redirect()
            ->route('learners.index')
            ->with(
                'success',
                $imported .
                ' learner(s) imported successfully. ' .
                $skipped .
                ' duplicate or invalid row(s) were skipped.'
            );

    }



    /**
     * Download CSV template.
     */

    public function downloadTemplate()
    {

        $filename =
            'learners_import_template.csv';


        $headers = [

            'Content-Type' =>
                'text/csv',

            'Content-Disposition' =>
                'attachment; filename="' .
                $filename .
                '"',

        ];


        $callback = function () {

            $file =
                fopen(
                    'php://output',
                    'w'
                );


            /*
             * CSV headers.
             */

            fputcsv(
                $file,
                [
                    'name',
                    'admission_number',
                    'assessment_number',
                ]
            );


            /*
             * Example learner.
             */

            fputcsv(
                $file,
                [
                    'John Kamau',
                    'ADM001',
                    'ASSESS001',
                ]
            );


            /*
             * Example learner without assessment number.
             */

            fputcsv(
                $file,
                [
                    'Mary Wanjiku',
                    'ADM002',
                    '',
                ]
            );


            fclose($file);

        };


        return response()
            ->stream(
                $callback,
                200,
                $headers
            );

    }

}