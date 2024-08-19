<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description','image'];

    public function scopeFilter($query, $search)
    {
        $query->where('name', 'like', '%' . $search . '%');
           
    }

    // Relationships
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
