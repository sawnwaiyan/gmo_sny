<?php

namespace App\Services;

use App\Models\Product;

/**
 * 商品サービスプロセス
 */
class ProductService
{
    /**
     * 全件データ取得
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllProducts()
    {
        return Product::all();
    }

    /**
     * 新規登録
     *
     * @param array $data
     * @return \App\Models\Product
     */
    public function createProduct(array $data)
    {
        return Product::create($data);
    }

    /**
     * 商品データ取得 by ID.
     *
     * @param int $id
     * @return \App\Models\Product
     */
    public function getProductById($id)
    {
        return Product::findOrFail($id);
    }

    /**
     * 商品更新 by ID.
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\Product
     */
    public function updateProduct($id, array $data)
    {
        $product = Product::findOrFail($id);
        $product->update($data);
        return $product;
    }

    /**
     * 商品削除 by ID.
     *
     * @param int $id
     * @return \App\Models\Product
     */
    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return $product;
    }
}
