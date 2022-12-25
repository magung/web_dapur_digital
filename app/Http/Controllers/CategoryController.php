<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('category.index', compact('categories'));
    }
    public function create()
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'category_name' => 'required',
            'satuan' => 'required'
        ]);

        $category = Category::create([
            'category_name' => $request->category_name,
            'satuan' => $request->satuan
        ]);

        if ($category) {
            return redirect()
                ->route('category.index')
                ->with([
                    'success' => 'New Category has been created successfully'
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Some problem occurred, please try again'
                ]);
        }
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'category_name' => 'required',
            'satuan' => 'required'
        ]);

        $category = Category::findOrFail($id);

        $category->update([
            'category_name' => $request->category_name,
            'satuan' => $request->satuan
        ]);

        if ($category) {
            return redirect()
                ->route('category.index')
                ->with([
                    'success' => 'category has been updated successfully'
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Some problem has occured, please try again'
                ]);
        }
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        if ($category) {
            return redirect()
                ->route('category.index')
                ->with([
                    'success' => 'category has been deleted successfully'
                ]);
        } else {
            return redirect()
                ->route('category.index')
                ->with([
                    'error' => 'Some problem has occurred, please try again'
                ]);
        }
    }
}
