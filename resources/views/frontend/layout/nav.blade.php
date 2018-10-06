
<!-- HEADER
================================================== -->

<header class="tp--header tp--header-fixed tp--header-shrink tp--header-1">

    <a href="#0" class="nav-trigger">Open Nav<span aria-hidden="true"></span></a>

    <nav class="navbar-wrapper">

        <div class="container clearfix">

            <!-- LOGO
            ================================================== -->

            <h1 class="logo">
                <a href="{{route('frontend.index')}}">
                    {{--<div class="logo-main">
                    <img src="{{url('frontend/images/logo.png') }}"  alt="Olive.">
                        </div>--}}
                    <div class="logo-main">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="80" viewBox="0 0 315.36 61.64"><defs><style>.cls-1{fill:#fff;}</style></defs><title>whiteРесурс 6</title><g id="Слой_2" data-name="Слой 2"><g id="Слой_1-2" data-name="Слой 1"><path class="cls-1" d="M0,60.49V3.28H21.17c4.25,0,8.06,1.81,11.59,5.33s5.33,8.21,5.33,14a19.47,19.47,0,0,1-5.18,13.87C29.45,40.22,25.56,42,21.17,42H11.09V60.49Zm11.09-30h9.43a6.51,6.51,0,0,0,4.39-1.81C26.28,27.5,27,25.44,27,22.65s-.72-4.76-2.09-6a6.62,6.62,0,0,0-4.39-1.89H11.09Z"/><path class="cls-1" d="M43.42,19.12H54.29V42.76c0,5.25,2.66,7.63,6.62,7.63s6.62-2.38,6.62-7.63V19.12H78.41V43.83c0,5.75-1.66,10.18-5,13.21a17.8,17.8,0,0,1-12.46,4.6A18.1,18.1,0,0,1,48.38,57c-3.31-3-5-7.47-5-13.21Z"/><path class="cls-1" d="M84.17,46.21a21.51,21.51,0,0,0,14.11,4.92c3.53,0,5.33-.9,5.33-2.79,0-.82-.58-1.48-1.8-2.05a49.12,49.12,0,0,0-5.18-2,33.65,33.65,0,0,1-5.4-2.3c-4.25-2.38-6.34-6.07-6.34-11.24,0-4,1.37-7.22,4.18-9.44a15.33,15.33,0,0,1,10.08-3.45,19.57,19.57,0,0,1,10.73,2.87V31.44a19.16,19.16,0,0,0-10.44-3q-4.54,0-4.54,2.46c0,2.38,3.24,2.87,7.27,4.19,3.53,1.23,5.83,2.22,8.14,4.19s3.6,4.84,3.6,8.78c0,8.13-5.26,13.46-15.91,13.46a26.92,26.92,0,0,1-13.83-3.94Z"/><path class="cls-1" d="M118.87,60.49V3.28H129.6V24.13c1.44-3.61,5.33-5.91,10.15-5.91,8.57,0,13.47,6.4,13.47,17.15V60.49H142.49V36.85c0-4.84-2.23-7.8-6.19-7.8s-6.7,3.37-6.7,8.21V60.49Z"/><path class="cls-1" d="M157.39,60.49,183.53,0l26.14,60.49H197.86L194,51.38H173l-3.89,9.11Zm19.73-19.86h12.75l-6.41-15Z"/><path class="cls-1" d="M213.69,19.12h10.87V42.76c0,5.25,2.66,7.63,6.62,7.63s6.63-2.38,6.63-7.63V19.12h10.87V43.83c0,5.75-1.66,10.18-5,13.21a17.8,17.8,0,0,1-12.46,4.6A18.1,18.1,0,0,1,218.66,57c-3.31-3-5-7.47-5-13.21Z"/><path class="cls-1" d="M257.9,60.49V30.2h-4.82V19.12h4.82V3.28h10.44V19.12h8V30.2h-8V60.49Z"/><path class="cls-1" d="M281,60.49V3.28h10.73V24.13c1.44-3.61,5.33-5.91,10.15-5.91,8.57,0,13.46,6.4,13.46,17.15V60.49H304.63V36.85c0-4.84-2.23-7.8-6.19-7.8s-6.7,3.37-6.7,8.21V60.49Z"/></g></g></svg>
                    </div>
                    {{--<div class="logo-dark">
                    <img src="{{url('frontend/images/logo-dark.png?v5') }}" alt="Olive.">
                        </div>--}}
                    <div class="logo-dark">
                    {{--<img src="{{url('frontend/images/logo-dark.png?v5') }}" class="logo-dark" alt="Olive.">--}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="80" viewBox="0 0 315.36 61.64"><title>blackРесурс 5</title><g id="Слой_2" data-name="Слой 2"><g id="Слой_1-2" data-name="Слой 1"><path d="M0,60.49V3.28H21.17c4.25,0,8.06,1.81,11.59,5.33s5.33,8.21,5.33,14a19.47,19.47,0,0,1-5.18,13.87C29.45,40.22,25.56,42,21.17,42H11.09V60.49Zm11.09-30h9.43a6.51,6.51,0,0,0,4.39-1.81C26.28,27.5,27,25.44,27,22.65s-.72-4.76-2.09-6a6.62,6.62,0,0,0-4.39-1.89H11.09Z"/><path d="M43.42,19.12H54.29V42.76c0,5.25,2.66,7.63,6.62,7.63s6.62-2.38,6.62-7.63V19.12H78.41V43.83c0,5.75-1.66,10.18-5,13.21a17.8,17.8,0,0,1-12.46,4.6A18.1,18.1,0,0,1,48.38,57c-3.31-3-5-7.47-5-13.21Z"/><path d="M84.17,46.21a21.51,21.51,0,0,0,14.11,4.92c3.53,0,5.33-.9,5.33-2.79,0-.82-.58-1.48-1.8-2.05a49.12,49.12,0,0,0-5.18-2,33.65,33.65,0,0,1-5.4-2.3c-4.25-2.38-6.34-6.07-6.34-11.24,0-4,1.37-7.22,4.18-9.44a15.33,15.33,0,0,1,10.08-3.45,19.57,19.57,0,0,1,10.73,2.87V31.44a19.16,19.16,0,0,0-10.44-3q-4.54,0-4.54,2.46c0,2.38,3.24,2.87,7.27,4.19,3.53,1.23,5.83,2.22,8.14,4.19s3.6,4.84,3.6,8.78c0,8.13-5.26,13.46-15.91,13.46a26.92,26.92,0,0,1-13.83-3.94Z"/><path d="M118.87,60.49V3.28H129.6V24.13c1.44-3.61,5.33-5.91,10.15-5.91,8.57,0,13.47,6.4,13.47,17.15V60.49H142.49V36.85c0-4.84-2.23-7.8-6.19-7.8s-6.7,3.37-6.7,8.21V60.49Z"/><path d="M157.39,60.49,183.53,0l26.14,60.49H197.86L194,51.38H173l-3.89,9.11Zm19.73-19.86h12.75l-6.41-15Z"/><path d="M213.69,19.12h10.87V42.76c0,5.25,2.66,7.63,6.62,7.63s6.63-2.38,6.63-7.63V19.12h10.87V43.83c0,5.75-1.66,10.18-5,13.21a17.8,17.8,0,0,1-12.46,4.6A18.1,18.1,0,0,1,218.66,57c-3.31-3-5-7.47-5-13.21Z"/><path d="M257.9,60.49V30.2h-4.82V19.12h4.82V3.28h10.44V19.12h8V30.2h-8V60.49Z"/><path d="M281,60.49V3.28h10.73V24.13c1.44-3.61,5.33-5.91,10.15-5.91,8.57,0,13.46,6.4,13.46,17.15V60.49H304.63V36.85c0-4.84-2.23-7.8-6.19-7.8s-6.7,3.37-6.7,8.21V60.49Z"/></g></g></svg>
                        </div>
                </a>
            </h1>


            <!-- NAVIGATION
            ================================================== -->

            <div class="navbar tp--nav-dropdown pull-right">

                <div class="navbar-collapse collapse">

                    <ul class="nav navbar-nav">
                        <li>
                            <a href="{{route('frontend.index')}}">Home</a>
                        </li>
                        <li>
                            <a href="{{route('frontend.index')}}#about" class="tp--scroll">How it works</a>
                        </li>
                        <li>
                            <a href="{{route('frontend.index')}}#features" class="tp--scroll">Features</a>
                        </li>

                        <li class="has-dropdown links" data-content="more">
                            <a href="#0">Developing</a>
                        </li>
                       {{-- <li>
                            <a href="{{route('frontend.blog')}}" class="tp--scroll">Blog</a>
                        </li>--}}
                        <li class="tp--nav-divider"><a></a></li>
                        @if (Auth::check())
                            <li class="tp--nav-signup">
                                <a class="" href="{{route('dashboard')}}"><span class="btn btn-pink-alt signbtn">Dashboard >></span></a>
                            </li>
                            <li>
                                <a class="" href="{{route('logout')}}">Logout</a>
                            </li>
                        @else

                        <li>
                            <a class="popup-modal" href="#modal-login">Login</a>
                        </li>
                        <li class="tp--nav-signup">
                            <a class="popup-modal" href="#modal-register"><span class="btn btn-pink-alt signbtn">Sign up</span></a>
                        </li>
                            @endif
                    </ul>
                </div>

            </div>

            <!-- Dropdown Wrapper -->
            <div class="morph-dropdown-wrapper">
                <div class="morph-dropdown-container">
                    <div class="dropdown-list text-center">
                        <ul>

                            <li class="links">
                                <a href="{{route('frontend.index')}}" class="tp--nav-label">Home</a>
                            </li>

                            <li class="links">
                                <a href="{{route('frontend.index')}}#about" class="tp--nav-label tp--scroll">How it works</a>
                            </li>

                            <li class="links">
                                <a href="{{route('frontend.index')}}#features" class="tp--nav-label tp--scroll">Features</a>
                            </li>



                            <li id="more" class="dropdown links">
                                <a href="#0" class="tp--nav-label">Additional Links</a>

                                <div class="content">
                                    <ul>
                                        <li>
                                            <a href="{{route('frontend.content.api')}}">API</a>
                                        </li>

                                        <li>
                                            <a href="https://github.com/pushauth">Libraries</a>
                                        </li>

                                        <li>
                                            <a href="{{route('frontend.content.faq')}}">FAQ</a>
                                        </li>

                                        <li>
                                            <a href="{{route('frontend.content.jobs')}}">We needed</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li class="tp--nav-divider"><a></a></li>
@if (Auth::check())
                                <li class="links tp--nav-auth">
                                    <a class=" tp--nav-label" href="{{route('dashboard')}}">
                                        <span class=" btn btn-purple btn-block btn-lg">Dashboard</span>
                                    </a>
                                </li>
                                <li class="links tp--nav-auth">
                                    {{-- <span class="btn btn-primary btn-block btn-lg">Login</span></a>--}}
                                    <a class=" tp--nav-label" href="{{route('logout')}}">
                                        <span class=" btn btn-pink btn-block btn-lg">Log Out</span>
                                    </a>
                                </li>
    @else
                                <li class="links tp--nav-auth">
                                    {{-- <span class="btn btn-primary btn-block btn-lg">Login</span></a>--}}
                                    <a class="popup-modal tp--nav-label" href="#modal-login">
                                        <span class=" btn btn-pink btn-block btn-lg">Log In</span>
                                    </a>
                                </li>

                                <li class="links tp--nav-auth">
                                    <a class="popup-modal tp--nav-label" href="#modal-login">
                                        <span class=" btn btn-purple btn-block btn-lg">Sign Up</span>
                                    </a>
                                </li>
    @endif


                        </ul>

                        <div class="bg-layer" aria-hidden="true"></div>
                    </div> <!-- dropdown-list -->
                </div>
            </div> <!-- morph-dropdown-wrapper -->

        </div>

    </nav>

</header>
