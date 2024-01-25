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
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/users1.svg') }}" alt="img"><span> LiveStream</span><span class="menu-arrow"></span></a>
                    <ul>
                        @if((in_array('index-livestream', getUserPermissions())))
                            <li><a href="{{route('livestream.index') }}">Listed Stream</a></li>
                        @endif
                        @if((in_array('booked-livestream', getUserPermissions())))
                            <li><a href="{{route('livestream.booked') }}">Booked LiveStream </a></li>
                        @endif
                        @if((in_array('evolution-livestream', getUserPermissions())))
                            <li><a href="{{route('livestream.evolution') }}">Evaluation LiveStream</a></li>
                        @endif
                        <li><a href="{{route('livestream.evaluation_form') }}">Evaluation Form</a></li>
                        @if((in_array('test-livestream', getUserPermissions())))
                            <li><a href="{{route('livestream.assessment') }}">Assessment LiveStream</a></li>
                        @endif
                        @if((in_array('certificate-livestream', getUserPermissions())))
                            <li><a href="{{route('livestream.certificate') }}">Certificate LiveStream</a></li>
                        @endif
                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/users1.svg') }}" alt="img"><span> Webinar</span><span class="menu-arrow"></span></a>
                    <ul>
                        @if((in_array('index-webinar', getUserPermissions())))
                            <li><a href="{{route('webinar.index') }}">All Webinar</a></li>
                        @endif
                        @if((in_array('booked-webinar', getUserPermissions())))
                            <li><a href="{{route('webinar.booked') }}">Booked Webinar </a></li>
                        @endif
                        @if((in_array('evaluation-webinar', getUserPermissions())))
                            <li><a href="{{route('webinar.evolution') }}">Evaluation Webinar</a></li>
                        @endif
                        <li><a href="{{route('webinar.evaluation_form') }}">Evaluation Form</a></li>
                        
                        @if((in_array('test-webinar', getUserPermissions())))
                            <li><a href="{{route('webinar.assessment') }}">Assessment Webinar</a></li>
                        @endif
                        @if((in_array('certificate-webinar', getUserPermissions())))
                            <li><a href="{{route('webinar.certificate') }}">Certificate Webinar</a></li>
                        @endif
                    </ul>
                </li>

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
                <li><a href="{{ route('clear-cache') }}"><img src="{{ asset('assets/img/icons/settings.svg') }}" alt="img"><span> Cache Clear</span></a></li>
            </ul>
        </div>
    </div>
</div>
