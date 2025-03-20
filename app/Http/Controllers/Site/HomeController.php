<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\Traits\QueryParams;
use App\Models\Shop\Category;
use App\Models\Shop\Order;
use App\Models\Shop\Product;
use App\UseCase\CreateOrderService;
use Illuminate\Contracts\View\View;
use Butschster\Head\Contracts\MetaTags\MetaInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use QueryParams;

    private MetaInterface $meta;

    private CreateOrderService $service;

    public function __construct(MetaInterface $meta, CreateOrderService $service)
    {
        $this->meta = $meta;
        $this->service = $service;
    }

    public function index(Request $request): View
    {
        $this->meta->setTitle('Home');
        $this->meta->setDescription('This is the home page');

        $query = Product::with(['category']);
        $this->queryParams($request, $query);

        $products = $query->paginate(20);
        $categories = Category::all();

        return view('home', compact('products', 'categories'));
    }

    public function show(Product $product): View
    {
        return view('site.show', compact('product'));
    }

    public function getOrderForm(Request $request): JsonResponse
    {
        $product = Product::find($request->input('product_id'));
        $quantity = $request->input('product_quantity');
        $form = view('site.order-form', compact('product', 'quantity'))->render();

        return response()->json(compact('form'));
    }

    public function orderCreate(OrderRequest $request): RedirectResponse
    {
        $order = $this->service->checkout($request->validated());
        return redirect()->route('order.show', $order);
    }

    public function orderShow(Order $order): View
    {
        return view('order.show', compact('order'));
    }
}
