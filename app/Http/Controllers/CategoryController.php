<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    // index
    public function index(Request $request) 
    {
        $categories = DB::table('categories')
            ->when($request->input('name'), function ($query, $name) {
                $query->where('name', 'like', '%' . $name . '%');
            })
            ->orderBy('created_at', 'DESC')->paginate(10);
        
        return view('pages.categories.index', ['type_menu' => 'categories'], compact('categories'));
    }

    // create
    public function create() 
    {
        return view('pages.categories.create', ['type_menu' => 'categories']);
    }

    // store
    public function store(Request $request) 
    {
        // validate the request
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        // store the request
        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // $extension = $image->extension();
            // $filename = date('dmyHis').'.'.$extension;
            // // $path = 
            // Storage::putFileAs('public/products', $image, $filename);

            // $category->image = 'storage/products/' . $filename;

            $image->storeAs('public/categories', $category->id . '.' . $image->getClientOriginalExtension());
            $category->image = 'storage/categories/' . $category->id . '.' . $image->getClientOriginalExtension();
            // $category->save();
        }
        $category->save();
        
        return redirect()->route('categories.index')->with('success', 'Category create successfully');
    }

    // show
    public function show($id) 
    {
        return view('pages.categories.show', ['type_menu' => 'categories']);
    }

    // edit
    public function edit($id) {
        $category = Category::findOrFail($id);
        return view('pages.categories.edit', ['type_menu' => 'categories'], compact('category'));
    }

    // update
    public function update(Request $request, $id) 
    {
        // validate the request
        // validate the request
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        // store the request
        $category = Category::find($id);
        $category->name = $request->name;
        $category->description = $request->description;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // $extension = $image->extension();
            // $filename = date('dmyHis').'.'.$extension;
            // // $path = 
            // Storage::putFileAs('public/products', $image, $filename);

            // $category->image = 'storage/products/' . $filename;

            $image->storeAs('public/categories', $category->id . '.' . $image->getClientOriginalExtension());
            $category->image = 'storage/categories/' . $category->id . '.' . $image->getClientOriginalExtension();
            // $category->save();
        }
        $category->save();
        
        return redirect()->route('categories.index')->with('success', 'Category update successfully');
    }

    // destroy
    public function destroy($id)
    {
        // delete the request
        $category = Category::find($id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category delete successfully');
    }
}
