<?php
/**
 * @author <a href="mailto:bagus.seno39@gmail.com>seno</a>
 * Created on 25/02/21
 * Project evermos-service
 */

namespace App\Transformers;

use App\Models\Product;
use League\Fractal\TransformerAbstract;

/**
 * Class ProductTransformer
 * @package App\Transformers
 */
class ProductTransformer extends TransformerAbstract
{
    /**
     * @param Product $product
     * @return array
     */
    public function transform(Product $product): array
    {
        return [
            'id' => (int)$product['id'],
            'code' => (string)$product['code'],
            'name' => (string)$product['name'],
            'price' => $product['price'],
            'category_product_id' => (string)"[{'Master Category Product'}]",
            'expired_date' => $product['expired_date'],
            'bpom_number' => $product['bpom_number'],
            'supplier_id' => (string)"[{'Master SUpplier'}]",
            'price_event' => $product['price_event'],
            'event_id' => (string)"[{'Master Category Product'}]"
        ];

    }

}