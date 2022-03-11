<?php

namespace App\Http\Controllers;

use App\Http\Dto\ProductDto;
use App\Http\Services\ProductService;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $product = $this->productService->indexProduct();

        return view('product', [
            'products' => $product->map(function(Product $product) {
                return [
                    'id' => $product->id,
                    'article' => $product->ARTICLE,
                    'name' => $product->NAME,
                    'status' => $product->STATUS == 'available' ? 'доступен' : 'не доступен',
                    'data' => json_decode($product->DATA)
                ];
            })->keyBy('id')->all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'max:10'],
            'article' => ['required', 'regex:/^[a-z0-9]+$/i', 'unique:products,ARTICLE']
        ]);

        try {
            $product = $this->productService->storeProduct(ProductDto::map($request->all()));
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }

        if ($product->id) {
            $request->session()->flash('success', 'Данные сохранены');
        }


        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'max:10'],
            'article' => ['required', 'regex:/^[a-z0-9]+$/i']
        ]);

        try {
            $isUpdated = $this->productService->updateProduct(ProductDto::map($request->all()), $id);
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
        if ($isUpdated) {
            $request->session()->flash('success', 'Данные изменены');
        }

        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */
    public function destroy(int $id)
    {
        try {
            $this->productService->deleteProduct($id);
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }

        session()->flash('success', 'Данные удалены');

//        return redirect()->route('product.index');
    }
}
