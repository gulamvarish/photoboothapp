<?php

namespace App\Events\Backend\LayoutsPages;

use Illuminate\Queue\SerializesModels;

/**
 * Class PageUpdated.
 */
class LayoutsPageUpdated
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
