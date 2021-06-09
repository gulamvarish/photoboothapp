<?php

namespace App\Http\Responses\Backend\PhotoEvent;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var \App\Models\Page\Page
     */
    protected $photoEvent;

    /**
     * @param \App\Models\Page\Page $photoEvent
     */
    public function __construct($photoEvent)
    {
        $this->photoEvent = $photoEvent;
    }

    /**
     * toReponse.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function toResponse($request)
    {
        return view('backend.photo-events.edit')
            ->withPage($this->photoEvent);
    }
}
