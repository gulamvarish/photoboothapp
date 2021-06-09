<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Auth\ResetPasswordRequest;
use App\Repositories\Frontend\Auth\UserRepository;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Exceptions\GeneralException;
use App\Models\EventImage;
use App\Models\PhotoEvent;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Session;
/**
 * Class CollageController.
 */
class CollageController extends Controller
{
    

    public function collage_index()
    {  
    	 
            


    	    $user_id       = Auth::id();
           
         
    	
          $PhotoEvents = PhotoEvent::with('event_images') 
                        ->where('event_collage', $user_id)                                               
                        ->get();


       

       /* $PhotoEvent    = PhotoEvent::rightJoin('event_images','event_images.event_id','=','photo_events.id')
								          ->select('photo_events.event_title','event_images.id as imageid', 'event_images.image')
								          ->where('event_images.type', 'collage')								          
								         ->get();*/
	       if(session()->get('usertype') == 3){

	           return view('frontend.collage.index', compact('PhotoEvents'));
	        }else{

	        	auth()->logout();

	        	throw new GeneralException(__('Please Try Again'));
	        }
    }


    public function eventowner()
    {  


    	    $user_id       = Auth::id(); 
          $PhotoEvents   = PhotoEvent::with('event_owner') 
                        ->where('event_host', $user_id)                                               
                        ->get();

                       // echo '<pre>'; print_r($PhotoEvents); echo '</pre>';
     
       /* $PhotoEvent    = PhotoEvent::rightJoin('event_images','event_images.event_id','=','photo_events.id')
								          ->select('photo_events.event_title','event_images.id as imageid', 'event_images.image')
								          ->where('event_images.type', 'collage')								          
								         ->get();*/

		if(session()->get('usertype') == 2){

	          return view('frontend.eventowner.index', compact('PhotoEvents'));
	        }else{

	        	auth()->logout();

	        	throw new GeneralException(__('Please Try Again'));
	        }
      		

        
    }
}
