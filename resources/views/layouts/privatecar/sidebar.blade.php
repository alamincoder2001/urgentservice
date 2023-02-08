<div class="page-sidebar">
    <a class="d-flex align-items-center" href="{{route('privatecar.dashboard')}}">
        <img src="{{asset($setting->logo)}}" alt="{{$setting->name}}" style="width: 100%; height:56px;">
    </a>
    <div class="page-sidebar-inner">
        <div class="page-sidebar-menu">
            <ul class="accordion-menu">
                <li class="{{Route::is('privatecar.dashboard')?'active-page':''}}">
                    <a href="{{url('privatecar/dashboard')}}">
                        <i class="menu-icon fas fa-ambulance"></i><span>Privatecar Dashboard</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>