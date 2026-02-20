<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'price'
    ];

    public function quotes()
    {
        return $this->belongsToMany(Quote::class, 'quote_product');
    }

    public function invoiceItems()
    {
        return $this->morphMany(InvoiceItem::class, 'itemable');
    }
}
