<?php


namespace App\Http\Controllers\Backend\LayoutsPages;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\LayoutsPages\ManageLayoutsPageRequest;
use App\Repositories\Backend\LayoutsPagesRepository;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class LayoutsTableController extends Controller
{
    /**
     * @var \App\Repositories\Backend\LayoutsPagesRepository
     */
    protected $repository;

    /**
     * @param \App\Repositories\Backend\LayoutsPagesRepository $repository
     */
    public function __construct(LayoutsPagesRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param \App\Http\Requests\Backend\Layouts\ManagelayoutRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageLayoutRequest $request)
    {


       return $data =  DB::table('layouts')->where('status',1)->get();

        /* For log table entry*/

       
    }
}
