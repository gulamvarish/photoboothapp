<?php

namespace App\Events\Backend\LayoutsPages;

use Illuminate\Queue\SerializesModels;

/**
 * Class PageCreated.
 */
class LayoutsPageCreated
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
