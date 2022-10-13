<?php

namespace App\Http\Controllers\AdminCP;

use App\Helpers\InvisionAPI;
use App\Models\AdminCP\AdvertisementSite;
use App\Models\Category;
use App\Models\CreditPackage;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class CreditPackageController extends Controller
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
        return view('admincp.creditpackages.index',
            [
                'creditpackages' => CreditPackage::all()
            ]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $creditPackage = new CreditPackage();
            $creditPackage->amount = $request->input('amount');
            $creditPackage->bonus = $request->input('bonus');
            $creditPackage->holiday_bonus = $request->input('holiday_bonus');
            $creditPackage->discount = $request->input('discount');
            $creditPackage->price = $request->input('price');
            $creditPackage->image_url = ' ';
            $creditPackage->save();
            $image = Storage::disk('s3')->put(config('store.credit_images_bucket') . '/' . $creditPackage->id, $request->file('credit-image'));
            $creditPackage->image_url = $image;
            $creditPackage->save();
            return redirect(route('admincp.creditpackages'));
        }
        return view('admincp.creditpackages.create');
    }

    public function edit(Request $request, CreditPackage $creditpackage)
    {
        if ($request->isMethod('post')) {
            $creditpackage->amount = $request->input('amount');
            $creditpackage->bonus = $request->input('bonus') ?? 0;
            $creditpackage->holiday_bonus = $request->input('holiday_bonus') ?? 0;
            $creditpackage->discount = $request->input('discount') ?? 0;
            $creditpackage->price = $request->input('price');
            $creditpackage->save();
            if($request->file('credit-image')) {
            Storage::disk('s3')->delete($creditpackage->getImageUrl());
            $image = Storage::disk('s3')->put(config('store.credit_images_bucket') . '/' . $creditpackage->id, $request->file('credit-image'));
            $creditpackage->image_url = $image;
            $creditpackage->save();
            }

            return redirect(route('admincp.creditpackages'));
        }
        return view('admincp.creditpackages.edit',
            [
                'creditpackage' => $creditpackage
            ]);
    }

    public function delete(CreditPackage $creditpackage)
    {
        Storage::disk('s3')->delete($creditpackage->getImageUrl());
        $creditpackage->delete();
        return redirect(route('admincp.creditpackages'));
    }

}