<?php

namespace App\Events\Backend\PhotoEvents;

use Illuminate\Queue\SerializesModels;

/**
 * Class PhotoEventDeleted.
 */
class PhotoEventDeleted
{
    use SerializesModels;

    /**
     * @var
     */
    public $photoEvents;

    /**
     * @param $page
     */
    public function __construct($photoEvents)
    {
        $this->photoEvents = $photoEvents;
    }
}
