<!DOCTYPE html>

<html direction="rtl" dir="rtl" style="direction: rtl">
	<!--begin::Head-->
    @include('layouts._header')
	<!--end::Head-->
	<!--begin::Body-->
    <div class="wrapper">

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin-left:0px!important">
          <!-- Content Header (Page header) -->
          <nav class="main-header navbar navbar-expand navbar-white navbar-light mt-5" style="margin-left:0px!important">
            <!-- Left navbar links -->

          </nav>
          <!-- /.content-header -->

          <!-- Main content -->
          <div class="content">
            <div class="container mt-5">
                @yield('content')

              <!-- /.row -->
            </div><!-- /.container-fluid -->
          </div>
          <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->


        <!-- Main Footer -->
        <footer class="main-footer">
          <!-- To the right -->
          <div class="float-right d-none d-sm-inline">

          </div>
          <!-- Default to the left -->
        </footer>
      </div>

      @include('layouts._footer')
	<!--end::Body-->
</html>
