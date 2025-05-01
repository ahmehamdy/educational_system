<nav class="navbar">
    <div class="nav-container">
        <div class="logo">EduPlatform</div>
        <div class="nav-links">
            <a href="{{ route('dashboard') }}">Home</a>
            <a href="{{route('posts.index')}}">Posts</a>
            <a href="#">Old Materials</a>
            <a href="#">Lectures</a>
            <a href="#">Demonstrators</a>
            <a href="#">Doctors</a>
            <a href="{{ route('profile.edit') }}">profile</a>
        </div>
        @guest
            <div class="auth-buttons">
                <a class="auth-btn login-btn" href='{{ route('login') }}'>Login</a>
                <a class="auth-btn signup-btn" href='{{ route('register') }}'>Sign Up</a>
            </div>
        @endguest
        @auth
            <div class="auth-buttons">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="auth-btn signup-btn">Sign Out</button>
                </form>
            </div>
        @endauth
    </div>
</nav>
