<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Option;

class OptionController extends Controller
{

    public function show()
    {
        return view('options.category');
    }
    public function edit($id)
    {
        $category = Option::where('id', $id)->first();

        return view('options.editCategory', compact('category'));
    }
    public function manage()
    {
        $categories = Option::all();
        return view('options.manageCategory', compact('categories'));
    }
    // Insert Option
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|unique:options,category',
        ]);

        Option::create([
            'category' => $request->category,
        ]);

        return redirect()->back()->with('success', 'Option added successfully.');
    }

    // Update Category
    public function update(Request $request, Option $option)
    {
        $request->validate([
            'category' => 'required|unique:options,category,' . $option->id,
        ]);

        $option->update([
            'category' => $request->category,
        ]);

        return redirect()->back()->with('success', 'Category updated successfully.');
    }


    // Delete Option
    public function destroy(Option $Option)
    {
        $Option->delete();

        return redirect()->back()->with('success', 'Option deleted successfully.');
    }
}
