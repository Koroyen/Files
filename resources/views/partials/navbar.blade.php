<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid px-3">
        <a class="navbar-brand" href="{{ url('/home') }}">Jacx of Heartzxc</a>
        <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button> -->

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                </li>
                @else
                <!-- Dropdown for authenticated user -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        {{ Auth::user()->name ?? Auth::user()->last_name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end bg-dark">
                        <li>
                            <a class="dropdown-item text-white hover-dark" href="{{ route('dashboard') }}">
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item text-white hover-dark" href="{{ url('/files/create') }}">
                                Upload File
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item text-white hover-dark" href="{{ route('my.uploads') }}">
                                My Uploads
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider bg-secondary">
                        </li>
                        <li>
                            <a class="dropdown-item text-danger hover-dark" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>