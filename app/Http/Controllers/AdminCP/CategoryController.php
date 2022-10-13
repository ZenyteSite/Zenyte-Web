<?php

namespace App\Http\Controllers\AdminCP;

use App\Helpers\InvisionAPI;
use App\Models\AdminCP\AdvertisementSite;
use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CategoryController extends Controller
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
        return view('admincp.categories.index',
            [
                'categories' => Category::all()
            ]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $category = new Category();
            $category->title = $request->input('title');
            $category->save();

            return redirect(route('admincp.categories'));
        }
        return view('admincp.categories.create');
    }


    public function edit(Request $request, Category $category)
    {
        if ($request->isMethod('post')) {
            $category->title = $request->input('title');
            $category->save();

            return redirect(route('admincp.categories'));
        }
        return view('admincp.categories.edit',
            [
                'category' => $category
            ]);
    }

    public function delete(Category $category)
    {
        $category->delete();
        return redirect(route('admincp.categories'));
    }

}