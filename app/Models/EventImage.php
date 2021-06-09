<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventImage extends Model
{
    protected $fillable = ['event_id', 'layout_id', 'type', 'image', 'thumbnail', '	created_by', 'updated_by',	'deleted_at'];
}

        
     