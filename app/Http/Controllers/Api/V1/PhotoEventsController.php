<?php

namespace App\Http\Controllers\Api\V1;
use App\Http\Requests\Backend\PhotoEvents\CreatePhotoEventRequest;
use App\Http\Requests\Backend\PhotoEvents\DeletePhotoEventRequest;
use App\Http\Requests\Backend\PhotoEvents\EditPhotoEventRequest;
use App\Http\Requests\Backend\PhotoEvents\ManagePhotoEventRequest;
use App\Http\Requests\Backend\PhotoEvents\StorePhotoEventRequest;
use App\Http\Requests\Backend\PhotoEvents\UpdatePhotoEventRequest;
use App\Http\Resources\PhotoEventsResource;
use App\Models\PhotoEvent;
use App\Repositories\Backend\PhotoEventsRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

/**
 * @group PhotoEvents Management
 *
 * Class PhotoEventsController
 *
 * APIs for PhotoEvents Management
 *
 * @authenticated
 */
class PhotoEventsController extends APIController
{
    /**
     * Repository.
     *
     * @var PhotoEventsRepositoryRepository
     */
    protected $repository;

    /**
     * __construct.
     *
     * @param $repository
     */
    public function __construct(PhotoEventsRepository $repository)
    {

       
        $this->repository = $repository;
    }

    /**
     * Get all Pages.
     *
     * This endpoint provides a paginated list of all pages. You can customize how many records you want in each
     * returned response as well as sort records based on a key in specific order.
     *
     * @queryParam page Which page to show. Example: 12
     * @queryParam per_page Number of records per page. (use -1 to retrieve all) Example: 20
     * @queryParam order_by Order by database column. Example: created_at
     * @queryParam order Order direction ascending (asc) or descending (desc). Example: asc
     *
     * @responseFile status=401 scenario="api_key not provided" responses/unauthenticated.json
     * @responseFile responses/page/page-list.json
     *
     * @param \Illuminate\Http\ManagePhotoEventRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id, $userid)
    {
       
      $response = array();

      /*$layoutsdatas = DB::table('photo_events')
        ->join('event_nolayout_bgimages', 'event_nolayout_bgimages.event_id', '=', 'photo_events.id')
        ->join('layouts_pages', 'layouts_pages.id', '=', 'event_nolayout_bgimages.layout_id')
         ->where('photo_events.id','=', $id)
         ->where('photo_events.status','=', 1)
        ->select('photo_events.*',
            'event_nolayout_bgimages.id as layoutbg_id',
            'event_nolayout_bgimages.layout_id',
            'event_nolayout_bgimages.layout_bg_image',
            'layouts_pages.layout_image'
            )->get();*/

         

             $layoutsdatas = PhotoEvent::with('get_layout_details') 
                        ->where('id',$id)                        
                        ->first();



            if(empty($layoutsdatas)){

               $response['status']      = false;
               $response['message']     = 'Event Not Found';              

            }else{
                  

                $image_url['event_image']          = url('/').'/storage/img/event/';
                $image_url['layout_image']         = url('/').'/storage/img/layout/';
                $image_url['event_layout_bgimage'] = url('/').'/storage/img/event/layoutbg/';
                $image_url['event_feature_image']  = url('/').'/storage/img/event/feature/';
                $image_url['event_sound']          = url('/').'/storage/img/event/sound/';
                $layoutsdatas['image_base_url']    = $image_url;

                $response['status']      = true;
                $response['message']     = 'Event Found Successfully';
                $response['data']        = $layoutsdatas;


                $erelationwithuer =  DB::table('event_relationwith_user')->where('user_id', $userid)->where('event_id', $id)->get(); 
                if(count($erelationwithuer) == 0){

                    /*For Event With Relation*/

                    $inserterelationwithuer =  DB::table('event_relationwith_user')->insert([

                                                        'user_id'          => $userid,
                                                        'event_id'         => $id                        
                                                        
                                                    ]);

                }


            }   




