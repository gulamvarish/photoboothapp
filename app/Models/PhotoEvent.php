<?php

namespace App\Models;

use App\Models\Traits\Attributes\PhotoEventAttributes;
use App\Models\Traits\ModelAttributes;
use App\Models\Traits\Relationships\PhotoEventRelationships;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhotoEvent extends BaseModel
{
    use SoftDeletes, ModelAttributes, PhotoEventRelationships, PhotoEventAttributes;

    /**
     * The guarded field which are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Fillable.
     *
     * @var array
     */
    protected $fillable = [
        'event_title',
        'event_backendbg_image',
        'event_forntbg_image',
        'event_sound',
        'event_feature_image',
        'event_qrcode',        
        'status'
        
    ];

    /**
     * Casts.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
    ];

    public function get_layout_details(){

            return $this->hasMany('App\Models\EventNolayoutBgimage', 'event_id', 'id')->with('get_layout_image');
            //return $this->hasManyThrough('App\Models\EventNolayoutBgimage', 'App\Models\EventNolayoutBgimage');
    }

    // public function get_layout_image(){

    //         return $this->hasMany('App\Models\LayoutsPage', 'id', 'layout_id');
    // }

    public function event_images() {
       return $this->hasMany('App\Models\EventImage', 'event_id')->where('type', 'collage');
    }


    public function event_owner() {
       return $this->hasMany('App\Models\EventImage', 'event_id')->where('type', 'image');
    }


}
