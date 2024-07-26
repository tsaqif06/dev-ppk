<!doctype html>
<html lang="en">

    <head>
        @include('layouts.components.head')
    </head>

    <body data-topbar="dark" data-layout="horizontal">

        <!-- Begin page -->
        <div id="layout-wrapper">

            {{-- start header --}}
            @include('layouts.horizontal.partials.header')
            {{-- end header --}}
            {{-- start topnav --}}
            {{-- @include('layouts.horizontal.partials.topnav') --}}
            {{-- end topnav --}}

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content-guest">
                    @yield('content')
                </div>

                <!-- End Page-content -->
                {{-- start footer --}}
                @include('layouts.components.footer')
                {{-- end footer --}}
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->
        @include('layouts.components.modal')
        <!-- Right Sidebar -->
        @include('layouts.components.rightSidebar')
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->
        @include('layouts.components.scripts')

    </body>

</html>
