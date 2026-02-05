<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, min-scale=1, max-scale=1, shrink-to-fit=no">
    <meta name="description" content="PublRealty Admin Panel">
    <meta name="author" content="John Publ">

    <title>PublRealty - Admin Panel</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/sp-1.0.1/datatables.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.css" rel="stylesheet">

    <!-- Filepond stylesheet -->
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">

    <!-- Icons -->
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>

    <link rel="stylesheet" href="/css/site.css" />
</head>

<body>
    <nav id="topbar" class="navbar navbar-dark bg-dark shadow fixed-top">
        <button id="buttonMenu" class="navbar-toggler">
            <span data-feather="menu" style="color: white;"></span>
        </button>
        <div class="navbar-brand p-0 mr-auto">
            <a>Real Estate</a>
        </div>

        <div class="navbar-expand">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link p-0 px-2" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <div id="content" class="d-flex">
        <div id="sidebar-wrapper" class="sidebar bg-light">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="/" class="nav-link {{ '/' == request()->path() ? 'active' : '' }}">
                        <span data-feather="grid"></span>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/properties" class="nav-link {{ 'properties' == request()->path() || Str::startsWith(request()->path(), 'properties/') ? 'active' : '' }}">
                        <span data-feather="home"></span>Property
                    </a>
                </li>

                @if (Auth::user()->is_admin)
                <li class="nav-item">
                    <a href="/property_categories" class="nav-link {{ 'property_categories' == request()->path() || Str::startsWith(request()->path(), 'property_categories/') ? 'active' : '' }}">
                        <span data-feather="layers"></span>Property Categories
                    </a>
                </li>
                @endif

                @if (Auth::user()->is_admin)
                <li class="nav-item">
                    <a href="/cities" class="nav-link {{ 'cities' == request()->path() || Str::startsWith(request()->path(), 'cities/') ? 'active' : '' }}">
                        <span data-feather="map-pin"></span>Cities
                    </a>
                </li>
                @endif

                @if (Auth::user()->is_admin)
                <li class="nav-item">
                    <a href="/news" class="nav-link {{ 'news' == request()->path() || Str::startsWith(request()->path(), 'news/') ? 'active' : '' }}">
                        <span data-feather="tv"></span>News
                    </a>
                </li>
                @endif

                @if (Auth::user()->is_admin)
                <li class="nav-item">
                    <a href="/news_categories" class="nav-link {{ 'news_categories' == request()->path() || Str::startsWith(request()->path(), 'news_categories/') ? 'active' : '' }}">
                        <span data-feather="umbrella"></span>News Categories
                    </a>
                </li>
                @endif

                @if (Auth::user()->is_admin)
                <li class="nav-item">
                    <a href="/users" class="nav-link {{ 'users' == request()->path() || Str::startsWith(request()->path(), 'users/') ? 'active' : '' }}">
                        <span data-feather="user"></span>Users
                    </a>
                </li>
                @endif

                <li class="nav-item">
                    <a href="/settings" class="nav-link {{ 'settings' == request()->path() ? 'active' : '' }}">
                        <span data-feather="settings"></span>Settings
                    </a>
                </li>
            </ul>
        </div>
        <div id="content-wrapper">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <!-- Datatables -->
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/sp-1.0.1/datatables.min.js"></script>

    <!-- Summernote -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.js"></script>

    <script src="/js/site.js" asp-append-version="true"></script>
    @stack('scripts')
</body>

</html>
