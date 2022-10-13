<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CreditPackage extends Model
{
  public $timestamps = false;

  public function getImageUrl()
  {
      return Storage::disk('s3')->url( $this->image_url);
  }

    /**
     * @return float|int|mixed
     */
    public function getDiscountedPrice()
    {
        $price = $this->price;
        if ($this->discount > 0) { //If discount is 0 we don't care anyway
            $price = $this->price - ($this->price * $this->discount / 100);
        }
        return (float)$price;
    }

    /**
     * @param string $paymentMethod
     * @return mixed
     */
    public function getFullCreditsAmount(string $paymentMethod)
    {
        $amount = $this->amount + $this->bonus + $this->holiday_bonus;
        $saleExtra = 0;
        if(config('store.sale.' . $paymentMethod . '.enabled')) {
            $saleExtra = config('store.sale.' . $paymentMethod . '.amount');
            $amount = $amount + ($amount * $saleExtra / 100);
        }

        return round($amount);
    }
}
