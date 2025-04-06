<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all(); // usa tus productos reales
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = \App\Models\Category::all();
        $themes = \App\Models\Theme::all();

        return view('admin.products.create', compact('categories', 'themes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'id_categoria' => 'required|exists:categories,id',
            'id_tematica' => 'required|exists:themes,id',
            'descripcion' => 'nullable|string',
            'precio_base' => 'required|numeric',
            'imagen' => 'nullable|image|max:2048',
            'status' => 'in:activo,inactivo',
        ]);

        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('products', 'public');
        }

        $validated['created_by'] = auth()->id(); // si usas auth

        \App\Models\Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Producto guardado exitosamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        Log::info('Entrando al método edit con producto: ' . $product->id);
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $product->update($request->only('name','description','price'));
        return redirect()->route('products.index')->with('success','Producto actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
