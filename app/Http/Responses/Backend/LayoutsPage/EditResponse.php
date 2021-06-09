<?php

namespace App\Http\Responses\Backend\LayoutsPage;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var \App\Models\Page\Page
     */
    protected $layoutsPage;

    /**
     * @param \App\Models\Page\Page $page
     */
    public function __construct($layoutsPage)
    {


        $this->layoutsPage = $layoutsPage;
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
        return view('backend.layoutspages.edit')
            ->withPage($this->layoutsPage);
        
    }
}
