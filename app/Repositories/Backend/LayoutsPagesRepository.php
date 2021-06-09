<?php

namespace App\Repositories\Backend;

use App\Events\Backend\LayoutsPages\LayoutsPageCreated;
use App\Events\Backend\LayoutsPages\LayoutsPageDeleted;
use App\Events\Backend\LayoutsPages\LayoutsPageUpdated;
use App\Exceptions\GeneralException;
use App\Models\LayoutsPage;
use App\Repositories\BaseRepository;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use DB;
use Auth;

class LayoutsPagesRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = LayoutsPage::class;

    /**
     * Sortable.
     *
     * @var array
     */
    private $sortable = [
        'id',
        'layout_title',
        'layout_image',       
        'status',
        'created_at',
        'updated_at',
    ];


    /**
     * Storage Class Object.
     *
     * @var \Illuminate\Support\Facades\Storage
     */
    protected $storage;

    public function __construct()
    {
        $this->upload_path = 'img'.DIRECTORY_SEPARATOR.'layout'.DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('public');
    }


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
        return $this->query()
            ->leftjoin('users', 'users.id', '=', 'layouts_pages.created_by')
            ->select([
                'layouts_pages.id',
                'layouts_pages.layout_title',
                'layouts_pages.status',
                'users.first_name as created_by',
                'layouts_pages.created_at',
            ]);
    }

    /**
     * @param array $input
     *
     * @throws \App\Exceptions\GeneralException
     *
     * @return bool
     */


     public function uploadImage($input)
    {
        if (isset($input['layout_image']) && ! empty($input['layout_image'])) {
            $avatar = $input['layout_image'];
            $fileName = time().$avatar->getClientOriginalName();

           //$this->storage->put($this->upload_path.$fileName, file_get_contents($avatar->getRealPath()));
            $path        = public_path().'/storage/img/layout/';
            $data        = $avatar->move($path, $fileName);

          
            $input = array_merge($input, ['layout_image' => $fileName]);
        }

        return $input;
    }
    public function create(array $input)
    {


        if ($this->query()->where('layout_title', $input['layout_title'])->first()) {
            throw new GeneralException(__('exceptions.backend.layoutspages.already_exists'));
        }

        
        $input['created_by'] = auth()->user()->id;
        $input['status'] = $input['status'] ?? 0;
        $input = $this->uploadImage($input);
        

        if ($layoutsPage = LayoutsPage::create($input)) {
            event(new LayoutsPageCreated($layoutsPage));

            return $layoutsPage->fresh();
        }

        throw new GeneralException(__('exceptions.backend.layoutspages.create_error'));
    }

    /**
     * Update LayoutsPage.
     *
     * @param \App\Models\LayoutsPage $page
     * @param array $input
     */
    public function update(LayoutsPage $layoutsPage, array $input)
    {
        if ($this->query()->where('layout_title', $input['layout_title'])->where('id', '!=', $layoutsPage->id)->first()) {
            throw new GeneralException(__('exceptions.backend.layoutspages.already_exists'));
        }

        
        $input['updated_by'] = auth()->user()->id;
        $input['status'] = $input['status'] ?? 0;

        if ($layout->update($input)) {
            event(new LayoutsPageUpdated($layout));

            return $layout;
        }

        throw new GeneralException(
            __('exceptions.backend.layoutspages.update_error')
        );
    }

    /**
     * @param \App\Models\Page $page
     *
     * @throws GeneralException
     *
     * @return bool
     */
    public function delete(LayoutsPage $layoutsPage)
    {
        if ($layoutsPage->delete()) {
            event(new LayoutsPageDeleted($layoutsPage));

            return true;
        }

        throw new GeneralException(__('exceptions.backend.layoutspages.delete_error'));
    }
}
