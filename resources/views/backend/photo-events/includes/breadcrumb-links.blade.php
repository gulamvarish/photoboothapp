<li class="breadcrumb-menu">
    <div class="btn-group" role="group" aria-label="Button group">
        <div class="dropdown">
            <a class="btn dropdown-toggle" href="#" role="button" id="breadcrumb-dropdown-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ __('labels.backend.access.photo-events.all') }}</a>

            <div class="dropdown-menu" aria-labelledby="breadcrumb-dropdown-1">
                <a class="dropdown-item" href="{{ route('admin.photo-events.index') }}">{{ trans('labels.backend.access.photo-events.all') }}</a>
                <a class="dropdown-item" href="{{ route('admin.photo-events.create') }}">{{ trans('labels.backend.access.photo-events.create') }}</a>
               
            </div>
        </div><!--dropdown-->

        <!--<a class="btn" href="#">Static Link</a>-->
    </div><!--btn-group-->
</li>