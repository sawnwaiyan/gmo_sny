<?php

namespace App\Http\Controllers;

use App\Services\ProductService;

use App\Models\MainMCode;
use App\Models\MCode;
use App\Models\Product;
use App\Services\MCodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use function PHPSTORM_META\map;

class ProductController extends Controller
{
    protected $productService;
    protected $mCodeService;

    public function __construct(ProductService $productService, MCodeService $mCodeService)
    {
        $this->productService = $productService;
        $this->mCodeService = $mCodeService;
    }

    public function create()
    {
        //コードリスト　COM001（公開プラグ）
        $publicFlg_codes = $this->mCodeService->getCodesByPaCd('COM001');

        //データ変換が必要な場合
        // $transformedRecords = $publicFlg_codes->map(function ($record) {
        //     return [
        //         'value' => $record->value,
        //         'label' => $record->label,
        //     ];
        // });

        return view('products.create', compact('publicFlg_codes'));
    }

    public function store(Request $request)
    {

        $rules = [
            'product_name' => 'required|max:255',
            'price' => 'required|integer|min:0',
            'product_description' => 'nullable',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'manufacturer' => 'nullable|max:255',
            'jan_code' => 'nullable|max:20',
            'category' => 'nullable|max:50',
            'tags' => 'nullable|max:50',
            'remarks' => 'nullable',
            'store_id' => 'required|integer|min:0',
            'public_flg' => 'required|boolean',
        ];

        $messages = [
            'jan_code.max' => 'JANコードは20桁以下の値を入力してください。'
            //ここにバリデーションメッセージを追加
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'message' => '入力エラーが発生しました。',
                'errors' => $validator->errors()->toArray()
            ], 422);
        }

        $validatedData = $validator->validated();

        if ($request->hasFile('product_image')) {
            $imagePath = $request->file('product_image')->store('product_images', 'public');
            $validatedData['product_image'] = $imagePath;
        }

        $validatedData['created_by'] = auth()->user()->name ?? 'system';
        $validatedData['updated_by'] = auth()->user()->name ?? 'system';

        try {
            Product::create($validatedData);
            return response()->json(['message' => '商品が正常に登録されました。'], 200);
        }
        // catch (ValidationException $e) {
        //     return response()->json([
        //         'message' => '入力エラーがあります。',
        //         'errors' => $e->errors()
        //     ], 422);
        // }
        catch (\Exception $e) {
            return response()->json(['message' => 'サーバーエラーが発生しました。'], 500);
        }
    }

    public function search()
    {
        return view('products.search');
    }

    public function searchProducts(Request $request)
    {
        $query = Product::query();

        if ($request->filled('keyword')) {
            $query->where('product_name', 'like', '%' . $request->keyword . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', 'like', '%' . $request->category . '%');
        }

        if ($request->filled('manufacturer')) {
            $query->where('manufacturer', 'like', '%' . $request->manufacturer . '%');
        }

        $products = $query->get();

        return response()->json($products);
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $publicFlg_codes = $this->mCodeService->getCodesByPaCd('COM001');
        return view('products.edit', compact('product', 'publicFlg_codes'));
    }



    // public function update(Request $request, $id)
    // {
    //     $rules = [
    //         'product_name' => 'required|max:255',
    //         'price' => 'required|integer|min:0',
    //         'product_description' => 'nullable',
    //         'manufacturer' => 'nullable|max:255',
    //         'jan_code' => 'nullable|max:20',
    //         'category' => 'nullable|max:50',
    //         'tags' => 'nullable|max:50',
    //         'remarks' => 'nullable',
    //         'store_id' => 'required|integer|min:0',
    //         'public_flg' => 'required|boolean',
    //     ];

    //     $messages = [
    //         'jan_code.max' => 'JANコードは20桁以下の値を入力してください。'
    //     ];

    //     $validator = Validator::make($request->all(), $rules, $messages);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'message' => '入力エラーが発生しました。',
    //             'errors' => $validator->errors()->toArray()
    //         ], 422);
    //     }

    //     $product = Product::findOrFail($id);
    //     $validatedData = $validator->validated();

    //     Log::info('Request has product_image: ' . $request->hasFile('product_image'));

    //     if ($request->hasFile('product_image')) {
    //         Log::info('Product image uploaded: ' . $request->file('product_image')->getClientOriginalName());

    //         // Delete the old image if it exists
    //         if ($product->product_image) {
    //             Log::info('Deleting old image: ' . $product->product_image);
    //             Storage::disk('public')->delete($product->product_image);
    //         }

    //         // Store the new image
    //         $imagePath = $request->file('product_image')->store('product_images', 'public');
    //         Log::info('New image path: ' . $imagePath);
    //         $validatedData['product_image'] = $imagePath;
    //     } else {
    //         // Preserve the old image if no new image is uploaded
    //         $validatedData['product_image'] = $product->product_image;
    //     }

    //     $validatedData['updated_by'] = auth()->user()->name ?? 'system';

    //     try {
    //         $product->update($validatedData);
    //         return response()->json(['message' => '商品が正常に更新されました。'], 200);
    //     } catch (\Exception $e) {
    //         Log::error('Error updating product: ' . $e->getMessage());
    //         return response()->json(['message' => 'サーバーエラーが発生しました。'], 500);
    //     }
    // }

    // public function update(Request $request, $id)
    // {
    //     $rules = [
    //         'product_name' => 'required|max:255',
    //         'price' => 'required|integer|min:0',
    //         'product_description' => 'nullable',
    //         'manufacturer' => 'nullable|max:255',
    //         'jan_code' => 'nullable|max:20',
    //         'category' => 'nullable|max:50',
    //         'tags' => 'nullable|max:50',
    //         'remarks' => 'nullable',
    //         'store_id' => 'required|integer|min:0',
    //         'public_flg' => 'required|boolean',
    //         // 'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Image validation rule
    //     ];

    //     $messages = [
    //         'jan_code.max' => 'JANコードは20桁以下の値を入力してください。',
    //     ];

    //     $validator = Validator::make($request->all(), $rules, $messages);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'message' => '入力エラーが発生しました。',
    //             'errors' => $validator->errors()->toArray()
    //         ], 422);
    //     }

    //     $product = Product::findOrFail($id);
    //     $validatedData = $validator->validated();

    //     Log::info('Request has product_image: ' . $request->hasFile('product_image'));

    //     if ($request->hasFile('product_image')) {
    //         Log::info('Product image uploaded: ' . $request->file('product_image')->getClientOriginalName());

    //         // Delete the old image if it exists
    //         if ($product->product_image) {
    //             Log::info('Deleting old image: ' . $product->product_image);
    //             Storage::disk('public')->delete($product->product_image);
    //         }

    //         // Store the new image
    //         try {
    //             $imagePath = $request->file('product_image')->store('product_images', 'public');
    //             Log::info('New image path: ' . $imagePath);
    //             $validatedData['product_image'] = $imagePath;
    //         } catch (\Exception $e) {
    //             Log::error('Error storing new image: ' . $e->getMessage());
    //             return response()->json(['message' => '画像の保存中にエラーが発生しました。'], 500);
    //         }
    //     } else {
    //         // Preserve the old image if no new image is uploaded
    //         $validatedData['product_image'] = $product->product_image;
    //     }

    //     $validatedData['updated_by'] = auth()->user()->name ?? 'system';

    //     try {
    //         $product->update($validatedData);
    //         return response()->json(['message' => '商品が正常に更新されました。'], 200);
    //     } catch (\Exception $e) {
    //         Log::error('Error updating product: ' . $e->getMessage());
    //         return response()->json(['message' => 'サーバーエラーが発生しました。'], 500);
    //     }
    // }

    public function update(Request $request, $id)
    {
        $rules = [
            'product_name' => 'required|max:255',
            'price' => 'required|integer|min:0',
            'product_description' => 'nullable',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image validation rule
            'manufacturer' => 'nullable|max:255',
            'jan_code' => 'nullable|max:20',
            'category' => 'nullable|max:50',
            'tags' => 'nullable|max:50',
            'remarks' => 'nullable',
            'store_id' => 'required|integer|min:0',
            'public_flg' => 'required|boolean',
        ];

        $messages = [
            'jan_code.max' => 'JANコードは20桁以下の値を入力してください。',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'message' => '入力エラーが発生しました。',
                'errors' => $validator->errors()->toArray()
            ], 422);
        }

        $validatedData = $validator->validated();

        $product = Product::findOrFail($id);

        if ($request->hasFile('product_image')) {
            // Log::info('Product image uploaded: ' . $request->file('product_image')->getClientOriginalName());
            // Delete the old image if it exists
            if ($product->product_image) {
                Storage::disk('public')->delete($product->product_image);
            }

            // Store the new image
            try {
                $imagePath = $request->file('product_image')->store('product_images', 'public');
                $validatedData['product_image'] = $imagePath;
            } catch (\Exception $e) {
                Log::error('Error storing new image: ' . $e->getMessage());
                return response()->json(['message' => '画像の保存中にエラーが発生しました。'], 500);
            }
        }

        $validatedData['updated_by'] = auth()->user()->name ?? 'system';

        try {
            $product->update($validatedData);
            return response()->json(['message' => '商品が正常に更新されました。'], 200);
        } catch (\Exception $e) {
            Log::error('Error updating product: ' . $e->getMessage());
            return response()->json(['message' => 'サーバーエラーが発生しました。'], 500);
        }
    }

}
