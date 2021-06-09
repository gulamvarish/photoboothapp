<?php

namespace App\Events\Backend\PhotoEvents;

use Illuminate\Queue\SerializesModels;

/**
 * Class PhotoEventUpdated.
 */
class PhotoEventUpdated
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
