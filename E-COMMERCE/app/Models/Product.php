<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['section_id', 'name', 'description', 'price', 'stock', 'image'];

    public function scopeFilter($query, $search)
    {
        $query->where('name', 'like', '%' . $search . '%')
               ->orWhere('description', 'like', '%' . $search . '%');  
    }

    // Relationships
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
