<nav class="navbar navbar-expand-lg">
<div class="container">
 
    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    </button>
    <div class="main_menu">
    @include('layouts.app-partials.new-top-menu')
    </div>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-new-case" href="{{ route('newcase') }}"><span>New Case</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-search" href="{{ url('/') }}"><span>Search Case</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-logout" href="{{ route('logout') }}"><span>Logout</span></a>
                </li>
            </ul>
    </div>
</div>
</nav>
