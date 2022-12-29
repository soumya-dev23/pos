<?php

namespace App\Models;

use App\Utils\AppUtils;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Stock extends Model{
    // use SoftDeletes;

    protected $fillable = [
        'product_code', 'batch_number', 'qty_avbl', 'sale_price', 'batch_date'
    ];

    protected $dates = ['created_at', 'updated_at'];
    // ===================== ORM Definition START ===================== //




}
