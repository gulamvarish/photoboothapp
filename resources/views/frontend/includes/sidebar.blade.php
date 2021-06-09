
@if(session()->get('usertype')!=1)
@auth<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">
                @lang('menus.backend.sidebar.general')
            </li>
            <li class="nav-item">
                <a class="nav-link {{
                    active_class(Route::is('frontend.user.dashboard'))
                }}" href="{{ route('frontend.user.dashboard') }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    @lang('menus.backend.sidebar.dashboard')
                </a>
            </li>
           
           @if(session()->get('usertype')==3)
                <li class="divider"></li>

                <li class="nav-item">
                    <a class="nav-link active_class(Route::is('frontend.auth.collage'))
                }}"  href="{{ route('frontend.auth.collage') }}">
                        <i class="nav-icon fas fa-file"></i>
                      Collage
                    </a>
                </li>
            @endif
            @if(session()->get('usertype')==2)
                 <li class="nav-item">
                    <a class="nav-link active_class(Route::is('frontend.auth.eventowner'))
                }}"  href="{{ route('frontend.auth.eventowner') }}">
                        <i class="nav-icon fas fa-file"></i>
                      Event Owner
                    </a>
                </li>

                <li class="divider"></li>
                @endif
               
        </ul>
    </nav>

    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div><!--sidebar-->
@endauth
@endif
