<nav class="navbar navbar-expand-lg navbar-light bg-white flex-row border-bottom shadow">
    <div class="container-fluid">
        <a class="navbar-brand mx-lg-1 mr-0" href="{{ route('home') }}">
            <svg version="1.1" id="logo" class="navbar-brand-img brand-sm" xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 120 120" xml:space="preserve">
                <g>
                    <polygon class="st0" points="78,105 15,105 24,87 87,87 	" />
                    <polygon class="st0" points="96,69 33,69 42,51 105,51 	" />
                    <polygon class="st0" points="78,33 15,33 24,15 87,15 	" />
                </g>
            </svg>
        </a>
        <button class="navbar-toggler mt-2 mr-auto toggle-sidebar text-muted">
            <i class="fe fe-menu navbar-toggler-icon"></i>
        </button>
        <div class="navbar-slide bg-white ml-lg-4" id="navbarSupportedContent">
            <a href="#" class="btn toggle-sidebar d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
                <i class="fe fe-x"><span class="sr-only"></span></i>
            </a>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link {{ $currentRouteName == 'home' ? 'active-link' : '' }}"
                        href="{{ route('home') }}">
                        <span class="ml-lg-2">Home</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ strpos($currentRouteName, 'doctors') !== false ? 'active-link' : '' }}"
                        href="{{ route('doctors.index') }}">
                        <span class="ml-lg-2">Doctors</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ strpos($currentRouteName, 'patients') !== false ? 'active-link' : '' }}"
                        href="{{ route('patients.index') }}">
                        <span class="ml-lg-2">Patients</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $currentRouteName == 'schedule.index' ? 'active-link' : '' }}"
                        href="{{ route('doctors.index') }}">
                        <span class="ml-lg-2">Schedule</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ strpos($currentRouteName, 'appointments') !== false ? 'active-link' : '' }}"
                        href="{{ route('appointments.index') }}">
                        <span class="ml-lg-2">Appointment List</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ strpos($currentRouteName, 'diagnosis') !== false ? 'active-link' : '' }}"
                        href="{{ route('diagnosis.index') }}">
                        <span class="ml-lg-2">Diagnosis</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ strpos($currentRouteName, 'treatment-types') !== false ? 'active-link' : '' }}"
                        href="{{ route('treatment-types.index') }}">
                        <span class="ml-lg-2">Treatment Type</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ strpos($currentRouteName, 'services') !== false ? 'active-link' : '' }}"
                        href="{{ route('services.index') }}">
                        <span class="ml-lg-2">Services</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ strpos($currentRouteName, 'labs') !== false ? 'active-link' : '' }}"
                        href="{{ route('labs.index') }}">
                        <span class="ml-lg-2">Labs</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ strpos($currentRouteName, 'staff') !== false ? 'active-link' : '' }}"
                        href="{{ route('staff.index') }}">
                        <span class="ml-lg-2">Staff</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ strpos($currentRouteName, 'admins') !== false ? 'active-link' : '' }}"
                        href="{{ route('admins.index') }}">
                        <span class="ml-lg-2">Admins</span>
                    </a>
                </li>
            </ul>
        </div>

        <ul class="navbar-nav d-flex flex-row">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-muted pr-0" href="#" id="navbarDropdownMenuLink"
                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="avatar avatar-sm mt-2">
                        <img src="{{ auth()->user()->getFirstMediaUrl('avatar') ?: env('APP_URL') . '/images/avatar.jpg' }}"
                            alt="..." class="avatar-img rounded-circle">
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="{{ route('user.profile') }}">Profile</a>
                    <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
