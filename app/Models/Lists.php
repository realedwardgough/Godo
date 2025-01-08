<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ListItems;

class Lists extends Model
{
    
    /**
     * Connection of a list to a user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Connection of a list to all its list items
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function listItems() {
        return $this->hasMany(ListItems::class, 'list_id', 'id');
    }


}
