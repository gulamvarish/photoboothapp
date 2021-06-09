<?php

namespace App\Events\Backend\LayoutsPages;

use Illuminate\Queue\SerializesModels;

/**
 * Class PageDeleted.
 */
class LayoutsPageDeleted
{
    use SerializesModels;

    /**
     * @var
     */
    public $page;

    /**
     * @param $page
     */
    public function __construct($page)
    {
        $this->page = $page;
    }
}
