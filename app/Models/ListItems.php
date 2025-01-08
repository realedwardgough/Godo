<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Lists;

class ListItems extends Model
{
    
    // Renaming of ListItems table
    protected $table = 'list_item';


    /**
     * Connection of a list item to a list
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function list() {
        return $this->belongsTo(Lists::class);
    }

}
