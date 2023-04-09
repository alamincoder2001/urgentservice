<div class="page-sidebar">
    <a class="logo-box d-flex align-items-center" href="{{url('doctor/dashboard')}}" style="padding:10px 10px 10px 10px !important;">
        <img src="{{asset($setting->logo)}}" alt="{{$setting->name}}" style="width:80%;height:60px;">
    </a>
    <div class="page-sidebar-inner">
        <div class="page-sidebar-menu">
            <ul class="accordion-menu">
                <li class="{{Route::is('doctor.dashboard')?'active-page':''}}">
                    <a href="{{url('doctor/dashboard')}}">
                        <i class="menu-icon fas fa-user-md"></i><span>Doctor Dashboard</span>
                    </a>
                </li>
                <li class="{{Route::is('doctor.appointment')?'active-page':''}}">
                    <a href="{{route('doctor.appointment')}}">
                        <i class="menu-icon fa fa-user-plus"></i><span>Patient List</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>