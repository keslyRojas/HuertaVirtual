<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    protected $fillable = [
        'inventory_item_category_id',
        'name',
        'price',
    ];

    public function category()
    {
        return $this->belongsTo(InventoryItemCategory::class, 'inventory_item_category_id');
    }
    
    public function userInventories()
{
    return $this->hasMany(UserInventory::class);
}
}
