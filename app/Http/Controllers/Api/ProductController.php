<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{

    public function index()
    {
        return;
    }
    public function deleteExtraImage(Request $request)
    {
        $url = Str::of($request->input('product_image_url'))->replace(config('filesystems.disks.s3.url'), '');
        $productImage = ProductImage::where('image_url', $url)->firstOrFail();
        Storage::disk('s3')->delete($productImage->image_url);
        $productImage->delete();
        return response($request->input('product_image_url'), 200);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDescription(Request $request, Product $product)
    {
        return view('store.product_description_modal')->with(compact('product'));
    }
}