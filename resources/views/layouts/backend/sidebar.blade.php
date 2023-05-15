@php
$access = App\Models\UserAccess::where('user_id', Auth::guard('admin')->user()->id)
->pluck('permissions')
->toArray();
@endphp

<div class="page-sidebar">
    <a class="d-flex align-items-center" href="{{route('admin.dashboard')}}">
        <img src="{{asset($setting->logo)}}" alt="{{$setting->name}}" style="height:56px;width:100%;">
    </a>
    <div class="page-sidebar-inner">
        <div class="page-sidebar-menu">
            <ul class="accordion-menu">
                @if(in_array("dashboard.index", $access))
                <li class="{{Route::is('admin.dashboard')?'active-page':''}}">
                    <a href="{{url('admin/dashboard')}}">
                        <i class="menu-icon icon-home4"></i><span>Dashboard</span>
                    </a>
                </li>
                @endif
                @if(in_array("doctor.index", $access) || in_array("doctor.create", $access))
                <li class="{{Route::is('admin.doctor.index')||Route::is('admin.doctor.create')||Route::is('admin.doctor.edit')?'active-page':''}}">
                    <a href="#!" class="{{Route::is('admin.doctor.index')||Route::is('admin.doctor.create')||Route::is('admin.doctor.edit')?'active':''}}">
                        <i class="menu-icon fas fa-user-md"></i><span>Doctor</span><i class="accordion-icon fa fa-angle-left"></i>
                    </a>
                    <ul class="{{Route::is('admin.doctor.index')||Route::is('admin.doctor.create')||Route::is('admin.doctor.edit')?'sub-menu':''}}">
                        @if(in_array("doctor.index", $access))
                        <li class="{{Route::is('admin.doctor.index')?'active':''}}"><a href="{{route('admin.doctor.index')}}">Manage Doctor</a></li>
                        @endif
                        @if(in_array("doctor.create", $access))
                        <li class="{{Route::is('admin.doctor.create')||Route::is('admin.doctor.edit')?'active':''}}"><a href="{{route('admin.doctor.create')}}">Create Doctor</a></li>
                        @endif
                    </ul>
                </li>
                @endif
                @if(in_array("hospital.index", $access) || in_array("hospital.create", $access))
                <li class="{{Route::is('admin.hospital.index')||Route::is('admin.hospital.create')||Route::is('admin.hospital.edit')?'active-page':''}}">
                    <a href="#!" class="{{Route::is('admin.hospital.index')||Route::is('admin.hospital.create')||Route::is('admin.hospital.edit')?'active':''}}">
                        <i class="menu-icon fas fa-hospital"></i><span>Hopital</span><i class="accordion-icon fa fa-angle-left"></i>
                    </a>
                    <ul class="{{Route::is('admin.hospital.index')||Route::is('admin.hospital.create')||Route::is('admin.hospital.edit')?'sub-menu':''}}">
                        @if(in_array("hospital.index", $access))
                        <li class="{{Route::is('admin.hospital.index')?'active':''}}"><a href="{{route('admin.hospital.index')}}">Manage Hospital</a></li>
                        @endif
                        @if(in_array("hospital.create", $access))
                        <li class="{{Route::is('admin.hospital.create')||Route::is('admin.hospital.edit')?'active':''}}"><a href="{{route('admin.hospital.create')}}">Create Hospital</a></li>
                        @endif
                    </ul>
                </li>
                @endif
                @if(in_array("diagnostic.index", $access) || in_array("diagnostic.create", $access))
                <li class="{{Route::is('admin.diagnostic.index')||Route::is('admin.diagnostic.create')||Route::is('admin.diagnostic.edit')?'active-page':''}}">
                    <a href="#!" class="{{Route::is('admin.diagnostic.index')||Route::is('admin.diagnostic.create')||Route::is('admin.diagnostic.edit')?'active':''}}">
                        <i class="menu-icon fa fa-plus-square"></i><span>Diagnostic</span><i class="accordion-icon fa fa-angle-left"></i>
                    </a>
                    <ul class="{{Route::is('admin.diagnostic.index')||Route::is('admin.diagnostic.create')||Route::is('admin.diagnostic.edit')?'sub-menu':''}}">
                        @if(in_array("diagnostic.index", $access))
                        <li class="{{Route::is('admin.diagnostic.index')?'active':''}}"><a href="{{route('admin.diagnostic.index')}}">Manage Diagnostic</a></li>
                        @endif
                        @if(in_array("diagnostic.create", $access))
                        <li class="{{Route::is('admin.diagnostic.create')||Route::is('admin.diagnostic.edit')?'active':''}}"><a href="{{route('admin.diagnostic.create')}}">Create Diagnostic</a></li>
                        @endif
                    </ul>
                </li>
                @endif
                @if(in_array("ambulance.index", $access) || in_array("ambulance.create", $access))
                <li class="{{Route::is('admin.ambulance.index')||Route::is('admin.ambulance.create')||Route::is('admin.ambulance.edit')?'active-page':''}}">
                    <a href="#!" class="{{Route::is('admin.ambulance.index')||Route::is('admin.ambulance.create')||Route::is('admin.ambulance.edit')?'active':''}}">
                        <i class="menu-icon fa fa-ambulance"></i><span>Ambulance</span><i class="accordion-icon fa fa-angle-left"></i>
                    </a>
                    <ul class="{{Route::is('admin.ambulance.index')||Route::is('admin.ambulance.create')||Route::is('admin.ambulance.edit')?'sub-menu':''}}">
                        @if(in_array("ambulance.index", $access))
                        <li class="{{Route::is('admin.ambulance.index')?'active':''}}"><a href="{{route('admin.ambulance.index')}}">Manage Ambulance</a></li>
                        @endif
                        @if(in_array("ambulance.create", $access))
                        <li class="{{Route::is('admin.ambulance.create')||Route::is('admin.ambulance.edit')?'active':''}}"><a href="{{route('admin.ambulance.create')}}">Create Ambulance</a></li>
                        @endif
                    </ul>
                </li>
                @endif
                @if(in_array("privatecar.index", $access) || in_array("privatecar.create", $access))
                <li class="{{Route::is('admin.privatecar.index')||Route::is('admin.privatecar.create')||Route::is('admin.privatecar.edit')?'active-page':''}}">
                    <a href="#!" class="{{Route::is('admin.privatecar.index')||Route::is('admin.privatecar.create')||Route::is('admin.privatecar.edit')?'active':''}}">
                        <i class="menu-icon fa fa-car"></i><span>Privatecar</span><i class="accordion-icon fa fa-angle-left"></i>
                    </a>
                    <ul class="{{Route::is('admin.privatecar.index')||Route::is('admin.privatecar.create')||Route::is('admin.privatecar.edit')?'sub-menu':''}}">
                        @if(in_array("privatecar.index", $access))
                        <li class="{{Route::is('admin.privatecar.index')?'active':''}}"><a href="{{route('admin.privatecar.index')}}">Manage Privatecar</a></li>
                        @endif
                        @if(in_array("privatecar.index", $access))
                        <li class="{{Route::is('admin.privatecar.create')||Route::is('admin.privatecar.edit')?'active':''}}"><a href="{{route('admin.privatecar.create')}}">Create Privatecar</a></li>
                        @endif
                    </ul>
                </li>
                @endif
                <!-- @if(in_array("privatecar.index", $access) || in_array("privatecar.create", $access)) -->
                <li class="{{Route::is('admin.patient.notification')||Route::is('admin.ambulance.notification')||Route::is('admin.privatecar.notification')?'active-page':''}}">
                    <a href="#!" class="{{Route::is('admin.patient.notification')||Route::is('admin.ambulance.notification')||Route::is('admin.privatecar.notification')?'active':''}}">
                        <i class="menu-icon fa fa-bell"></i><span>Notification</span><i class="accordion-icon fa fa-angle-left"></i>
                    </a>
                    <ul class="{{Route::is('admin.patient.notification')||Route::is('admin.ambulance.notification')||Route::is('admin.privatecar.notification')?'sub-menu':''}}">
                        <li class="{{Route::is('admin.patient.notification')?'active':''}}"><a href="{{route('admin.patient.notification')}}">Patient List</a></li>
                        <li class="{{Route::is('admin.ambulance.notification')?'active':''}}"><a href="{{route('admin.ambulance.notification')}}">Hire Ambulance</a></li>
                        <li class="{{Route::is('admin.privatecar.notification')?'active':''}}"><a href="{{route('admin.privatecar.notification')}}">Hire Privatecar</a></li>
                    </ul>
                </li>
                <!-- @endif -->
                @if(in_array("department.index", $access) || in_array("department.create", $access) || in_array("department.edit", $access) || in_array("department.destroy", $access))
                <li class="{{Route::is('department.index')?'active-page':''}}">
                    <a href="{{route('department.index')}}">
                        <i class="menu-icon fa fa-list-alt"></i><span>Department Entry</span>
                    </a>
                </li>
                @endif
                @if(in_array("test.index", $access) || in_array("test.create", $access) || in_array("test.edit", $access) || in_array("test.destroy", $access))
                <li class="{{Route::is('test.index')?'active-page':''}}">
                    <a href="{{route('test.index')}}">
                        <i class="menu-icon fa fa-list-alt"></i><span>Test Entry</span>
                    </a>
                </li>
                @endif
                @if(in_array("investigation.index", $access) || in_array("investigation.create", $access) || in_array("investigation.edit", $access) || in_array("investigation.destroy", $access))
                <li class="{{Route::is('investigation.index')?'active-page':''}}">
                    <a href="{{route('investigation.index')}}">
                        <i class="menu-icon fa fa-list-alt"></i><span>Investigation Entry</span>
                    </a>
                </li>
                @endif
                @if(in_array("prescription.index", $access) || in_array("prescription.destroy", $access))
                <li class="{{Route::is('admin.prescription.index')?'active-page':''}}">
                    <a href="{{route('admin.prescription.index')}}">
                        <i class="menu-icon fa fa-list-alt"></i><span>Prescription List</span>
                    </a>
                </li>
                @endif
                @if(in_array("blood-donor.index", $access) || in_array("blood-donor.destroy", $access))
                <li class="{{Route::is('admin.blood.donor')?'active-page':''}}">
                    <a href="{{route('admin.blood.donor')}}" class="d-flex align-items-center">
                        <img src="{{asset('donor.png')}}" width="18" class="menu-icon"><span style="padding-top: 5px;padding-left: 8px;">Blood Donor List</span>
                    </a>
                </li>
                @endif
                @if(in_array("city.index", $access) || in_array("city.create", $access) || in_array("city.edit", $access) || in_array("city.destroy", $access))
                <li class="{{Route::is('city.index')?'active-page':''}}">
                    <a href="{{route('city.index')}}">
                        <i class="menu-icon fa fa-list-alt"></i><span>City Entry</span>
                    </a>
                </li>
                @endif
                @if(in_array("upazila.index", $access) || in_array("upazila.create", $access) || in_array("upazila.edit", $access) || in_array("upazila.destroy", $access))
                <li class="{{Route::is('upazila.index')?'active-page':''}}">
                    <a href="{{route('upazila.index')}}">
                        <i class="menu-icon fa fa-list-alt"></i><span>Upazila Entry</span>
                    </a>
                </li>
                @endif
                @if(in_array("slider.index", $access) || in_array("slider.create", $access) || in_array("slider.edit", $access) || in_array("slider.destroy", $access))
                <li class="{{Route::is('slider.index')?'active-page':''}}">
                    <a href="{{route('slider.index')}}">
                        <i class="menu-icon fa fa-list-alt"></i><span>Slider Entry</span>
                    </a>
                </li>
                @endif
                @if(in_array("partner.index", $access) || in_array("partner.create", $access) || in_array("partner.edit", $access) || in_array("partner.destroy", $access))
                <li class="{{Route::is('partner.index')?'active-page':''}}">
                    <a href="{{route('partner.index')}}">
                        <i class="menu-icon fas fa-handshake"></i><span>Corporate Partner Entry</span>
                    </a>
                </li>
                @endif
                @if(in_array("client-question.index", $access) || in_array("client-question.destroy", $access))
                <li class="{{Route::is('admin.contactcompany.index')?'active-page':''}}">
                    <a href="{{route('admin.contactcompany.index')}}">
                        <i class="menu-icon fa fa-question-circle"></i><span>Clients Question</span>
                    </a>
                </li>
                @endif
                <li class="menu-divider"></li>
                @if(in_array("user.index", $access) || in_array("user.create", $access) || in_array("user.edit", $access) || in_array("user.destroy", $access))
                <li class="{{Route::is('admin.user.create')?'active-page':''}}">
                    <a href="{{route('admin.user.create')}}">
                        <i class="menu-icon fa fa-user-plus"></i><span>User Entry</span>
                    </a>
                </li>
                @endif
                @if(in_array("setting.index", $access) || in_array("setting.edit", $access))
                <li class="{{Route::is('setting.index')?'active-page':''}}">
                    <a href="{{route('setting.index')}}">
                        <i class="menu-icon fas fa-cog"></i><span>Setting</span>
                    </a>
                </li>
                @endif
                @if(in_array("contact.index", $access) || in_array("contact.edit", $access))
                <li class="{{Route::is('admin.contact.index')?'active-page':''}}">
                    <a href="{{route('admin.contact.index')}}">
                        <i class="menu-icon fa fa-phone-square"></i><span>Contact Page Setting</span>
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>