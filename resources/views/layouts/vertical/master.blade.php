<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.components.head')
</head>

<body data-topbar="dark">

    <!-- Begin page -->

    <div id="layout-wrapper">

        {{-- Start Nabar --}}
        @include('layouts.vertical.partials.header')
        {{-- End navbar --}}

        {{-- Left Sidebar Start --}}
        @include('layouts.vertical.partials.sidebar')
        {{-- End Left Sidebar --}}

        {{-- Start Main --}}
        <div class="main-content">

            {{-- Start Main Content --}}
            <div class="page-content">
                @yield('content')
            </div>
            {{-- End Main Content --}}


            {{-- Start footer --}}
            @include('layouts.components.footer')
            {{-- End Footer --}}

        </div>
        {{-- End Main --}}
    </div>
    <!-- END layout-wrapper -->
    @include('layouts.components.modal')
    @include('layouts.components.spinner')
    {{-- Start Rigth Bar --}}
    @include('layouts.components.rightSidebar')
    {{-- End Right Bar --}}

    {{--  Right bar overlay --}}
    <div class="rightbar-overlay"></div>

    {{-- Start JavaScript --}}
    @include('layouts.components.scripts')
    {{-- End JavaScript --}}
</body>

</html>
