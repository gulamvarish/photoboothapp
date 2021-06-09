<?php

namespace App\Http\Controllers\Backend\LayoutsPages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\LayoutsPages\CreateLayoutsPageRequest;
use App\Http\Requests\Backend\LayoutsPages\DeleteLayoutsPageRequest;
use App\Http\Requests\Backend\LayoutsPages\EditLayoutsPageRequest;
use App\Http\Requests\Backend\LayoutsPages\ManageLayoutsPageRequest;
use App\Http\Requests\Backend\LayoutsPages\StoreLayoutsPageRequest;
use App\Http\Requests\Backend\LayoutsPages\UpdateLayoutsPageRequest;
use App\Http\Responses\Backend\LayoutsPage\EditResponse;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Models\LayoutsPage;
use App\Repositories\Backend\LayoutsPagesRepository;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Str;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Storage;


class LayoutsController extends Controller
{
    
    /**
     * @var \App\Repositories\Backend\LayoutsPagesRepository
     */
    protected $repository;
     protected $storage;

    /**
     * @param \App\Repositories\Backend\LayoutsPagesRepository $repository
     */
    public function __construct(LayoutsPagesRepository $repository)
    {
        $this->repository = $repository;
        View::share('js', ['layouts']);
        $this->upload_path = 'img'.DIRECTORY_SEPARATOR.'layout'.DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('public');
    }

    /**
     * @param \App\Http\Requests\Backend\LayoutsPages\ManagePageRequest $request
     *
     * @return \App\Http\Responses\ViewResponse
     */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

   

    

     public function uploadImage($request)
    {
        if (isset($request['layout_image']) && ! empty($request['layout_image'])) {
            $avatar = $request['layout_image'];
            $fileName = time().$avatar->getClientOriginalName();
            // echo "<pre>"; print_r($avatar->getRealPath()); die; exit;
            $this->storage->put($this->upload_path.$fileName, file_get_contents($avatar->getRealPath()));        


        }

        return $request;
    }

    public function index(ManageLayoutsPageRequest $request)
    {
      

       $layoutsdatas =  DB::table('layouts_pages')->where('status',1)->get();
       return view('backend.layoutspages.index', compact('layoutsdatas'));
       
    }

    /**
     * @param \App\Http\Requests\Backend\LayoutsPages\CreateLayoutsPageRequest $request
     *
     * @return \App\Http\Responses\ViewResponse
     */
    public function create(CreateLayoutsPageRequest $request)
    {
        return new ViewResponse('backend.layoutspages.create');
    }

    /**
     * @param \App\Http\Requests\Backend\LayoutsPages\StorePageRequest $request
     *
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(StoreLayoutsPageRequest $request)
    {
        $this->repository->create($request->except(['_token', '_method']));

        return new RedirectResponse(route('admin.layoutspages.index'), ['flash_success' => __('alerts.backend.layoutspages.created')]);
    }

    /**
     * @param \App\Models\Page $page
     * @param \App\Http\Requests\Backend\LayoutsPages\EditPageRequest $request
     *
     * @return \App\Http\Responses\Backend\Blog\EditResponse
     */
    public function edit($id)
    {

        $layoutsPage =  DB::table('layouts_pages')->where('status',1)->where('id',$id)->get();
       // return new view('backend.layoutspages.edit', ['layoutsPage' => $layoutsPage]);
        return view('backend.layoutspages.edit', compact('layoutsPage'));
    }

    /**
     * @param \App\Models\Page $page
     * @param \App\Http\Requests\Backend\LayoutsPages\UpdatePageRequest $request
     *
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update($id, Request $request)
    {

        //echo $this->uploadImage($request);



        


        
    if($request->hasFile('layout_image')){
           // $layoutimage =   $this->uploadImage($request);
            $file        = $request->file('layout_image');
            $filename    = time().$file->getClientOriginalName();
            $path        = public_path().'/storage/img/layout/';
            $data        = $file->move($path, $filename);
            $layoutimage = $filename;

            }else{

                 $layoutimage =   $request['layout_image_old'];
            }
          $update = DB::table('layouts_pages')
                    ->where('id', $id)
                    ->update([
                        
                            'layout_title'    => $request['layout_title'],                                                        
                            'layout_image'    => $layoutimage,
                            'status'          => $request['status'] ?? 0,   
                            'updated_at'      => date('Y-m-d H:i:s'),
                ]);



        
                if($update == true){ 
              
                return new RedirectResponse(route('admin.layoutspages.index'), ['flash_success' => __('alerts.backend.layoutspages.updated')]);
                }
                elseif($update == 0){
                    return new RedirectResponse(route('admin.layoutspages.index'), ['flash_success' => __('alerts.backend.layoutspages.updated')]);
                }else{
                    throw new GeneralException(
                            __('exceptions.backend.layoutspages.update_error')
                        );
                } 

    }

    /**
     * @param \App\Models\Page $page
     * @param \App\Http\Requests\Backend\LayoutsPages\DeletePageRequest $request
     *
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
       
         $deleted = DB::table('layouts_pages')->where('id', $id)->delete();


                 if($deleted == 1){ 
              
                return new RedirectResponse(route('admin.layoutspages.index'), ['flash_success' => __('alerts.backend.layoutspages.deleted')]);
                }else{
                    throw new GeneralException(
                            __('exceptions.backend.layoutspages.update_error')
                        );
                }

        
    }
}
