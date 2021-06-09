<?php

namespace App\Http\Controllers\Backend\PhotoEvents;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\PhotoEvents\CreatePhotoEventRequest;
use App\Http\Requests\Backend\PhotoEvents\DeletePhotoEventRequest;
use App\Http\Requests\Backend\PhotoEvents\EditPhotoEventRequest;
use App\Http\Requests\Backend\PhotoEvents\ManagePhotoEventRequest;
use App\Http\Requests\Backend\PhotoEvents\StorePhotoEventRequest;
use App\Http\Requests\Backend\PhotoEvents\UpdatePhotoEventRequest;
use App\Http\Responses\Backend\PhotoEvent\EditResponse;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Models\PhotoEvent;
use App\Models\EventNolayoutBgimage;
use App\Repositories\Backend\PhotoEventsRepository;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Exceptions\GeneralException;
use Auth;


class PhotoEventsController extends Controller
{
    /**
     * @var \App\Repositories\Backend\PhotoEventsRepository
     */
    protected $repository;

    /**
     * @param \App\Repositories\Backend\PhotoEventsRepository $repository
     */
    public function __construct(PhotoEventsRepository $repository)
    {
        $this->repository = $repository;
        View::share('js', ['photo-events']);
    }

    /**
     * @param \App\Http\Requests\Backend\PhotoEvents\PhotoEventsRepository $request
     *
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(PhotoEventsRepository $request)
    {
        

        $photoeventdata =  DB::table('photo_events')->where('status',1)->get();       
       
        return view('backend.photo-events.index', compact('photoeventdata'));
       
    }

    /**
     * @param \App\Http\Requests\Backend\PhotoEvents\CreatePageRequest $request
     *
     * @return \App\Http\Responses\ViewResponse
     */
    public function create(CreatePhotoEventRequest $request)
    {
            

            $layoutPageDetail =  DB::table('layouts_pages')->where('status',1)->get();            
            
            return view('backend.photo-events.create', compact('layoutPageDetail'));


           
    }

    /**
     * @param \App\Http\Requests\Backend\PhotoEvents\StorePageRequest $request
     *
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(Request $request)
    {

// echo "<pre>"; print_r($_POST); echo "</pre>";
// echo "<pre>"; print_r($_FILES); echo "</pre>";
// die;
         $this->validate($request, [
            'event_title'           => 'required',            
            'event_backendbg_image' => 'required|image|mimes:jpeg,png,gif,svg',
            'event_forntbg_image'   => 'required|image|mimes:jpeg,png,gif,svg',
            'event_feature_image'   => 'required|image|mimes:jpeg,png,gif,svg',
            'event_sound'           => 'file|mimes:audio/mpeg,mpga,mp3',
            'event_host'            => 'required',
            'event_collage'         => 'required',
        ]);


        if (DB::table('photo_events')->where('event_title', $request['event_title'])->first()) {
            throw new GeneralException(__('exceptions.backend.photo-events.already_exists'));
        } 



        /*For Event Back End Background Image */
         $backendbg = '';
        if($request->hasFile('event_backendbg_image')){
           // $layoutimage =   $this->uploadImage($request);
            $file        = $request->file('event_backendbg_image');
            $filename    = time().'_event_backendbg_image_'.$file->getClientOriginalName();
            $path        = public_path().'/storage/img/event/';
            $data        = $file->move($path, $filename);
            $backendbg   = $filename;

        }
        /*For Event Fornt End Background Image */
        $forntbg = '';
        if($request->hasFile('event_forntbg_image')){
           // $layoutimage =   $this->uploadImage($request);
            $file        = $request->file('event_forntbg_image');
            $filename    = time().'_event_forntbg_image_'.$file->getClientOriginalName();
            $path        = public_path().'/storage/img/event/';
            $data        = $file->move($path, $filename);
            $forntbg     = $filename;

        }

