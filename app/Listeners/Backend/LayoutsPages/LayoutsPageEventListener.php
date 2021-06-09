<?php

namespace App\Listeners\Backend\LayoutsPages;

/**
 * Class PageEventListener.
 */
class LayoutsPageEventListener
{
    /**
     * @var string
     */
    private $history_slug = 'LayoutsPage';

    /**
     * @param $event
     */
    public function onCreated($event)
    {
        history()->withType($this->history_slug)
            ->withEntity($event->page->id)
            ->withText('trans("history.backend.layoutspages.created") <strong>'.$event->page->title.'</strong>')
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
            ->withEntity($event->page->id)
            ->withText('trans("history.backend.layoutspages.updated") <strong>'.$event->page->title.'</strong>')
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
            ->withEntity($event->page->id)
            ->withText('trans("history.backend.layoutspages.deleted") <strong>'.$event->page->title.'</strong>')
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
            \App\Events\Backend\LayoutsPages\LayoutsPageCreated::class,
            'App\Listeners\Backend\LayoutsPages\LayoutsPageEventListener@onCreated'
        );

        $events->listen(
            \App\Events\Backend\LayoutsPages\LayoutsPageUpdated::class,
            'App\Listeners\Backend\LayoutsPages\LayoutsPageEventListener@onUpdated'
        );

        $events->listen(
            \App\Events\Backend\LayoutsPages\LayoutsPageDeleted::class,
            'App\Listeners\Backend\LayoutsPages\LayoutsPageEventListener@onDeleted'
        );
    }
}
