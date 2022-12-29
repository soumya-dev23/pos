<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductFormRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Stock;
use App\Models\Order;
use App\Models\OrderDetail;

class ProductController extends Controller {

    /**
     * @var Category
     */
    private $category;
    /**
     * @var Product
     */
    private $product;

    /**
     * ProductController constructor.
     * @param Category $category
     * @param Product $product
     */
    public function __construct(Category $category, Product $product) {
        $this->category = $category;
        $this->product = $product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $products = $this->product->getProducts(true);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $categories = $this->category->getCategories();
        //dd($categories);
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     *
     * @param ProductFormRequest $request
     * @return Response
     */
    public function store(ProductFormRequest $request) {
        $fields = $request->validated();
        $data = $this->product->storeProduct($fields);
        return redirect()->route('products.index')->with($data);
    }
    public function stock(Request $request) {
        $id = $request->segment(3);
        $data = $this->product->getProductById($id);
        //dd($data);
        $data['product_stocks'] =  DB::table('stocks')
        ->where('stocks.product_code', $data['product']['product_code'])               
        ->select('stocks.batch_number as batch_number', 'stocks.qty_avbl as qty_avbl', 'stocks.sale_price as sale_price','stocks.batch_date as batch_date')
        ->get();
        //dd($data);
        return view('products.store', $data);
    }

    public function stockSave(Request $request) {

        $product_code = $_POST['product_code'];
        $count = count($_POST['batch_number']);
        $batch_number = $_POST["batch_number"];	
        $qty_avbl = $_POST["qty_avbl"];	
        $sale_price = $_POST["sale_price"];	
        if($count > 0)
            {
            for($i=0; $i<$count; $i++)
                {
                   $batch_exist = Stock::where('batch_number', '=', $batch_number[$i])->count();
                   if($batch_exist == 0){
                            $data = ['product_code' => $product_code,
                            'batch_number' => $batch_number[$i], 
                            'qty_avbl' => $qty_avbl[$i], 
                            'sale_price' => $sale_price[$i], 
                            'batch_date' => date('Y-m-d') ]; 
                            Stock::create($data);
                   }
                }
            }
            return response()->json([ 'code' => 200, 'message' => 'Success']);
    }

    public function orderSave(Request $request) {

        $product_code = $_POST['product_code'];

        //product info from code
        $product_info =  DB::table('products')
        ->where('products.product_code', $product_code)               
        ->select('products.id as prod_id')
        ->first();
        //dd($product_info->prod_id);
        $order_quantity = $_POST["quantity"];

        $product_stocks =  DB::table('stocks')
        ->where('stocks.product_code', $product_code)  
        ->orderBy('stocks.created_at', 'ASC')             
        ->select('stocks.batch_number as batch_number', 'stocks.qty_avbl as qty_avbl', 'stocks.sale_price as sale_price','stocks.batch_date as batch_date','stocks.created_at as created_at')
        ->get();
     //  Insert Basic Detail in Order Table later will update the price 
                $data = ['customer_id' => 1,
                'created_by' => Auth()->id(), 
                'order_no' => '#'.rand(1,25), 
                'total_items' => $order_quantity]; 
               $last_insert =  Order::create($data);

        
        foreach($product_stocks as $pstock){
            //echo $pstock->qty_avbl;
            if( $pstock->qty_avbl == 0){
                continue;
            }
            elseif($order_quantity > $pstock->qty_avbl){

                //Insert Into Order Details table
                $data = ['order_id' => $last_insert->id,
                'product_id' => $product_info->prod_id, 
                'batch_no' => $pstock->batch_number, 
                'quantity' => $pstock->qty_avbl]; 
               $last_insert_row =  OrderDetail::create($data);
                dd($last_insert_row);

            }

        }


        dd($product_stocks);
      
        return response()->json([ 'code' => 200, 'message' => 'Success']);
    }

    /**
     * Display the specified product.
     *
     * @param string $slug
     * @return Response
     */
    public function show($slug) {
        $data = $this->product->getProductBySlug($slug, true);
        //dd("here");
        $data['product_stocks'] =  DB::table('stocks')
        ->where('stocks.product_code', $data['product']['product_code'])               
        ->select('stocks.batch_number as batch_number', 'stocks.qty_avbl as qty_avbl', 'stocks.sale_price as sale_price','stocks.batch_date as batch_date')
        ->get();
        return view('products.show', $data);
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id) {
        $data = $this->product->getProductById($id);
        $data['categories'] = $this->category->getCategories();
        return view('products.edit', $data);
    }

    /**
     * Update the specified product in storage.
     *
     * @param ProductFormRequest $request
     * @param int $id
     * @return Response
     */
    public function update(ProductFormRequest $request, $id) {
        $fields = $request->validated();
        $data = $this->product->updateProduct($fields, $id);
        return redirect()->route('products.index')->with($data);
    }

    /**
     * Remove the specified product from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id) {
        $data = $this->product->destroyProduct($id);
        return json_encode($data);
    }

    public function deleteOrRestore($id){
        $data = $this->product->deleteOrRestore($id);

        return json_encode($data);
    }
    
}
