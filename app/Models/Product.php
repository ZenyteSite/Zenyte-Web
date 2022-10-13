<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Validator;

class Product extends Model
{
    public function getThumbnailImage($id = null)
    {
        $id = $id ?? $this->id;
        $image = ProductImage::where('product_id', $id)->where('is_thumbnail', 1)->first();
        $url = $image->image_url;
        if ($image === null) {
            $url = config('store.no_image_found_url');
        }
        return Storage::disk('s3')->url($url);
    }

    public function getImages($thumbnailIncluded = false)
    {
        $urls = [];
        $images = ProductImage::where('product_id', $this->id)->where('is_thumbnail', 0)->get();
        if ($thumbnailIncluded) {
            $images = ProductImage::where('product_id', $this->id)->where('is_thumbnail', 1)->get();
        }
        foreach ($images as $image) {
            $urls[] = Storage::disk('s3')->url($image->image_url);
        }
        return $urls;
    }

    /*
   * Our validation rules when submitting our create and edit forms for Content
   */

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function getDiscountedPrice()
    {
        $price = $this->item_price;
        if ($this->item_discount > 0) { //If discount is 0 we don't care anyway
            $price = $this->item_price - ($this->item_price * $this->item_discount / 100);
        }
        return $price;
    }
}