      return $response;
       


       //return view('backend.layoutspages.index', compact('layoutsdatas'));

        
       // $collection = $this->repository->retrieveList($request->all());

      // return PhotoEventsResource::collection($collection);
    }

    /**
     * Gives a specific Page.
     *
     * This endpoint provides you a single Page
     * The Page is identified based on the ID provided as url parameter.
     *
     * @urlParam id required The ID of the Page
     *
     * @responseFile status=401 scenario="api_key not provided" responses/unauthenticated.json
     * @responseFile responses/page/page-show.json
     *
     * @param ManagePhotoEventRequest $request
     * @param \App\Models\PhotoEvent $photoEvent
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ManagePhotoEventRequest $request, PhotoEvent $photoEvent)
    {
        return new PhotoEventsResource($photoEvent);
    }

    /**
     * Create a new Page.
     *
     * This endpoint lets you create new Page
     *
     * @responseFile status=401 scenario="api_key not provided" responses/unauthenticated.json
     * @responseFile status=201 responses/page/page-store.json
     *
     * @param \App\Http\Requests\Backend\PhotoEvents\StorePageRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StorePhotoEventRequest $request)
    {
        $PhotoEvent = $this->repository->create($request->validated());

        return (new PhotoEventsResource($PhotoEvent))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Update Page.
     *
     * This endpoint allows you to update existing Page with new data.
     * The Page to be updated is identified based on the ID provided as url parameter.
     *
     * @urlParam id required The ID of the Page
     *
     * @responseFile status=401 scenario="api_key not provided" responses/unauthenticated.json
     * @responseFile responses/page/page-update.json
     *
     * @param \App\Models\PhotoEvent $photoEvent
     * @param \App\Http\Requests\Backend\PhotoEvents\UpdatePageRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdatePhotoEventRequest $request, PhotoEvent $photoEvent)
    {
        $photoEvent = $this->repository->update($photoEvent, $request->validated());

        return new PagesResource($photoEvent);
    }

    /**
     * Delete Page.
     *
     * This endpoint allows you to delete a Page
     * The Page to be deleted is identified based on the ID provided as url parameter.
     *
     * @urlParam id required The ID of the Page
     *
     * @responseFile status=401 scenario="api_key not provided" responses/unauthenticated.json
     * @responseFile status=204 scenario="When the record is deleted" responses/page/page-destroy.json
     *
     * @param \App\Models\PhotoEvent $photoEvent
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeletePhotoEventRequest $request, PhotoEvent $photoEvent)
    {
        $this->repository->delete($photoEvent);

        return response()->noContent();
    }

    /*For eventRelationwithUser*/

    public function visitedEventByUser($userid){




            $eventRelationwithUser = DB::table('photo_events')
                ->rightjoin('event_relationwith_user', 'event_relationwith_user.event_id', '=', 'photo_events.id')                
                 ->where('event_relationwith_user.user_id','=', $userid)
                 ->where('photo_events.status','=', 1)
                  ->select('photo_events.*',
                    'event_relationwith_user.user_id',
                    'event_relationwith_user.event_id as eventRelationwithUser_id', 
                )->get();

            
          

            if(count($eventRelationwithUser)==0){

                    $response['status']      = false;
                    $response['message']     = 'No Record Found';

            }else{

                $response['status']      = true;
                $response['message']     = 'Record Found';
                $response['data']        = $eventRelationwithUser;
                
                $image_url['event_image']          = url('/').'/storage/img/event/';
                $image_url['layout_image']         = url('/').'/storage/img/layout/';
                $image_url['event_layout_bgimage'] = url('/').'/storage/img/event/layoutbg/';
                $image_url['event_feature_image']  = url('/').'/storage/img/event/feature/';
                $image_url['event_sound']          = url('/').'/storage/img/event/sound/';
                $response['image_base_url']    = $image_url;

                


                }

            return $response;

    }


}
