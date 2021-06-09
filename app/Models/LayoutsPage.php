<?php

namespace App\Models;

use App\Models\Traits\Attributes\LayoutsPageAttributes;
use App\Models\Traits\ModelAttributes;
use App\Models\Traits\Relationships\LayoutsPageRelationships;
use Illuminate\Database\Eloquent\SoftDeletes;


class LayoutsPage extends BaseModel
{
    use ModelAttributes, SoftDeletes, LayoutsPageAttributes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    use SoftDeletes, ModelAttributes, LayoutsPageRelationships, LayoutsPageAttributes;

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
        'layout_title',        
        'layout_image',       
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
}
