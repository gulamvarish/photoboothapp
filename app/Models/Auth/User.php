<?php

namespace App\Models\Auth;

use App\Models\Auth\Traits\Access\UserAccess;
use App\Models\Auth\Traits\Attributes\UserAttributes;
use App\Models\Auth\Traits\Methods\UserMethods;
use App\Models\Auth\Traits\Relationships\UserRelationships;
use App\Models\Auth\Traits\Scopes\UserScopes;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * Class User.
 */
class User extends BaseUser
{
    use HasApiTokens, Notifiable, SoftDeletes, UserAttributes, UserScopes, UserAccess, UserRelationships, UserMethods;

   

    protected $fillable = [
        'uuid',
        'last_name',
        'email',
        'avatar_type',
        'avatar_location',
        'password',
        'password_changed_at',
        'active',
        'confirmation_code',
        'confirmed',        
        'timezone',
        'last_login_at',
        'last_login_ip',
        'to_be_logged_out',        
        'created_by',
        'updated_by',
        'is_term_accept',
        'remember_token',        
        'api_token',
        'device_id',
        'created_at',
        'updated_at',        
        'deleted_at',
        'status',        
        'facebook_id'
        
    ];

         function photo_event_collage() {
           $this->hasMany('App\Models\PhotoEvent', 'event_collage');
        }

        function photo_event_host() {
            $this->hasMany('App\Models\PhotoEvent', 'event_host');
        }




            
}
