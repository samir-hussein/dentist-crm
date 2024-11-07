<aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
    <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
        <i class="fe fe-x"><span class="sr-only"></span></i>
    </a>
    <nav class="vertnav navbar navbar-light">
        <!-- nav bar -->
        <div class="w-100 mb-4 d-flex">
            <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="{{ route('home') }}">
                <svg version="1.1" id="logo" class="navbar-brand-img brand-sm" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 120 120"
                    xml:space="preserve">
                    <g>
                        <polygon class="st0" points="78,105 15,105 24,87 87,87 	" />
                        <polygon class="st0" points="96,69 33,69 42,51 105,51 	" />
                        <polygon class="st0" points="78,33 15,33 24,15 87,15 	" />
                    </g>
                </svg>
            </a>
        </div>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link {{ $currentRouteName == 'home' ? 'active-link' : '' }}" href="{{ route('home') }}">
                    <i class="fe fe-home fe-16"></i>
                    <span class="ml-3 item-text">Home Page</span>
                </a>
            </li>

            <li class="nav-item w-100">
                <a class="nav-link {{ strpos($currentRouteName, 'appointments') !== false ? 'active-link' : '' }}"
                    href="{{ route('appointments.index') }}">
                    <i class="fe fe-calendar fe-16"></i>
                    <span class="ml-3 item-text">Appointments</span>
                </a>
            </li>

            <li class="nav-item w-100">
                <a class="nav-link {{ strpos($currentRouteName, 'patients') !== false ? 'active-link' : '' }}"
                    href="{{ route('patients.index') }}">
                    <i class="fe fe-users fe-16"></i>
                    <span class="ml-3 item-text">Patients</span>
                </a>
            </li>

            @if (auth()->user()->is_admin || auth()->user()->is_doctor)
                <li class="nav-item w-100">
                    <a class="nav-link {{ strpos($currentRouteName, 'prescription') !== false ? 'active-link' : '' }}"
                        href="{{ route('prescription.index') }}">
                        <i class="fe fe-pen-tool fe-16"></i>
                        <span class="ml-3 item-text">Prescription</span>
                    </a>
                </li>

                <li class="nav-item w-100">
                    <a class="nav-link {{ strpos($currentRouteName, 'tax') !== false ? 'active-link' : '' }}"
                        href="{{ route('invoices.tax.index') }}">
                        <i class="fe fe-file-text fe-16"></i>
                        <span class="ml-3 item-text">Tax Report</span>
                    </a>
                </li>

                <li class="nav-item w-100">
                    <a class="nav-link {{ strpos($currentRouteName, 'invoices.index') !== false ? 'active-link' : '' }}"
                        href="{{ route('invoices.index') }}">
                        <i class="fe fe-file fe-16"></i>
                        <span class="ml-3 item-text">Invoices Report</span>
                    </a>
                </li>

                {{-- <li class="nav-item w-100">
                <a class="nav-link {{ strpos($currentRouteName, 'lab-orders') !== false ? 'active-link' : '' }}"
                    href="{{ route('lab-orders.index') }}">
                    <i class="fe fe-layers fe-16"></i>
                    <span class="ml-3 item-text">Lab Orders</span>
                </a>
            </li> --}}

                <li class="nav-item w-100">
                    <a class="nav-link @yield('settings-active', $currentRouteName == 'settings' ? 'active-link' : '')" href="{{ route('settings') }}">
                        <i class="fe fe-settings fe-16"></i>
                        <span class="ml-3 item-text">Settings</span>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
</aside>
