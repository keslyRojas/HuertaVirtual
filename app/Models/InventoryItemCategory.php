<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryItemCategory extends Model
{
    protected $fillable = ['name'];

    public function items()
    {
        return $this->hasMany(InventoryItem::class, 'inventory_item_category_id');
    }
}
