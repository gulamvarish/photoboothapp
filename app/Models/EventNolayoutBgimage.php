<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/*use App\Models\Traits\Attributes\PhotoEventAttributes;
use App\Models\Traits\ModelAttributes;
use App\Models\Traits\Relationships\PhotoEventRelationships;
use Illuminate\Database\Eloquent\SoftDeletes;*/

class EventNolayoutBgimage extends Model
{
    
	protected $fillable = ['event_id', 'layout_id', 'layout_bg_image', 'created_at', 'updated_at',	'deleted_at'];

    public function get_layout_image(){

            return $this->hasMany('App\Models\LayoutsPage', 'id', 'layout_id');
    }
}
