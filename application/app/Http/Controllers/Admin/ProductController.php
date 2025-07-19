<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;
use App\Services\ProductService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use function Ramsey\Uuid\v1;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {

        $pageTitle = 'All Products';
        $products = $this->productService->index();
        return view('admin.products.index', compact('products', 'pageTitle'));
    }

    public function create()
    {
        $pageTitle = 'Add Product';
        $categories = $this->productService->create();
        return view('admin.products.create', compact('pageTitle', 'categories'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'price' => 'required|gt:0',
            'category_id' => 'required',
            'demo_link' => 'required|url',
            'external_link' => 'nullable|url',
            'discount' => 'nullable|numeric|between:0,99.99',
            'images.*' => ['required', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'thumbnail' => ['required', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'file.*' => ['nullable','file', new FileTypeValidate(['zip','rar','txt','doc','pdf','xlsx','docx','ppt','pptx',])],
        ])->after(function ($validator) use ($request) {
            if (!$request->filled('external_link') && !$request->hasFile('file')) {
                $validator->errors()->add('external_link', 'Either external link or file must be present.');
                $validator->errors()->add('file', 'Either external link or file must be present.');
            }
        });

        // field validation
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $request;
        $product = $this->productService->storeProduct($data);

        if ($product) {
            return response()->json([
                'message' => 'Product has been created successfully',
                'product' => $product,
            ]);
        } else {
            return response()->json([
                'message' => 'Product could not be created. Please try again later.',
            ], 500);
        }
    }

    public function edit($id)
    {
        $pageTitle = 'Update';
        $categories = Category::where('status', 1)->get();
        $product = $this->productService->edit($id);
        $productImage = ProductImage::where('product_id', $id)->get();
        return view('admin.products.edit', compact('pageTitle', 'categories', 'product', 'productImage'));

    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'price' => 'required',
            'discount' => 'nullable|numeric|between:0,99.99',
            'category_id' => 'required',
            'demo_link' => 'required|url',
            'thumbnail' => ['image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'images.*' => ['required', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'file.*' => ['nullable','file', new FileTypeValidate(['zip','rar','txt','doc','pdf','xlsx','docx','ppt','pptx',])],
        ]);

        // field validation
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $request;
        $product = $this->productService->updateProduct($data);

        if ($product) {
            return response()->json([
                'message' => 'Product has been updated successfully',
                'product' => $product,
            ]);
        } else {
            return response()->json([
                'message' => 'Product could not be updated. Please try again later.',
            ], 500);
        }
    }

    public function imageRemove(Request $request)
    {

        $request->validate([
            'id' => 'required'
        ]);

        $data = $request;
        $imageRemove = $this->productService->imageRemove($data);

        if ($imageRemove) {

            $notify[] = ['success', 'Product Image has been deleted'];
            return back()->withNotify($notify);

        } else {
            $notify[] = ['error', 'Product Image can not deleted. Please try again later.'];
            return back()->withNotify($notify);
        }
    }

    public function delete(Request $request)
    {
        $productId = $request->id;
        $product = $this->productService->deleteProduct($productId);

        if ($product) {

            $notify[] = ['success', 'Product and related images have been deleted successfully'];
            return back()->withNotify($notify);

        } else {
            $notify[] = ['error', 'Product can not deleted. Please try again later.'];
            return back()->withNotify($notify);
        }

    }

    public function pendingProduct()
    {
        $pageTitle = 'Pending Products';
        $products = Product::with(['category', 'productImages', 'user'])
            ->where('status', 0)
            ->orderBy('id', 'desc')
            ->paginate(getPaginate(20));

        return view('admin.products.index', compact('products', 'pageTitle'));

    }

    public function approveProduct()
    {
        $pageTitle = 'Approved Products';
        $products = Product::with(['category', 'productImages', 'user'])
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->paginate(getPaginate(20));

        return view('admin.products.index', compact('products', 'pageTitle'));

    }

    public function approveSingleProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->status = 1;
        $product->save();
        $notify[] = ['success', 'Product approved successfully.'];
        return back()->withNotify($notify);

    }
    public function rejectSingleProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->status = 0;
        $product->save();
        $notify[] = ['success', 'Product reject successfully.'];
        return back()->withNotify($notify);

    }


    public function productFileDownload($id) {
        $siteName = gs()->site_name;
        $product = Product::findOrFail($id);
      
        if (isset($product->file)) {
            $file = getFilePath('productFile') . '/' . $product->file;
            $fileName =$siteName.'_' . $product->file;
            return response()->download($file, $fileName);
        }else{
            $notify = ['error', 'This File Empty'];
            return back()->withNotify($notify);
        }

    }

}
