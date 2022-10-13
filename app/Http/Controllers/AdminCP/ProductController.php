<?php

namespace App\Http\Controllers\AdminCP;

use App\Helpers\InvisionAPI;
use App\Models\AdminCP\AdvertisementSite;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $forumInstance;

    public function __construct()
    {
        $this->forumInstance = InvisionAPI::getInstance();
    }

    /**
     * Displays our admincp page
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $products = Product::query();
        if ($request->isMethod('post')) {
            $products = $products->where('item_name', 'like', '%' . $request->input('search') . '%');
        }
        return view('admincp.products.index',
            [
                'products' => $products->paginate(10)
            ]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $thumbnailImage = $request->file('thumbnailImage');
            $product = new Product();
            $product->item_name = $request->input('item_name');
            $category = Category::where('title', $request->input('category'))->firstOrFail()->id;
            $product->category_id = $category;
            $product->item_id = $request->input('item_id');
            $product->item_amount = $request->input('item_amount');
            $product->item_discount = $request->input('item_discount') ?? 0;
            $product->item_price = $request->input('item_price');
            $product->ironman = $request->input('ironman') ?? 0;
            $product->description = $request->input('item_description');
            $product->visible = 1;
            $product->bond_amount = $request->input('bond_amount');
            $product->save();

            $thumbnailURL = Storage::disk('s3')->put(config('store.product_images_bucket') . '/' . $product->id, $thumbnailImage);
            $thumbnail = new ProductImage();
            $thumbnail->product_id = $product->id;
            $thumbnail->image_url = $thumbnailURL;
            $thumbnail->is_thumbnail = 1;
            $thumbnail->save();

            foreach ($request->file('desc_images') as $file) {
                $extraImageURL = Storage::disk('s3')->put(config('store.product_images_bucket') . '/' . $product->id, $file);
                $extraImage = new ProductImage();
                $extraImage->product_id = $product->id;
                $extraImage->image_url = $extraImageURL;
                $extraImage->is_thumbnail = 0;
                $extraImage->save();
            }

            return redirect(route('admincp.products'));
        }
        return view('admincp.products.create', [
            'categories' => Category::all()
        ]);
    }


    public function edit(Request $request, Product $product)
    {
        if ($request->isMethod('post')) {
            $thumbnailImage = $request->file('thumbnailImage');
            $product->item_name = $request->input('item_name');
            $category = Category::where('title', $request->input('category'))->firstOrFail()->id;
            $product->category_id = $category;
            $product->item_id = $request->input('item_id');
            $product->item_amount = $request->input('item_amount');
            $product->item_discount = $request->input('item_discount');
            $product->item_price = $request->input('item_price');
            $product->ironman = $request->input('ironman');
            $product->description = $request->input('item_description');
            $product->visible = 1;
            $product->bond_amount = $request->input('bond_amount');
            $product->save();
            if ($thumbnailImage !== null) {
                Storage::disk('s3')->delete($product->getThumbnailImage());
                $thumbnailURL = Storage::disk('s3')->put(config('store.product_images_bucket') . '/' . $product->id, $thumbnailImage);
                $thumbnail = ProductImage::where('product_id', $product->id)->firstOrFail();
                $thumbnail->image_url = $thumbnailURL;
                $thumbnail->save();
            }
            foreach ($request->file('desc_images') as $file) {
                $extraImageURL = Storage::disk('s3')->put(config('store.product_images_bucket') . '/' . $product->id, $file);
                $extraImage = new ProductImage();
                $extraImage->product_id = $product->id;
                $extraImage->image_url = $extraImageURL;
                $extraImage->is_thumbnail = 0;
                $extraImage->save();
            }
            return redirect(route('admincp.products'));
        }
        return view('admincp.products.edit',
            [
                'product' => $product,
                'categories' => Category::all()
            ]);
    }

    public function delete(Product $product)
    {
        Storage::disk('s3')->deleteDirectory(config('store.product_images_bucket') . '/' . $product->id);
        $product->delete();
        return redirect(route('admincp.products'));
    }

    public function setVisibility(Product $product)
    {
        ($product->visible) ? $product->visible = 0 : $product->visible = 1;
        $product->save();
        return redirect(route('admincp.products'));
    }

    public function setFeatured(Product $product)
    {
        ($product->is_featured) ? $product->is_featured = 0 : $product->is_featured = 1;
        $product->save();
        return redirect(route('admincp.products'));
    }

}