<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    protected $fillable = [
        'inventory_item_category_id',
        'name',
        'price',
        'plant_id',
    ];

    public function category()
    {
        return $this->belongsTo(InventoryItemCategory::class, 'inventory_item_category_id');
    }
    
    public function userInventories()
{
    return $this->hasMany(UserInventory::class);
}
public function plant()
    {
        return $this->belongsTo(Plant::class);
    }
}
