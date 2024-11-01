<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment</title>
</head>
<body>
    <header>
      
        <nav>
            <ul class="">
                @auth
                    <li>Welcome, {{Auth::user()->name}} !</li>
                    <li>
                        <form action="{{route('logout')}}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit">Logout</button>
                        </form>
                    </li>
                    @else
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                    @endauth
                    <li><a href="{{ route('courses.index') }}">Courses</a></li>
                    <li><a href="{{ route('threads.index') }}">Threads</a></li>
            </ul>
        </nav>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>
