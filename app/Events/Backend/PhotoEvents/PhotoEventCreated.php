<?php

namespace App\Events\Backend\PhotoEvents;

use Illuminate\Queue\SerializesModels;

/**
 * Class PhotoEventCreated.
 */
class PhotoEventCreated
{
    use SerializesModels;

    /**
     * @var
     */
    public $photoEvents;

    /**
     * @param $photoEvents
     */
    public function __construct($photoEvents)
    {
        $this->photoEvents = $photoEvents;
    }
}
