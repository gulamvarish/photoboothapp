<?php

namespace App\Http\Controllers\Backend\PhotoEvents;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\PhotoEvents\ManagePhotoEventRequest;
use App\Repositories\Backend\PhotoEventsRepository;
use Yajra\DataTables\Facades\DataTables;

class PhotoEventsTableController extends Controller
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
    }

    /**
     * @param \App\Http\Requests\Backend\PhotoEvents\ManagePhotoEventRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManagePhotoEventRequest $request)
    {

        
        return Datatables::of($this->repository->getForDataTable())
            ->filterColumn('status', function ($query, $keyword) {
                if (in_array(strtolower($keyword), ['active', 'inactive'])) {
                    $query->where('photo_events.status', (strtolower($keyword) == 'active') ? 1 : 0);
                }
            })
            ->filterColumn('created_by', function ($query, $keyword) {
                $query->whereRaw('users.first_name like ?', ["%{$keyword}%"]);
            })
            ->editColumn('status', function ($photoEvents) {
                return $photoEvents->status_label;
            })
            ->editColumn('created_at', function ($photoEvents) {
                return $photoEvents->created_at->toDateString();
            })
            ->addColumn('actions', function ($photoEvents) {
                return $photoEvents->action_buttons;
            })
            ->escapeColumns(['title'])
            ->make(true);
    }
}
