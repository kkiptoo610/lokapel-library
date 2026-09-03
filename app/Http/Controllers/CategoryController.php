<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display all categories and subcategories.
     */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | LOAD ALL CATEGORIES
        |--------------------------------------------------------------------------
        |
        | We load both main categories and subcategories because the index
        | page displays them together.
        |
        */

        $categories = Category::withCount('books')
            ->orderByRaw('CASE WHEN parent_id IS NULL THEN 0 ELSE 1 END')
            ->orderBy('parent_id')
            ->orderBy('name')
            ->get();


        return view(
            'categories.index',
            compact('categories')
        );
    }


    /**
     * Show the form for creating a category.
     */
    public function create(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | GET MAIN CATEGORIES
        |--------------------------------------------------------------------------
        |
        | Only main categories can be selected as parents.
        |
        */

        $categories = Category::whereNull('parent_id')
            ->orderBy('name')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | PRESELECT PARENT CATEGORY
        |--------------------------------------------------------------------------
        |
        | When the user clicks:
        |
        | Add Subcategory
        |
        | from a main category, the URL sends:
        |
        | ?parent_id=ID
        |
        */

        $parentId = $request->get('parent_id');


        return view(
            'categories.create',
            compact(
                'categories',
                'parentId'
            )
        );
    }


    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
                'unique:categories,name',
            ],

            'parent_id' => [
                'nullable',
                'exists:categories,id',
            ],

            'description' => [
                'nullable',
                'string',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | ENSURE PARENT IS A MAIN CATEGORY
        |--------------------------------------------------------------------------
        */

        if (!empty($validated['parent_id'])) {

            $parentCategory = Category::find(
                $validated['parent_id']
            );


            if (
                $parentCategory
                &&
                $parentCategory->parent_id !== null
            ) {

                return back()
                    ->withInput()
                    ->withErrors([

                        'parent_id' =>
                            'A subcategory cannot be used as a parent category.',

                    ]);

            }

        }


        Category::create(
            $validated
        );


        return redirect()
            ->route('categories.index')
            ->with(
                'success',
                'Category added successfully.'
            );
    }


    /**
     * Show the form for editing a category.
     */
    public function edit(Category $category)
    {
        /*
        |--------------------------------------------------------------------------
        | GET MAIN CATEGORIES
        |--------------------------------------------------------------------------
        |
        | Exclude the current category.
        |
        */

        $categories = Category::whereNull('parent_id')
            ->where(
                'id',
                '!=',
                $category->id
            )
            ->orderBy('name')
            ->get();


        return view(
            'categories.edit',
            compact(
                'category',
                'categories'
            )
        );
    }


    /**
     * Update the specified category.
     */
    public function update(
        Request $request,
        Category $category
    ) {

        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
                'unique:categories,name,' . $category->id,
            ],

            'parent_id' => [
                'nullable',
                'exists:categories,id',
            ],

            'description' => [
                'nullable',
                'string',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | PREVENT CATEGORY BECOMING ITS OWN PARENT
        |--------------------------------------------------------------------------
        */

        if (
            !empty($validated['parent_id'])
            &&
            (int) $validated['parent_id'] === (int) $category->id
        ) {

            return back()
                ->withInput()
                ->withErrors([

                    'parent_id' =>
                        'A category cannot be its own parent.',

                ]);

        }


        /*
        |--------------------------------------------------------------------------
        | ENSURE PARENT IS A MAIN CATEGORY
        |--------------------------------------------------------------------------
        */

        if (!empty($validated['parent_id'])) {

            $parentCategory = Category::find(
                $validated['parent_id']
            );


            if (
                $parentCategory
                &&
                $parentCategory->parent_id !== null
            ) {

                return back()
                    ->withInput()
                    ->withErrors([

                        'parent_id' =>
                            'A subcategory cannot be used as a parent category.',

                    ]);

            }

        }


        /*
        |--------------------------------------------------------------------------
        | PREVENT MAIN CATEGORY FROM BECOMING A SUBCATEGORY
        | IF IT ALREADY HAS CHILDREN
        |--------------------------------------------------------------------------
        */

        if (
            $category->children()->exists()
            &&
            !empty($validated['parent_id'])
        ) {

            return back()
                ->withInput()
                ->withErrors([

                    'parent_id' =>
                        'This category has subcategories and cannot become a subcategory itself.',

                ]);

        }


        $category->update(
            $validated
        );


        return redirect()
            ->route('categories.index')
            ->with(
                'success',
                'Category updated successfully.'
            );
    }


    /**
     * Remove the specified category.
     */
    public function destroy(Category $category)
    {

        /*
        |--------------------------------------------------------------------------
        | PREVENT DELETION IF CATEGORY CONTAINS BOOKS
        |--------------------------------------------------------------------------
        */

        if (
            $category->books()->exists()
        ) {

            return redirect()
                ->route('categories.index')
                ->with(
                    'error',
                    'This category cannot be deleted because it contains books.'
                );

        }


        /*
        |--------------------------------------------------------------------------
        | PREVENT DELETION IF CATEGORY CONTAINS SUBCATEGORIES
        |--------------------------------------------------------------------------
        */

        if (
            $category->children()->exists()
        ) {

            return redirect()
                ->route('categories.index')
                ->with(
                    'error',
                    'This category cannot be deleted because it contains subcategories.'
                );

        }


        $category->delete();


        return redirect()
            ->route('categories.index')
            ->with(
                'success',
                'Category deleted successfully.'
            );
    }
}