        /*For Event Feature Image */
        $featureimage = '';
        if($request->hasFile('event_feature_image')){
           // $layoutimage =   $this->uploadImage($request);
            $file               = $request->file('event_feature_image');
            $filename           = time().'_event_feature_image_'.$file->getClientOriginalName();
            $path               = public_path().'/storage/img/event/feature/';
            $data               = $file->move($path, $filename);
            $featureimage       = $filename;

        }

        /*For Upload Event Sound */
        $sound = '';
        if($request->hasFile('event_sound')){
           // $layoutimage =   $this->uploadImage($request);
            $file        = $request->file('event_sound');
            $filename    = time().'_event_sound_'.$file->getClientOriginalName();
            $path        = public_path().'/storage/img/event/sound/';
            $data        = $file->move($path, $filename);
            $sound       = $filename;

        }

        
       /* For Insert Event*/

        $insertdata =  PhotoEvent::insertGetId( [
                                                    'event_title'           =>$request->event_title,
                                                    'event_backendbg_image' =>$backendbg,
                                                    'event_forntbg_image'   =>$forntbg,
                                                    'event_feature_image'   =>$featureimage,
                                                    'event_sound'           =>$sound,
                                                    'event_host'            =>$request->event_host,
                                                    'event_collage'         =>$request->event_collage,
                                                    'status'                =>$request->status ?? 0,
                                                    'event_start_date'            =>$request->event_start_date,
                                                    'event_end_date'            =>$request->event_end_date,
													'isActionOnDate'                =>$request->isActionOnDate??0,
                                                    'created_by'            => auth()->user()->id,
                                                    
                                                ]);

         

                 /* After Insert Event Id behalf of Insert No Of Lyout Back Grounf Image*/

                                   /* Check Event id*/

