<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\EventImage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EventImageController extends APIController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
         $eventimagesdetail = DB::table('event_images')           
            ->where('event_id', '=', $id)->where('type', '=', 'image') 
            ->get();

        
        
          
            /* For Like*/

        $comment = DB::table('event_image_comments')           
        ->where('photo_events_id', '=', $id) 
        ->get();
         
         $commentcount = array();

        if (isset($comment) && !empty($comment) ) {     

            foreach ($comment as $value) {            

                  

                    $eventimageid =$value->event_image_id;
                     if (isset($commentcount[$eventimageid]) && !empty($commentcount[$eventimageid]) ) {                  
                      
                       $commentcount[$eventimageid] = $commentcount[$eventimageid]+1;
                    }else{

                        $commentcount[$eventimageid] = 1;
                    }

                  
                }
            }


        /*For Likes*/

        $like = DB::table('event_image_like')           
        ->where('photo_events_id', '=', $id) 
        ->get();


        $likecount  = array();
        $users       = array();
         

        if (isset($like) && !empty($like) ) {     

            foreach ($like as $value) { 

                    $eventimageid =$value->event_image_id;
                     if (isset($likecount[$eventimageid]) && !empty($likecount[$eventimageid]) ) {                  
                      
                       $likecount[$eventimageid] = $likecount[$eventimageid]+1;
                    }else{

                        $likecount[$eventimageid] = 1;
                    }

                   /* for user */

                   if(!in_array($value->user_id, $users)){
                        $users[]= $value->user_id;
                    }
                }
            }



            if(empty($eventimagesdetail)){

               $response['status']      = false;
               $response['message']     = 'Event Image Detail Not Found';              

            }else{
                  

                $response['event_image']          = url('/').'/storage/img/event/eventimage'; 
                $response['status']           = true;
                $response['message']          = 'Event Image Detail Found Successfully';
                $response['data']             = $eventimagesdetail;
                $response['commentcount']     = $commentcount;
                $response['likecount']        = $likecount;
                $response['likeuser']         = $users;




            }

            return $response;

           
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'event_id'   => 'required',
            'layout_id'  => 'required',
            'created_by' => 'required',
            'image.*'    => 'required|image|mimes:jpeg,png,gif,svg',
            'collage'    => 'required|image|mimes:jpeg,png,gif,svg'
        ]);

       
       $response =array();
       $path        = public_path().'/storage/img/event/eventimage/';

        /* For Colloge Image Upload*/

        if($request->file('collage')){
           

            $file        = $request->file('collage');
            $filename    = time().$file->getClientOriginalName();           
            $data        = $file->move($path, $filename);

            $collagedata  = EventImage::insert( [
                'image'        =>  $filename,
                'event_id'     =>$request->event_id,
                'type'         =>'collage',
                'layout_id'    =>$request->layout_id,
                'created_by'   =>$request->created_by                    
                ]);

            if($collagedata){
                  $response['collage_status'] = true;
                  $response['collage_message'] = 'Collage Insert Successfully';
              }else{

                  $response['collage_status'] = false;
                  $response['collage_status'] = 'Collage Not Insert Successfully';
              }

        }
       

       /* For Multiple Image Upload*/

       $imagetext = $request->image_text;

       print_r($imagetext);

        //$images=array();
        if($files=$request->file('image')){
            foreach($files as $key => $file){
                $filename    = time().$file->getClientOriginalName();               
                $data        = $file->move($path, $filename);
               
                //$images[]=$name;

                echo $imagetext[$key];

                /*$insertdata =  EventImage::insert( [
                                                    'image'        =>  $filename,
                                                    'event_id'     =>$request->event_id,
                                                    'image_text'   =>$imagetext[$key],
                                                    'type'         =>'image',
                                                    'layout_id'    =>$request->layout_id,
                                                    'created_by'   =>$request->created_by  
                                                    
                                                ]);*/
                                                
       
        }

                                                if($insertdata){
                                                      $response['image_status'] = true;
                                                      $response['image_message'] = 'Image Insert Successfully';
                                                  }else{

                                                      $response['image_status'] = false;
                                                      $response['image_status'] = 'Image Not Insert Successfully';
                                                  }
    }

        




       

        return $response;

        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EventImage  $eventImage
     * @return \Illuminate\Http\Response
     */

    public function show($id, $userid)
    {
       
         $response = array();

         $eventimages = EventImage::where('event_id',$id)->where('created_by',$userid)->where('type', '=', 'collage')->get()->toArray();

         /* $eventimages = EventImage::all();
         $eventimages = $eventimages->values()->all();
         $eventimages = $eventimages->filter(function ($item) {
                return $item->id > 1;
            })->values()->all();*/

         


            if(empty($eventimages)){

               $response['status']      = false;
               $response['message']     = 'Event Image Not Found';              

            }else{
                  

                $response['event_image']          = url('/').'/storage/img/event/eventimage'; 
                $response['status']      = true;
                $response['message']     = 'Event Image Found Successfully';
                $response['data']        = $eventimages;




            }   




      return $response;
       


       //return view('backend.layoutspages.index', compact('eventimages'));

        
       // $collection = $this->repository->retrieveList($request->all());

      // return PhotoEventsResource::collection($collection);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EventImage  $eventImage
     * @return \Illuminate\Http\Response
     */
    public function edit(EventImage $eventImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EventImage  $eventImage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EventImage $eventImage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EventImage  $eventImage
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventImage $eventImage)
    {
        //
    }


    /*For Comment*/
    public function comment_store(Request $request)
    {

        $this->validate($request, [
            'event_image_id'   => 'required',
            'photo_events_id'  => 'required',
            'comment_text'     => 'required',            
            'user_id'          => 'required'
        ]);

           

                         $insertdata =  DB::table('event_image_comments')->insert([
                                                    'event_image_id'      => $request->event_image_id,
                                                    'photo_events_id'     => $request->photo_events_id,
                                                    'comment_text'        => $request->comment_text,
                                                    'user_id'             => $request->user_id  
                                                    
                                                ]);

                                    if($insertdata){
                                          $response['comment'] = true;
                                          $response['comment_message'] = 'Comment Insert Successfully';
                                      }else{

                                          $response['comment'] = false;
                                          $response['comment_status'] = 'Comment Not Insert Successfully';
                                      }

        return $response;        
        
    }


    public function comment_update(Request $request, $id)
    {
    	$this->validate($request, [
            'event_image_id'   => 'required',
            'photo_events_id'  => 'required',
            'comment_text'     => 'required',
            'approved'         => 'required',
            'user_id'          => 'required'
        ]);

           

                         $updatedata =  DB::table('event_image_comments')
									              ->where('id', $id)
									              ->update([
                                                    'event_image_id'      => $request->event_image_id,
                                                    'photo_events_id'     => $request->photo_events_id,
                                                    'comment_text'        => $request->comment_text,
                                                    'approved'            => $request->approved,
                                                    'user_id'             => $request->user_id  
                                                    
                                                ]);

                                    if($updatedata){
                                          $response['comment'] = true;
                                          $response['comment_message'] = 'Comment Update Successfully';
                                      }else{

                                          $response['comment'] = false;
                                          $response['comment_status'] = 'Comment Not Update Successfully';
                                      }

        return $response;
        
    }

    public function comment_delete($id)
    {

    	$deletedata = DB::table('event_image_comments')->where('id', $id)->delete();

                  if($deletedata){
                      $response['comment'] = true;
                      $response['comment_message'] = 'Comment Delete Successfully';
                  }else{

                      $response['comment'] = false;
                      $response['comment_status'] = 'Comment Not Delete Successfully';
                  }

        return $response;
    }


    /*For Like*/
    public function like_store(Request $request)
    {

        $this->validate($request, [
            'photo_events_id'   => 'required',
            'event_image_id'   => 'required', 
            'user_id'          => 'required',
            'liked'            => 'required'
        ]);

           if($request->liked=="liked"){
                 $likedata =  DB::table('event_image_like')->insert([
                                'photo_events_id'     => $request->photo_events_id,
                                'event_image_id'      => $request->event_image_id,
                                'user_id'             => $request->user_id  
                                
                            ]);

                if($likedata){
                      $response['like'] = true;
                      $response['like_message'] = 'Liked Successfully';
                  }else{

                      $response['like'] = false;
                      $response['like_status'] = 'Liked Not Successfully';
                  }
        }elseif($request->liked=="unliked"){


           $deletedata = DB::table('event_image_like')->where('event_image_id', $request->event_image_id)->where('user_id', $request->user_id)->delete();

              if($deletedata){
                  $response['like'] = true;
                  $response['like_message'] = 'Unliked Successfully';
              }else{

                  $response['like'] = false;
                  $response['like_status'] = 'Unliked Not Successfully';
              }



        }

        return $response;        
        
    }


  




}
