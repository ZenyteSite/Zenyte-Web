<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Utility;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class StoreController extends Controller
{

    public function categories(Request $request)
    {
        if($request->input('catId') == -1) {
            $category = null;
        } else {
            $category = Category::where('id', $request->input('catId'))->firstOrFail();
        }
        $pageNumber = $request->input('page');

        if($category) {
            $products = Product::where('visible', 1)->where('category_id', $category->id);
        } else {
            $products = Product::where('visible', 1);
        }
        $search = $request->input('search');
        if($search) {
            $escapedSearch = Utility::escape_like($search);
            $products = $products->where('item_name', 'LIKE', '%' . $escapedSearch . '%');
        }
        $products = $products->get();
        $products->map(function($product) {
            $thumbnail = ProductImage::where('is_thumbnail', 1)->where('product_id', $product->id)->first();
            $otherImages = ProductImage::where('product_id', $product->id)->where('is_thumbnail', 0)->pluck('image_url');
            if($thumbnail) {
                $product->thumbnail_image = config('filesystems.disks.s3.url') . $thumbnail->image_url;
            } else {
                $product->thumbnail_image = config('filesystems.disks.s3.url') . config('store.no_image_found_url');
            }
            $product->extraImageUrls = [];
            if($otherImages->count()) {
                    $product->extraImageUrls = json_encode($otherImages);
            }
            return $product;
        });

        $productCount = $products->count();

        return response([
            'products' => $products->forPage($pageNumber ?? 1, 15),
            'currentPage' => $pageNumber,
            'totalPages' => ceil($productCount / 15),
            'count' => $productCount,
            ], 200);
    }

}