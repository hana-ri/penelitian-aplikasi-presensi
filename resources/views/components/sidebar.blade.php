<aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
            aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark">
            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('assets/images/logo_upi.png') }}" width="165" height="48" alt="logo-upi"
                    class="navbar-brand-image">
                <img src="{{ asset('assets/images/logo_tekkom_2.png') }}" width="165" height="48"
                    alt="logo-tekkom" class="navbar-brand-image">
            </a>
        </h1>
        <div class="navbar-nav flex-row d-lg-none">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                    aria-label="Open user menu">
                    <span class="avatar avatar-sm"
                        style="background-image: url({{ asset('assets/images/002m.jpg') }})"></span>
                    <div class="d-none d-xl-block ps-2">
                        <div>{{ auth()->user()->getFullNameAttribute() }}</div>
                        <div class="mt-1 small text-secondary">{{ auth()->user()->username }}</div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a href="#" class="dropdown-item">Profile</a>
                    <div class="dropdown-divider"></div>
                    <div class="d-md-flex d-lg-none">
                        <a href="#" class="dropdown-item hide-theme-dark toggleTheme" title="Enable dark mode"
                            data-bs-toggle="tooltip" data-bs-placement="bottom">
                            <span class="me-1">Dark Mode</span> <i class="ti ti-moon fs-5"></i>
                        </a>
                        <a href="#" class="dropdown-item hide-theme-light toggleTheme" title="Enable light mode"
                            data-bs-toggle="tooltip" data-bs-placement="bottom">
                            <span class="me-1">Light Mode</span> <i class="ti ti-sun fs-5"></i>
                        </a>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item">Logout</a>
                </div>
            </div>
        </div>
        <div class="collapse navbar-collapse" id="sidebar-menu">
            <ul class="navbar-nav pt-lg-3">
                @if (auth()->user()->roles->contains('shortname', 'manager'))
                    <li class="nav-item {{ request()->route()->named('dashboard') ? 'active' : '' }}">
                        <a class="nav-link {{ request()->route()->named('dashboard') ? 'active' : '' }}"
                            href="{{ route('dashboard') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <i class="ti ti-home fs-2"></i>
                            </span>
                            <span class="nav-link-title"> Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->route()->named('admin.class.index') ? 'active' : '' }}">
                        <a class="nav-link {{ request()->route()->named('admin.class.index') ? 'active' : '' }}"
                            href="{{ route('admin.class.index') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <i class="ti ti-school fs-2"></i>
                            </span>
                            <span class="nav-link-title"> Kelas</span>
                        </a>
                    </li>
                @else
                    <li class="nav-item {{ request()->route()->named('dashboard') ? 'active' : '' }}">
                        <a class="nav-link {{ request()->route()->named('dashboard') ? 'active' : '' }}"
                            href="{{ route('dashboard') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <i class="ti ti-home fs-2"></i>
                            </span>
                            <span class="nav-link-title"> Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->route()->named('user.class.index') ? 'active' : '' }}">
                        <a class="nav-link {{ request()->route()->named('user.class.index') ? 'active' : '' }}"
                            href="{{ route('user.class.index') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <i class="ti ti-ad-2 fs-2"></i>
                            </span>
                            <span class="nav-link-title"> Presensi</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->route()->named('user.face.register') ? 'active' : '' }}">
                        <a class="nav-link {{ request()->route()->named('user.face.register') ? 'active' : '' }}"
                            href="{{ route('user.face.register') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <i class="ti ti-user fs-2"></i>
                            </span>
                            <span class="nav-link-title">Register wajah</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</aside>
