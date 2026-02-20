<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'total'
    ];

    public function client()
    {
        return $this->belongsTo(Clients::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'quote_product')->withPivot('quantity', 'discount');
    }

    // public function productsWithQty()
    // {
    //     return $this->belongsToMany(Product::class, 'quote_product')->withPivot('quantity');
    // }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'quote_service')->withPivot('quantity');
    }

    // public function servicesWithQty()
    // {
    //     return $this->belongsToMany(Service::class, 'quote_service')->withPivot('quantity');
    // }

    public function items()
    {
        return $this->hasMany(QuoteItem::class, 'quote_id');
    }
}
