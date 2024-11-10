<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

// use function Laravel\Prompts\table;

class ProductController extends Controller
{
    // index
    public function index(Request $request)
    {
        $products = Product::when($request->input('name'), function ($query, $name) {
                $query->where('name', 'like', '%' . $name . '%');
                // ->orWhere('category', 'like', '%' . $name . '%');
            })
            ->orderBy('created_at', 'DESC')->orderBy('is_available', 'DESC')->paginate(10);

        return view('pages.products.index', ['type_menu' => 'products'], compact('products'));
    }

    // create
    public function create()
    {
        $categories = DB::table('categories')->get();

        return view('pages.products.create', ['type_menu' => 'products'], compact('categories'));
    }

    // store
    public function store(Request $request)
    {
        // validate the request
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            // 'image' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'is_available' => 'required|boolean',
            'is_favorite' => 'required|boolean',
            'category_id' => 'required',
        ]);

        // store the request
        $product = new Product;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->is_available = $request->is_available;
        $product->is_favorite = $request->is_favorite;
        $product->category_id = $request->category_id;
        // $product->save();
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->extension();
            // $filename = date('dmyHis').'.'.$extension;
            $filename = $product->id.'.'.$extension;
            // $path = 
            Storage::putFileAs('public/products', $image, $filename);

            $product->image = 'storage/products/' . $filename;

            // $image->storeAs('public/products', $product->id . '.' . $image->getClientOriginalExtension());
            // $product->image = 'storage/products/' . $product->id . '.' . $image->getClientOriginalExtension();
            // $product->save();
        }
        $product->save();

        return redirect()->route('products.index')->with('success', 'Product create successfully');
    }

    // show
    public function show($id)
    {
        // return view('pages.products.show', ['type_menu' => 'products']);
    }

    // edit
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = DB::table('categories')->get();
        return view('pages.products.edit', ['type_menu' => 'products'], compact('product', 'categories'));
    }

    // update
    public function update(Request $request, $id)
    {
        // validate the request
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            // 'image' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'is_available' => 'required|boolean',
            'is_favorite' => 'required|boolean',
            'category_id' => 'required',
        ]);

        // store the request
        $product =  Product::find($id);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->is_available = $request->is_available;
        $product->is_favorite = $request->is_favorite;
        $product->category_id = $request->category_id;
        // $product->save();
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->extension();
            // $filename = date('dmyHis').'.'.$extension;
            $filename = $product->id.'.'.$extension;
            // $path = 
            Storage::putFileAs('public/products', $image, $filename);

            $product->image = 'storage/products/' . $filename;

            // $image->storeAs('public/products', $product->id . '.' . $image->getClientOriginalExtension());
            // $product->image = 'storage/products/' . $product->id . '.' . $image->getClientOriginalExtension();
            // $product->save();
        }
        $product->save();


        return redirect()->route('products.index')->with('success', 'Product update successfully');
    }

    // destroy
    public function destroy($id)
    {
        // delete the request
        $product = Product::find($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product delete successfully');
    }
}