                                    if($insertdata>0){

                                        /* Check layout Selected id*/
                                        if($request->nolayout){

                                           $nolayouts = $request->get('nolayout'); 

                                            foreach($nolayouts as $key=>$nolayoutval) {

                                                /* create image file input name by layout id*/   

                                                $layoutbgimage = 'layoutbgimage'.$nolayoutval;
                                                
                                             /* Check fileupload data*/  
                                                if($request->hasFile($layoutbgimage)){ 

                                                    $file        = $request->file($layoutbgimage);
                                                    $filename    = time().'_'.$layoutbgimage.'_'.$file->getClientOriginalName();
                                                    $path        = public_path().'/storage/img/event/layoutbg/';
                                                    $data        = $file->move($path, $filename);
                                                    $layoutbgimage       = $filename;

                                                    /* Insert EventNolayoutBgimage data*/ 

                                                    $insertdatalayout =  EventNolayoutBgimage::insertGetId( [

                                                        'event_id'          => $insertdata,
                                                        'layout_id'         => $nolayoutval,
                                                        'layout_bg_image'   => $layoutbgimage                     
                                                    ]);
                                                }else{
                                                    $insertdatalayout =  EventNolayoutBgimage::insertGetId( [
                                                        'event_id'          => $insertdata,
                                                        'layout_id'         => $nolayoutval                       
                                                    ]);
                                                } /* Check fileupload data*/ 

                                            } /* end foreach*/ 
                                        } /* Check layout Selected id*/ 

                                        return new RedirectResponse(route('admin.photo-events.index'), ['flash_success' => __('alerts.backend.photo-events.created')]);

                                    }else{

                                            throw new GeneralException(
                                                __('exceptions.backend.layoutspages.update_error')
                                            );


                                    }
      
        
    }

    /**
     * @param \App\Models\Page $page
     * @param \App\Http\Requests\Backend\PhotoEvents\EditPageRequest $request
     *
     * @return \App\Http\Responses\Backend\Blog\EditResponse
     */
    public function edit($id)
    {
        $layoutPageDetail =  DB::table('layouts_pages')->where('status',1)->get();             
        $photoEvent       =  DB::table('photo_events')->where('id',$id)->get();
        $selectenolayout  =  DB::table('event_nolayout_bgimages')->where('event_id',$id)->get();

        $selectenolayoutarr = array();
        $selectenolayoutIdarr = array();
        if(isset($selectenolayout) && $selectenolayout!=''){

            foreach ($selectenolayout as $key => $value) {
               
                    $selectenolayoutarr[$value->layout_id] = $value->layout_bg_image;
                    $selectenolayoutIdarr[] = $value->layout_id;
            }
        }

         return view('backend.photo-events.edit', compact('photoEvent', 'layoutPageDetail', 'selectenolayoutIdarr', 'selectenolayoutarr'));

       // return new EditResponse($photoEvent);
    }

    /**
     * @param \App\Models\Page $page
     * @param \App\Http\Requests\Backend\PhotoEvents\UpdatePageRequest $request
     *
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'event_title'           => 'required', 
            'event_host'            => 'required',
            'event_collage'         => 'required',
        ]);






        /*For Event Back End Background Image */
        
        if($request->hasFile('event_backendbg_image')){

            $this->validate($request, [                    
              'event_backendbg_image' => 'image|mimes:jpeg,png,gif,svg',            
           ]);

           // $layoutimage =   $this->uploadImage($request);
            $file        = $request->file('event_backendbg_image');
            $filename    = time().'_event_backendbg_image_'.$file->getClientOriginalName();
            $path        = public_path().'/storage/img/event/';
            $data        = $file->move($path, $filename);
            $backendbg   = $filename;

        }else{

            $backendbg   =   $request['event_backendbg_image_old'];

        }

      


        /*For Event Fornt End Background Image */

        if($request->hasFile('event_forntbg_image')){

             $this->validate($request, [                    
              'event_forntbg_image' => 'image|mimes:jpeg,png,gif,svg',            
           ]);
           // $layoutimage =   $this->uploadImage($request);
            $file        = $request->file('event_forntbg_image');
            $filename    = time().'_event_forntbg_image_'.$file->getClientOriginalName();
            $path        = public_path().'/storage/img/event/';
            $data        = $file->move($path, $filename);
            $forntbg     = $filename;

        }else{

            $forntbg   =   $request['event_forntbg_image_old'];

        }

        /*For Event Fornt End Background Image */

        if($request->hasFile('event_feature_image')){

             $this->validate($request, [                    
              'event_feature_image' => 'image|mimes:jpeg,png,gif,svg',            
           ]);
           // $layoutimage =   $this->uploadImage($request);
            $file        = $request->file('event_feature_image');
            $filename    = time().'_event_feature_image_'.$file->getClientOriginalName();
            $path        = public_path().'/storage/img/event/feature/';
            $data        = $file->move($path, $filename);
            $featureimage     = $filename;

        }else{

            $featureimage   =   $request['event_feature_image_old'];

        }

        /*For Upload Event Sound */

        if($request->hasFile('event_sound')){

            $this->validate($request, [                    
              'event_sound' => 'file|mimes:audio/mpeg,mpga,mp3',           
           ]);
           // $layoutimage =   $this->uploadImage($request);
            $file        = $request->file('event_sound');
            $filename    = time().'_event_sound_'.$file->getClientOriginalName();
            $path        = public_path().'/storage/img/event/sound/';
            $data        = $file->move($path, $filename);
            $sound       = $filename;

            }else{

                $sound   =   $request['event_sound_old'];

            }
        

            $update = DB::table('photo_events')
                    ->where('id', $id)
                    ->update([
                        
                                                    'event_title'           =>$request->event_title,
                                                    'event_backendbg_image' =>$backendbg,
                                                    'event_forntbg_image'   =>$forntbg,
                                                    'event_feature_image'   =>$featureimage,
                                                    'event_sound'           =>$sound,
                                                    'event_host'            =>$request->event_host,
                                                    'event_collage'         =>$request->event_collage,
                                                    'status'                =>$request->status,
                                                    'event_start_date'            =>$request->event_start_date,
                                                    'event_end_date'            =>$request->event_end_date,
													'isActionOnDate'                =>$request->isActionOnDate??0,
                                                    'updated_at'            => date('Y-m-d H:i:s'),
                ]);






            if($update == true || $update == 0){ 

                /* Check Event id*/

                                    if($id >0){

                                        /* Check layout Selected id*/
                                        if($request->nolayout){

                                           $nolayouts = $request->get('nolayout');
                                           $deleenolayout = DB::table('event_nolayout_bgimages')->where('event_id', $id)->delete();


                                            foreach($nolayouts as $key=>$nolayoutval) {

                                                /* create image file input name by layout id*/   

                                                $layoutbgimage = 'layoutbgimage'.$nolayoutval;
                                                
                                             /* Check fileupload data*/  
                                                 /* Check fileupload data*/ 

                                                if($request->hasFile($layoutbgimage)){ 

                                                    $file        = $request->file($layoutbgimage);
                                                    $filename    = time().'_'.$layoutbgimage.'_'.$file->getClientOriginalName();
                                                    $path        = public_path().'/storage/img/event/layoutbg/';
                                                    $data        = $file->move($path, $filename);
                                                    $layoutbgimage       = $filename;

                                                    /* Insert EventNolayoutBgimage data*/ 

                                                    $insertdatalayout =  EventNolayoutBgimage::insertGetId( [

                                                        'event_id'          => $id,
                                                        'layout_id'         => $nolayoutval,
                                                        'layout_bg_image'   => $layoutbgimage                     
                                                    ]);
                                                }else{

                                                     $layoutbgimage       = $request[$layoutbgimage.'_old'];

                                                    if($layoutbgimage){

                                                        $insertdatalayout =  EventNolayoutBgimage::insertGetId( [
                                                            'event_id'          => $id,
                                                            'layout_id'         => $nolayoutval,
                                                            'layout_bg_image'   => $layoutbgimage,                       
                                                         ]);

                                                    }else{

                                                            $insertdatalayout =  EventNolayoutBgimage::insertGetId( [
                                                            'event_id'          => $id,
                                                            'layout_id'         => $nolayoutval
                                                                                   
                                                         ]);

                                                    }

                                                    
                                                } /* Check fileupload data*/

                                                /* Insert EventNolayoutBgimage data*/


                                            } /* end foreach*/ 
                                        } /* Check layout Selected id*/

                                    }
              
                return new RedirectResponse(route('admin.photo-events.index'), ['flash_success' => __('alerts.backend.photo-events.updated')]);
                }
                else{
                    throw new GeneralException(
                            __('exceptions.backend.photo-events.update_error')
                        );
                } 


   


    }

    /**
     * @param \App\Models\Page $page
     * @param \App\Http\Requests\Backend\PhotoEvents\DeletePageRequest $request
     *
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(PhotoEvent $photoEvent, DeletePhotoEventRequest $request)
    {
        $this->repository->delete($photoEvent);

        return new RedirectResponse(route('admin.photo-events.index'), ['flash_success' => __('alerts.backend.photo-events.deleted')]);
    }


    public function destroy_nolayout(Request $request)
    {
       

        

        

        if(request()->ajax()){

           $deleenolayout = DB::table('event_nolayout_bgimages')->where('layout_id', $request->layoutid)
           ->where('event_id',  $request->event_id)->delete();



           if($deleenolayout == 0) {

                return response()->json([
                     'success' => false
                ]);

           }elseif($deleenolayout == 1){

                  
                  $directory  = public_path().'/storage/img/event/layoutbg/'.$request->filename;

                  

                       /*unlink File*/

                        if (file_exists($directory)){
                            unlink($directory);
                        }

                        return response()->json([

                             'success' => true
                        ]);

           }// End elseif  
            
        }// End Ajax request


        die();
        
    }


    

    public function qrcode($id)
    {
               
           return view('backend.photo-events.qrcode', compact('id'));
    }
}
