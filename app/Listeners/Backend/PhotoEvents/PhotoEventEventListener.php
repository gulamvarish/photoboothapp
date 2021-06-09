<?php

namespace App\Listeners\Backend\PhotoEvents;

/**
 * Class PhotoEventEventListener.
 */
class PhotoEventEventListener
{
    /**
     * @var string
     */
    private $history_slug = 'PhotoEvent';

    /**
     * @param $event
     */
    public function onCreated($event)
    {
        history()->withType($this->history_slug)
            ->withEntity($event->photoEvent->id)
            ->withText('trans("history.backend.photo-events.created") <strong>'.$event->photoEvent->title.'</strong>')
            ->withIcon('plus')
            ->withClass('bg-green')
            ->log();
    }

    /**
     * @param $event
     */
    public function onUpdated($event)
    {
        history()->withType($this->history_slug)
            ->withEntity($event->photoEvent->id)
            ->withText('trans("history.backend.photo-events.updated") <strong>'.$event->photoEvent->title.'</strong>')
            ->withIcon('save')
            ->withClass('bg-aqua')
            ->log();
    }

    /**
     * @param $event
     */
    public function onDeleted($event)
    {
        history()->withType($this->history_slug)
            ->withEntity($event->photoEvent->id)
            ->withText('trans("history.backend.photo-events.deleted") <strong>'.$event->photoEvent->title.'</strong>')
            ->withIcon('trash')
            ->withClass('bg-maroon')
            ->log();
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            \App\Events\Backend\PhotoEvents\PhotoEventCreated::class,
            'App\Listeners\Backend\PhotoEvents\PhotoEventEventListener@onCreated'
        );

        $events->listen(
            \App\Events\Backend\PhotoEvents\PhotoEventUpdated::class,
            'App\Listeners\Backend\PhotoEvents\PhotoEventEventListener@onUpdated'
        );

        $events->listen(
            \App\Events\Backend\PhotoEvents\PhotoEventDeleted::class,
            'App\Listeners\Backend\PhotoEvents\PhotoEventEventListener@onDeleted'
        );
    }
}
