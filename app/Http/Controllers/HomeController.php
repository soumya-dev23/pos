<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller{
    private $user;

    /**
     * HomeController constructor.
     * @param User $user
     */
       /**
     * @var Category
     */
    private $category;
    /**
     * @var Product
     */
    private $product;
    public function __construct(User $user, Category $category, Product $product){
        $this->user = $user;
        $this->category = $category;
        $this->product = $product;
    }

    public function index(){

//        $permission = Permission::create([
//            'name' => 'create category'
//        ]);
//
//        auth()->user()->givePermissionTo($permission);
        $products = $this->product->getProducts(true);
       
        return view('dashboard', compact('products'));
    }
}
