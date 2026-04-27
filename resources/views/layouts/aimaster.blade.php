<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>AI 智能助手</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />

    <!-- Core theme CSS (includes Bootstrap)-->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="{{asset('/js/jquery.min.js')}}"></script>
    <script src="{{asset('/js/tabler.min.js')}}"></script>
    <script src="{{asset('/js/select2.min.js')}}"></script>

    <link rel="stylesheet" href="{{asset('/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('/css/tabler.min.css')}}">
    @yield('styles')
</head>
<body>
@include('includes.ainav')


    @yield('content')
<!-- Footer-->
<footer class="border-top">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
{{--                <ul class="list-inline text-center">--}}
{{--                    <li class="list-inline-item">--}}
{{--                        <a href="#!">--}}
{{--                                    <span class="fa-stack fa-lg">--}}
{{--                                        <i class="fas fa-circle fa-stack-2x"></i>--}}
{{--                                        <i class="fab fa-twitter fa-stack-1x fa-inverse"></i>--}}
{{--                                    </span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="list-inline-item">--}}
{{--                        <a href="#!">--}}
{{--                                    <span class="fa-stack fa-lg">--}}
{{--                                        <i class="fas fa-circle fa-stack-2x"></i>--}}
{{--                                        <i class="fab fa-facebook-f fa-stack-1x fa-inverse"></i>--}}
{{--                                    </span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="list-inline-item">--}}
{{--                        <a href="#!">--}}
{{--                                    <span class="fa-stack fa-lg">--}}
{{--                                        <i class="fas fa-circle fa-stack-2x"></i>--}}
{{--                                        <i class="fab fa-github fa-stack-1x fa-inverse"></i>--}}
{{--                                    </span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
                <div class="small text-center text-muted fst-italic">Copyright &copy; zufedfc 2025</div>
            </div>
        </div>
    </div>
    @yield('footer')
</footer>
<!-- Bootstrap core JS-->
{{--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>--}}
</body>
</html>
