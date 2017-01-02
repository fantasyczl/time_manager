<nav class="navbar navbar-default">
    <div class="container-fluid">
        <p class="navbar-text">
        TIME RECORD
        </p>

        <ul class="nav navbar-nav">
            <li class="{{ strpos($_SERVER['REQUEST_URI'], '/dashboard') !== false ? 'active' : '' }}">
                <a href="/dashboard">Dashboard <span class="sr-only">(current)</span></a>
            </li>
            <li class="{{ strpos($_SERVER['REQUEST_URI'], '/projects') !== false ? 'active' : '' }}">
                <a href="/projects">Project</a>
            </li>
            <li class="{{ strpos($_SERVER['REQUEST_URI'], '/tasks') !== false ? 'active' : '' }}">
                <a href="/tasks">Tasks</a>
            </li>
            <li class="{{ strpos($_SERVER['REQUEST_URI'], '/date') !== false ? 'active' : '' }}">
                <a href="/date">Date</a>
            </li>
            <li class="{{ strpos($_SERVER['REQUEST_URI'], '/schedules') !== false ? 'active' : '' }}">
                <a href="/schedules">Schedules</a>
            </li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false">
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <ul class="dropdown-menu" "role"="menu"="">
                    <li>
                        <a href="/users/{{ Auth::id() }}/edit">Profile</a>
                    </li>
                    <li>
                        <a href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="/logout" method="POST" style="display:none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
