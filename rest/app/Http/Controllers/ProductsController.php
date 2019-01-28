<?php namespace App\Http\Controllers;

use League\Fractal;
use App\Models\Product;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use App\Transformers\ProductTransformer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class ProductsController extends Controller
{
    private $fractal;

    public function __construct()
    {
        $this->fractal = new Manager();
    }
    /**
         * GET /products
         *
         * @return array
         */
    public function index()
    {
        $paginator = Product::paginate();
        $products = $paginator->getCollection();
        $resource = new Collection($products, new ProductTransformer);
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));
        return $this->fractal->createData($resource)->toArray();
    }
}
