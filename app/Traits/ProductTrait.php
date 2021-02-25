<?php
/**
 * @author <a href="mailto:bagus.seno39@gmail.com>seno</a>
 * Created on 25/02/21
 * Project evermos-service
 */

namespace App\Traits;

use App\Models\EmploymentTypeChild;
use App\Models\Product;
use App\Utilities\Constants\Globals;
use App\Utilities\StringHelper;
use Carbon\Carbon;
use Jojonomic\JojoUtilities\Constants\JojoConstant;

/**
 * Trait ProductTrait
 * @package App\Traits
 */
trait ProductTrait
{
    /**
     * @param $id
     * @return mixed
     */
    public function findByIdProduct($id)
    {
        return Product::where('id', $id)->where('is_deleted', Globals::NO_DELETED)->lockForUpdate()->first(); //Implementation row locking
    }

    /**
     * @param $request
     * @return array
     */
    public function listProduct($request): array
    {
        $results['length'] = 0;
        $results['data'] = array();

        $page = (int)$request->pagination['page'];
        $limit = (int)$request->pagination['limit'];
        $column = (string)isset($request->pagination['column']) ? (string)$request->pagination['column'] : "";
        $ascending = (bool)isset($request->pagination['ascending']) ? (string)$request->pagination['ascending'] : false;
        $query = (string)isset($request->pagination['query']) ? (string)$request->pagination['query'] : "";

        $count = Product::where('is_deleted', Globals::NO_DELETED);

        $product = Product::where('is_deleted', Globals::NO_DELETED);

        //minimum length = 2 for search key
        if (!empty($query) && strlen($query) > 0) {
            $query = StringHelper::convertToUtf8($query);

            $count = $count->where(function ($q) use ($query) {
                $q->orWhere('name', 'like', '%' . $query . '%')->orWhere('code', 'like', '%' . $query . '%');
            });

            $product = $product->where(function ($q) use ($query) {
                $q->orWhere('name', 'like', '%' . $query . '%')->orWhere('code', 'like', '%' . $query . '%');
            });
        }

        $count = $count->count();

        if (!empty($column)) {
            if ($ascending) {
                $groupBy = 'ASC';
            } else {
                $groupBy = 'DESC';
            }
            $product = $product->orderBy($column, $groupBy);
        }

        if ($limit > 0 && $page > 0) {
            $offset = ($page - 1) * $limit;
            $product = $product->offset($offset)->limit($limit);
        }

        $results['length'] = $count;
        $results['data'] = $product->lockForUpdate()->get();
        return $results;
    }

    /**
     * @param $params
     * @return Product
     */
    public function createProduct($params): Product
    {
        $product = new Product();
        $product->name = StringHelper::checkIsset($params['name']);
        $product->code = "P" . str_pad(rand(1, 99999), 6, '0', STR_PAD_LEFT);
        $product->category_product_id = 1;
        $product->price = StringHelper::checkIsset($params['price']);
        $product->expired_date = StringHelper::checkIsset($params['expired_date']);
        $product->bpom_number = StringHelper::checkIsset($params['bpom_number']);
        $product->supplier_id = 1;
        $product->packaging_id = 1;
        $product->price_event = StringHelper::checkIsset($params['price_event']);
        $product->stock = StringHelper::checkIsset($params['stock']);
        $product->event_id = StringHelper::checkIsset($params['event_id']);
        $product->created_by = null; // Di isi dari token
        $product->created_at = Carbon::now('Asia/Jakarta');
        $product->is_deleted = Globals::NO_DELETED;
        $product->save();
        return $product;
    }

    /**
     * @param $product
     * @param $params
     * @return mixed
     */
    public function updateProduct($product, $params)
    {
        $product->name = StringHelper::checkIsset($params['name']);
        $product->code = "P" . str_pad(rand(1, 99999), 6, '0', STR_PAD_LEFT);
        $product->category_product_id = 1;
        $product->price = StringHelper::checkIsset($params['price']);
        $product->expired_date = StringHelper::checkIsset($params['expired_date']);
        $product->bpom_number = StringHelper::checkIsset($params['bpom_number']);
        $product->supplier_id = 1;
        $product->packaging_id = 1;
        $product->price_event = StringHelper::checkIsset($params['price_event']);
        $product->stock = StringHelper::checkIsset($params['stock']);
        $product->event_id = StringHelper::checkIsset($params['event_id']);
        $product->created_by = null; // Di isi dari token
        $product->created_at = Carbon::now('Asia/Jakarta');
        $product->is_deleted = Globals::NO_DELETED;
        $product->save();
        return $product;
    }

    /**
     * @param $product
     * @return mixed
     */
    public function deleteProduct($product)
    {
        $product->is_deleted = Globals::DELETED;
        $product->save();
        return $product;
    }

}