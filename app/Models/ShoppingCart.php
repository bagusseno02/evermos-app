<?php
/**
 * @author <a href="mailto:bagus.seno39@gmail.com>seno</a>
 * Created on 25/02/21
 * Project evermos-service
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ShoppingCart
 * @package App\Models
 */
class ShoppingCart extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'shopping_cart';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    ];
}