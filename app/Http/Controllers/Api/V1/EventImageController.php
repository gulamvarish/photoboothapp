<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\EventImage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use ImageResize;

class EventImageController extends APIController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($event_id, $user_id)
    {

         $eventimagesdetail = DB::table('event_images')           
            ->where('event_id', '=', $event_id)->where('type', '=', 'image') 
            ->get()->toArray();

        
        foreach ($eventimagesdetail as $key => &$event) {
          $comment = DB::table('event_image_comments')           
                    ->where('event_image_id', '=', $event->id) 
                    ->get();

          $event->commentcount = $comment->count();

          $likes = DB::table('event_image_like')           
                    ->where('event_image_id', '=', $event->id) 
                    ->get();

          $event->likecount = $likes->count();

          $userlike = DB::table('event_image_like')           
                    ->where('event_image_id', '=', $event->id) 
                    ->where('user_id', '=', $user_id) 
                    ->get();

          $event->is_user_liked = $userlike->count();
        }
        
            if(empty($eventimagesdetail)){

               $response['status']      = false;
               $response['message']     = 'Event Image Detail Not Found';              

            }else{
                  

                $response['event_image']      = url('/').'/storage/img/event/eventimage'; 
                $response['status']           = true;
                $response['message']          = 'Event Image Detail Found Successfully';
                $response['data']             = $eventimagesdetail;
            }

            return $response;

           
    }


    /*For Event Details*/

    public function event_single_image_detail($image_id, $user_id)
    {



         
        /*For comment Detail*/

         $commentdetail = DB::table('event_image_comments')           
            ->where('event_image_id', '=', $image_id)->where('parent_comment_id', '=', '0') 
            ->get()->toArray();

        //$items = array();
    if (isset($commentdetail) && !empty($commentdetail)) {

        foreach ($commentdetail as $key => &$commentdata) {

          $comment = DB::table('event_image_comments')           
                    ->where('parent_comment_id', '=', $commentdata->id) 
                    ->get();

        /*For user name*/

            $users = DB::table('users')           
                    ->where('id', '=', $commentdata->user_id) 
                    ->first();
             
            $commentdata->user_name = $users->first_name." ".$users->last_name;

        /*end For user name*/



                /*comment reply like count*/

                if (isset($comment) && !empty($comment)) {
                       
                    
                    foreach ($comment as $key => &$commentdata1) {


                        $likes = DB::table('event_image_comment_like')           
                        ->where('comment_id', '=', $commentdata1->id) 
                        ->get();

                        /*For current userlike*/

                        $is_user_like = DB::table('event_image_comment_like')           
                        ->where('user_id', '=', $user_id) 
                        ->get();
                        
                        if(!empty($is_user_like[0]->user_id) && $is_user_like[0]->user_id == $user_id){

                            $commentdata1->is_user_like = true;
                        }else{
                            $commentdata1->is_user_like = false;
                        }

                        /*End For current userlike*/

                         $commentdata1->commentlikecount = $likes->count();

                         /*For user name*/

                            $users = DB::table('users')           
                                    ->where('id', '=', $commentdata1->user_id) 
                                    ->first();
                             
                            $commentdata1->user_name = $users->first_name." ".$users->last_name;

                    }// end of foreach
              }// end of if

        /*For Parent coment like */

        $likesparentcomment = DB::table('event_image_comment_like')           
                        ->where('comment_id', '=', $commentdata->id) 
                        ->get();

         $commentdata->commentlikecount = $likesparentcomment->count();
         $commentdata->commentreply     = $comment;

         


         /*For current userlike*/

                        $is_user_like = DB::table('event_image_comment_like')           
                        ->where('user_id', '=', $user_id) 
                        ->get();
                        
                        if(!empty($is_user_like[0]->user_id) && $is_user_like[0]->user_id == $user_id){

                            $commentdata->is_user_like = true;
                        }else{
                            $commentdata->is_user_like = false;
                        }

                        /*End For current userlike*/

          

         /*$userlike = DB::table('event_image_like')           
                    ->where('event_image_id', '=', $event->id) 
                    ->where('user_id', '=', $user_id) 
                    ->get();

          $event->is_user_liked = $userlike->count();*/
        }
    }
        
           



        /*For Single Image*/

        $eventimagesdetail = DB::table('event_images')           
        ->where('id', '=', $image_id)->where('type', '=', 'image') 
        ->get()->toArray();

        //print_r($eventimagesdetail);


        

            

        
        foreach ($eventimagesdetail as $key => &$event) {
          $comment = DB::table('event_image_comments')           
                    ->where('event_image_id', '=', $event->id) 
                    ->get();



         /*For user name*/

            $users = DB::table('users')           
                    ->where('id', '=', $event->created_by) 
                    ->first();
             
            $event->user_name = $users->first_name." ".$users->last_name;

        /*end For user name*/

        

          $event->commentcount = $comment->count();

          $likes = DB::table('event_image_like')           
                    ->where('event_image_id', '=', $event->id) 
                    ->get();

          $event->likecount = $likes->count();

          $userlike = DB::table('event_image_like')           
                    ->where('user_id', '=', $user_id)                     
                    ->get();

                   

             if(!empty($userlike[0]->user_id) && $userlike[0]->user_id == $user_id)
             {

                $event->is_user_liked = true;

            }else{
                $event->is_user_liked = false;
            }         

          
        }

        /*For user name*/

            


        
            if(empty($eventimagesdetail)){

               $response['status']      = false;
               $response['message']     = 'Event Image Detail Not Found';              

            }else{
                  

                $response['event_image']          = url('/').'/storage/img/event/eventimage'; 
                $response['status']           = true;
                $response['message']          = 'Event Image Detail Found Successfully';
                $response['data']             = $eventimagesdetail;
                $response['commentdeatil']    = $commentdetail;
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
       $path                 = public_path().'/storage/img/event/eventimage/';
       $thumbnailpath        = public_path().'/storage/img/event/eventimage/thumbnail/';

        /* For Colloge Image Upload*/

        if($request->file('collage')){
           

            /*$file        = $request->file('collage');
            $filename    = time().$file->getClientOriginalName();           
            $data        = $file->move($path, $filename);
*/


            $image = $request->file('collage');            
            $input['imagename'] = time().$image->getClientOriginalName();
         
            $destinationPath = $thumbnailpath;
            $img = ImageResize::make($image->path());
            $img->resize(200, 250, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($destinationPath.'/'.$input['imagename']);
       
            $imagePath = $path;
            $image->move($imagePath, $input['imagename']);



            $collagedata  = EventImage::insert( [
                'image'        => $input['imagename'],
                'thumbnail'    => $input['imagename'],
                'event_id'     => $request->event_id,
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

        //$images=array();
        if($files=$request->file('image')){
            foreach($files as $key => $file){
                //$filename    = time().$file->getClientOriginalName();               
                //$data        = $file->move($path, $filename);



                $input['imagename'] = time().$file->getClientOriginalName();
             
                $destinationPath = $thumbnailpath;
                $img = ImageResize::make($file->path());
                $img->resize(200, 250, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save($destinationPath.'/'.$input['imagename']);
           
                $imagePath = $path;
                $file->move($imagePath, $input['imagename']);
               
                //$images[]=$name;

                $insertdata =  EventImage::insert( [
                                                    'image'        =>  $input['imagename'],
                                                    'thumbnail'    => $input['imagename'],
                                                    'event_id'     =>$request->event_id,
                                                    'image_text'   =>$imagetext[$key],
                                                    'type'         =>'image',
                                                    'layout_id'    =>$request->layout_id,
                                                    'created_by'   =>$request->created_by  
                                                    
                                                ]);
                                                
       
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
            'parent_comment_id'=> 'required',            
            'user_id'          => 'required'
        ]);

           

                         $insertdata =  DB::table('event_image_comments')->insert([
                                                    'event_image_id'      => $request->event_image_id,
                                                    'photo_events_id'     => $request->photo_events_id,
                                                    'comment_text'        => $request->comment_text,
                                                    'parent_comment_id'   => $request->parent_comment_id,
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

        $eventimagesdetail = DB::table('event_images')           
            ->where('event_id', '=', $request->photo_events_id)->where('type', '=', 'image') 
            ->get()->toArray();

        
        foreach ($eventimagesdetail as $key => &$event) {
          $comment = DB::table('event_image_comments')           
                    ->where('event_image_id', '=', $event->id) 
                    ->get();

          $event->commentcount = $comment->count();

          $likes = DB::table('event_image_like')           
                    ->where('event_image_id', '=', $event->id) 
                    ->get();

          $event->likecount = $likes->count();

          $userlike = DB::table('event_image_like')           
                    ->where('event_image_id', '=', $event->id) 
                    ->where('user_id', '=', $request->user_id) 
                    ->get();

          $event->is_user_liked = $userlike->count();
        }
        $response['data']             = $eventimagesdetail;
        return $response;        
        
    }



    /*For comment Like*/
    public function comment_like_store(Request $request)
    {

        $this->validate($request, [
            'photo_events_id'   => 'required',
            'event_image_id'   => 'required',
            'comment_id'       => 'required', 
            'user_id'          => 'required',
            'liked'            => 'required'
        ]);

           if($request->liked=="liked"){
                 $likedata =  DB::table('event_image_comment_like')->insert([
                                'photo_events_id'     => $request->photo_events_id,
                                'event_image_id'      => $request->event_image_id,
                                'comment_id'          => $request->comment_id,
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


           $deletedata = DB::table('event_image_comment_like')->where('event_image_id', $request->event_image_id)->where('user_id', $request->user_id)->delete();

              if($deletedata){
                  $response['like'] = true;
                  $response['like_message'] = 'Unliked Successfully';
              }else{

                  $response['like'] = false;
                  $response['like_status'] = 'Unliked Not Successfully';
              }



        }

        /*$eventimagesdetail = DB::table('event_images')           
            ->where('event_id', '=', $request->photo_events_id)->where('type', '=', 'image') 
            ->get()->toArray();

        
        foreach ($eventimagesdetail as $key => &$event) {
          $comment = DB::table('event_image_comments')           
                    ->where('event_image_id', '=', $event->id) 
                    ->get();

          $event->commentcount = $comment->count();

          $likes = DB::table('event_image_like')           
                    ->where('event_image_id', '=', $event->id) 
                    ->get();

          $event->likecount = $likes->count();

          $userlike = DB::table('event_image_like')           
                    ->where('event_image_id', '=', $event->id) 
                    ->where('user_id', '=', $request->user_id) 
                    ->get();

          $event->is_user_liked = $userlike->count();
        }
        $response['data']             = $eventimagesdetail;*/
        return $response;        
        
    }


  




}
