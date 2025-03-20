<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\Traits\QueryParams;
use App\Models\Shop\Category;
use App\Models\Shop\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    use QueryParams;


    public function index(Request $request):View
    {
        $query = Product::with(['category']);
        $this->queryParams($request, $query);

        $products = $query->paginate(20);
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function show(Product $product):View
    {
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product):View
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $product->update($request->validated());
        return redirect()->route('admin.products.show', compact('product'))->with('success', 'Товар успешно обновлен');
    }

    public function create():View
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        $product = new Product($request->validated());
        $product->save();
        return redirect()->route('admin.products.show', compact('product'))->with('success', 'Товар успешно создан');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Товар успешно удален из базы');
    }
}
