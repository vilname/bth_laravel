<?php

namespace App\Http\Services;

use App\Http\Dto\ProductDto;
use App\Models\Product;

class ProductService
{
    public function indexProduct()
    {
        return Product::query()->orderBy('id')->get();
    }

    public function storeProduct(ProductDto $productDto): Product
    {
        $data = array_combine($productDto->attributeName, $productDto->attributeValue);

         return Product::create([
            'ARTICLE' => $productDto->article,
            'NAME' => $productDto->name,
            'STATUS' => $productDto->status,
            'DATA' => $data ? json_encode($data) : null
        ]);
    }

    public function updateProduct(ProductDto $productDto, int $id): bool
    {
        $product = Product::find($id);
        $data = array_combine($productDto->attributeName, $productDto->attributeValue);

        return $product->update([
            'ARTICLE' => $productDto->article,
            'NAME' => $productDto->name,
            'STATUS' => $productDto->status,
            'DATA' => $data ? json_encode($data) : null
        ]);
    }

    public function deleteProduct(int $id)
    {
        $product = Product::find($id);
        $product->delete();
    }
}
