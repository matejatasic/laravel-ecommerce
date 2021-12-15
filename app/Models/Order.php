<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'email', 
        'name', 
        'address', 
        'city', 
        'province', 
        'postalcode', 
        'phone', 
        'name_on_card', 
        'subtotal', 
        'tax', 
        'total', 
        'payment_gateway', 
        'error'
    ];

    public function user() {
        $this->belongsTo(User::class);
    }

    public function products() {
        $this->belongsToMany(Product::class)->withPivot('quantity');
    }
}
