<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaveForLater extends Model
{
    use HasFactory;
    protected $table = 'save_for_later';

    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
