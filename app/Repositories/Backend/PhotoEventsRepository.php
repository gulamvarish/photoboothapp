<?php

namespace App\Repositories\Backend;

use App\Events\Backend\PhotoEvents\PhotoEventCreated;
use App\Events\Backend\PhotoEvents\PhotoEventDeleted;
use App\Events\Backend\PhotoEvents\PhotoEventUpdated;
use App\Exceptions\GeneralException;
use App\Models\PhotoEvent;
use App\Repositories\BaseRepository;
use Illuminate\Support\Str;
use auth;

class PhotoEventsRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = PhotoEvent::class;

    /**
     * Sortable.
     *
     * @var array
     */
    private $sortable = [
        'id',
        'event_title', 
        'event_backendbg_image',
        'event_forntbg_image',
        'event_sound',
        'event_qrcode',
        'event_start_date',
        'event_host',
        'event_collage',
        'event_feature_image',
        'status',
        'created_at',
        'updated_at',        
    ];

    /**
     * Retrieve List.
     *
     * @var array
     * @return Collection
     */

    
    public function retrieveList(array $options = [])
    {
        $perPage = isset($options['per_page']) ? (int) $options['per_page'] : 20;
        $orderBy = isset($options['order_by']) && in_array($options['order_by'], $this->sortable) ? $options['order_by'] : 'created_at';
        $order = isset($options['order']) && in_array($options['order'], ['asc', 'desc']) ? $options['order'] : 'desc';
        $query = $this->query()
            ->with([
                'owner',
                'updater',
            ])
            ->orderBy($orderBy, $order);

        if ($perPage == -1) {
            return $query->get();
        }

        return $query->paginate($perPage);
    }

    /**
     * @return mixed
     */
    public function getForDataTable()
    {


        $show =  $this->query()
            ->leftjoin('users', 'users.id', '=', 'photo_events.created_by')
            ->select([
                'photo_events.id',
                'photo_events.title',
                'photo_events.status',
                'users.first_name as created_by',
                'photo_events.created_at',
            ]);

            
    }

    /**
     * @param array $input
     *
     * @throws \App\Exceptions\GeneralException
     *
     * @return bool
     */
    public function create(array $input)    {

        
        if ($this->query()->where('event_title', $input['event_title'])->first()) {
            throw new GeneralException(__('exceptions.backend.photo-events.already_exists'));
        }
        
        $input['created_by'] = auth()->user()->id;
        $input['status'] = $input['status'] ?? 0;

        if ($photoEvent = PhotoEvent::create($input)) {
            event(new PhotoEventCreated($photoEvent));

            return $photoEvent->fresh();
        }

        throw new GeneralException(__('exceptions.backend.photo-events.create_error'));
    }

    /**
     * Update Page.
     *
     * @param \App\Models\Page $photoEvent
     * @param array $input
     */
    public function update(PhotoEvent $photoEvent, array $input)
    {
        if ($this->query()->where('event_title', $input['event_title'])->where('id', '!=', $photoEvent->id)->first()) {
            throw new GeneralException(__('exceptions.backend.photo-events.already_exists'));
        }

        
        $input['updated_by'] = auth()->user()->id;
        $input['status'] = $input['status'] ?? 0;

        if ($photoEvent->update($input)) {
            event(new PhotoEventUpdated($photoEvent));

            return $photoEvent;
        }

        throw new GeneralException(
            __('exceptions.backend.photo-events.update_error')
        );
    }

    /**
     * @param \App\Models\PhotoEvent $PhotoEvent
     *
     * @throws GeneralException
     *
     * @return bool
     */
    public function delete(PhotoEvent $photoEvent)
    {
        if ($photoEvent->delete()) {
            event(new PhotoEventDeleted($photoEvent));

            return true;
        }

        throw new GeneralException(__('exceptions.backend.photo-events.delete_error'));
    }
}
