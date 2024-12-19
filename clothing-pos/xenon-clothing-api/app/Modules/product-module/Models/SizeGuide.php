<?php

namespace App\Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;

class SizeGuide extends Model
{
    protected $table = 'size_guides';
    protected $fillable = ['category', 'size', 'value'];
}