<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;

class ProductService
{
    public function index($user = null)
    {

        if ($user) {
            return Product::where('user_id', $user->id)
                ->with(['category', 'productImages'])
                ->where('status', 1)
                ->orderBy('id', 'desc')
                ->paginate(getPaginate(20));
        } else {
            return Product::with(['category', 'productImages', 'user'])
                ->orderBy('id', 'desc')
                ->paginate(getPaginate(20));
        }

    }
    
    public function create()
    {
        return Category::where('status', 1)->get();
    }

    public function storeProduct($data, $user = null)
    {
        $isRestricted = gs()->is_restricted;

        $purifier = new \HTMLPurifier();
        $product = new Product();
        $product->category_id = $data->category_id;
        $product->user_id = $user ? $user->id : 0;
        $product->name = $data->name;
        $product->price = $data->price;
        $product->discount = $data->discount;
        $product->demo_link = $data->demo_link;
        $product->external_link = $data->external_link;
        $product->description = $purifier->purify($data->description);

        if ($isRestricted == 1 && $user) {
            $product->status = 0;
        } else {
            $product->status = 1;
        }
        $product->is_free = $data->is_free ? 1 : 0;

        if ($data->hasFile('file')) {
            if ($data->file('file')->isValid()) {
                try {
                    $filePath = fileUploader($data->file('file'), getFilePath('productFile'));
                    $product->file = $filePath;
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Couldn\'t upload your file'];
                    return back()->withNotify($notify);
                }
            }
        }

        if ($data->hasFile('thumbnail')) {
            if ($data->file('thumbnail')->isValid()) {
                try {
                    $filePath = fileUploader($data->file('thumbnail'), getFilePath('productThumbnail'), getFileSize('productThumbnail'));
                    $product->thumbnail = $filePath;
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Couldn\'t upload your file'];
                    return back()->withNotify($notify);
                }
            }
        }

        if ($product->save()) {
            if ($data->hasFile('images')) {
                foreach ($data->file('images') as $image) {
                    if ($image->isValid()) {
                        try {
                            $imagePath = fileUploader($image, getFilePath('productImage'), getFileSize('productImage'));
                            $productImage = new ProductImage();
                            $productImage->product_id = $product->id;
                            $productImage->image = $imagePath;
                            $productImage->save();
                        } catch (\Exception $exp) {
                            $notify[] = ['error', 'Couldn\'t upload your image'];
                            return back()->withNotify($notify);
                        }
                    }
                }
            }

            return $product;
        } else {
            return null;
        }
    }

    public function edit($id)
    {
        return Product::with(['category', 'productImages'])->findOrFail($id);
    }

    public function deleteProduct($productId)
    {

        $product = Product::with('productImages','orders','deposits','reviews')->findOrFail($productId);

        if ($product->productImages) {
            foreach ($product->productImages as $productImage) {

                $path = getFilePath('productImage') . '/' . $productImage->image;
                fileManager()->removeFile($path);
                $productFilePath = getFilePath('productFile') . '/' . $product->file;
                fileManager()->removeFile($productFilePath);
                $productImage->delete();
            }
        }

        $thumbPath = getFilePath('productThumbnail') . '/' . $product->thumbnail;
        fileManager()->removeFile($thumbPath);

        if($product->orders){
            foreach($product->orders as $order){
                $order->delete();
            }
        }

        if($product->deposits){
            foreach($product->deposits as $deposit){
                $deposit->delete();
            }
        }

        if($product->reviews){
            foreach($product->reviews as $review){
                $review->delete();
            }
        }


        if ($product->delete()) {
            return $product;
        } else {
            return null;
        }

    }

    public function updateProduct($data, $user = null)
    {
        $purifier = new \HTMLPurifier();
        $product = Product::findOrFail($data->id);
        $product->category_id = $data->category_id;
        $product->name = $data->name;
        $product->price = $data->price;
        $product->discount = $data->discount;
        $product->demo_link = $data->demo_link;
        $product->external_link = $data->external_link;
        $product->description = $purifier->purify($data->description);
        if ($user) {

        } else {
            $product->status = $data->status ? 1 : 0;
        }

        $product->is_free = $data->is_free ? 1 : 0;

        if ($data->hasFile('images')) {

            if ($product->save()) {
                foreach ($data->file('images') as $image) {
                    if ($image->isValid()) {
                        try {
                            $imagePath = fileUploader($image, getFilePath('productImage'), getFileSize('productImage'));
                            $productImage = new ProductImage();
                            $productImage->product_id = $product->id;
                            $productImage->image = $imagePath;
                            $productImage->save();
                        } catch (\Exception $exp) {
                            $notify[] = ['error', 'Couldn\'t upload your image'];
                            return back()->withNotify($notify);
                        }
                    }
                }
            }
        }

        if ($data->hasFile('file')) {
            if ($data->file('file')->isValid()) {
                try {
                    $oldPath = getFilePath('productFile') . '/' . $product->file;
                    fileManager()->removeFile($oldPath);
                    $filePath = fileUploader($data->file('file'), getFilePath('productFile'));
                    $product->file = $filePath;
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Couldn\'t upload your file'];
                    return back()->withNotify($notify);
                }
            }
        }

        if ($data->hasFile('thumbnail')) {
            if ($data->file('thumbnail')->isValid()) {
                try {
                    $oldPath = getFilePath('productThumbnail') . '/' . $product->thumbnail;
                    fileManager()->removeFile($oldPath);
                    $filePath = fileUploader($data->file('thumbnail'), getFilePath('productThumbnail'), getFileSize('productThumbnail'));
                    $product->thumbnail = $filePath;
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Couldn\'t upload your file'];
                    return back()->withNotify($notify);
                }
            }
        }

        if ($product->save()) {
            return $product;
        } else {
            return null;
        }
    }

    public function imageRemove($data)
    {

        $image = ProductImage::findOrFail($data->id);
        $path = getFilePath('productImage') . '/' . $image->image;
        fileManager()->removeFile($path);

        if ($image->delete()) {
            return $image;
        } else {
            return null;
        }
    }

}
