<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            @php
                $mnth = date('m');
                $yr = date('Y');
            @endphp
            {{--            {{ dd(getUserPermissions()) }}--}}
            <ul>
                <li><a href="{{ route('dashboard') }}"><img src="{{ asset('assets/img/icons/dashboard.svg') }}" alt="img"><span> Dashboard</span></a></li>
                <li class="submenu">
                    <a href="javascript:void(0);"><i class="fa fa-tv"></i><span> LiveStream</span><span class="menu-arrow"></span></a>
                    <ul>
                        @if((in_array('read-livestream', getUserPermissions())))
                            <li><a href="{{route('livestream.index') }}">Listed Stream</a></li>
                        @endif
                        @if((in_array('read-booked-livestream', getUserPermissions())))
                            <li><a href="{{route('livestream.booked') }}">Booked LiveStream </a></li>
                        @endif
                        @if((in_array('read-evaluation-livestream', getUserPermissions())))
                            <li><a href="{{route('livestream.evolution') }}">Evaluation LiveStream</a></li>
                        @endif
                        @if((in_array('create-evaluation-livestream', getUserPermissions())))
                            <li><a href="{{route('livestream.evaluation_form') }}">Evaluation Form</a></li>
                        @endif
                        @if((in_array('read-assessment-livestream', getUserPermissions())))
                            <li><a href="{{route('livestream.assessment') }}">Assessment LiveStream</a></li>
                        @endif
                        @if((in_array('read-certificate-livestream', getUserPermissions())))
                            <li><a href="{{route('livestream.certificate') }}">Certificate LiveStream</a></li>
                        @endif
                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><i class="fa fa-clipboard"></i><span> Webinar</span><span class="menu-arrow"></span></a>
                    <ul>
                        @if((in_array('read-webinar', getUserPermissions())))
                            <li><a href="{{route('webinar.index') }}">All Webinar</a></li>
                        @endif
                        @if((in_array('read-booked-webinar', getUserPermissions())))
                            <li><a href="{{route('webinar.booked') }}">Booked Webinar </a></li>
                        @endif
                        @if((in_array('read-evaluation-webinar', getUserPermissions())))
                            <li><a href="{{route('webinar.evolution') }}">Evaluation Webinar</a></li>
                        @endif
                        @if((in_array('create-evaluation-webinar', getUserPermissions())))
                        <li><a href="{{route('webinar.evaluation_form') }}">Evaluation Form</a></li>
                        @endif
                        @if((in_array('read-assessment-webinar', getUserPermissions())))
                            <li><a href="{{route('webinar.assessment') }}">Assessment Webinar</a></li>
                        @endif
                        @if((in_array('read-certificate-webinar', getUserPermissions())))
                            <li><a href="{{route('webinar.certificate') }}">Certificate Webinar</a></li>
                        @endif
                    </ul>
                </li>
                <li><a href="{{ route('services.index') }}"><img src="{{ asset('assets/img/icons/settings.svg') }}" alt="img"><span> Services</span></a></li>

                <li><a href="{{ route('services.form_one') }}"><img src="{{ asset('assets/img/icons/settings.svg') }}" alt="img"><span> Form One</span></a></li>
                <li><a href="{{ route('services.form_two') }}"><img src="{{ asset('assets/img/icons/settings.svg') }}" alt="img"><span> Form Two</span></a></li>
                <li><a href="{{ route('services.form_three') }}"><img src="{{ asset('assets/img/icons/settings.svg') }}" alt="img"><span> Form Three</span></a></li>
                <li><a href="{{ route('services.form_four') }}"><img src="{{ asset('assets/img/icons/settings.svg') }}" alt="img"><span> Form Four</span></a></li>

                @if((in_array('read-user', getUserPermissions())))
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/users1.svg') }}" alt="img"><span> People</span>
                        <span class="menu-arrow"></span></a>
                    <ul>
                        @if((in_array('read-role', getUserPermissions())))
                            <li><a href="{{route('role.index') }}">Role List </a></li>
                        @endif
                        @if((in_array('read-user', getUserPermissions())))
                            <li><a href="{{route('user.index') }}">User List</a></li>
                        @endif
                    </ul>
                </li>
                @endif
                <li><a href="{{ route('clear-cache') }}"><img src="{{ asset('assets/img/icons/settings.svg') }}" alt="img"><span> Cache Clear</span></a></li>
            </ul>
        </div>
    </div>
</div>
