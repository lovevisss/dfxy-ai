{{--@if (Route::has('login'))--}}
{{--    <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">--}}
{{--        @auth--}}
{{--            <a href="{{ url('/home') }}" class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Home</a>--}}
{{--        @else--}}
{{--            <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>--}}

{{--            @if (Route::has('register'))--}}
{{--                <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>--}}
{{--            @endif--}}
{{--        @endauth--}}
{{--    </div>--}}
{{--@endif--}}
{{--<div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">--}}
{{--    <a {{Request::route()->getName() == 'welcome' ? "style=color:red;" : ""}}   href="{{route('welcome')}}">Welcome</a>--}}

{{--    <a {{Request::route()->getName() == 'about' ? "style=color:red;" : ""}} href="{{route('about')}}">About</a>--}}
{{--    <a {{Request::route()->getName() == 'contact' ? "style=color:red;" : ""}} href="{{route('contact')}}">Contact</a>--}}

{{--</div>--}}
<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-light" id="mainNav">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="{{route('link.index')}}">网站导航</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
        </button>
        <div class="" id="navbarResponsive">
            <ul class="navbar-nav ms-auto py-4 py-lg-0">
                <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="{{route('category.create')}}">添加分类</a></li>
                <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="{{route('link.create')}}">添加链接</a></li>
{{--                <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="{{route('single_post',3)}}">Sample Post</a></li>--}}
{{--                <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="{{route('contact')}}">Contact</a></li>--}}
{{--                @if(Auth::check())--}}
{{--                    <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="{{route('dashboard')}}">Dashboard</a></li>--}}
{{--                    <form id="logout-form" action="{{route('logout')}}" method="POST">@csrf</form>--}}
{{--                    <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" onclick="document.getElementById('logout-form').submit()" href="#">Logout</a></li>--}}

{{--                @else--}}
{{--                    <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="{{route('login')}}">Login</a></li>--}}
{{--                    <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="{{route('register')}}">Register</a></li>--}}

{{--                @endif--}}
            </ul>
        </div>
    </div>
</nav>
