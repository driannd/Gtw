<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Corona Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel-2/owl.theme.default.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      @include('admin.sidebar')
      <div class="container-fluid page-body-wrapper">
        @include('admin.nav')
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Menu List </h3>
            </div>
            @if (Session::has('success'))
                <div class="pt-3">
                  <div class="alert alert-success">
                    {{ Session::get('success') }}
                  </div>
                </div>
            @endif
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Cake List</h4>
                    <div class="">
                      <a href="{{ route('menu.create') }}" class="btn btn-primary position-absolute top-0 end-0 mt-4 me-4">+ Tambah</a>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th> # </th>
                            <th> Name </th>
                            <th> Deskripsi </th>
                            <th> Jenis </th>
                            <th> Harga </th>
                            <th> Img </th>
                            <th> Action </th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($menu as $m)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $m->name }}</td>
                            <td>{{ $m->deskripsi }}</td>
                            <td>{{ $m->jenis }}</td>
                            <td>Rp{{ $m->harga }}</td>
                            <td>
                              <img src="{{ asset("menu-images/$m->img") }}" class="card-img img-fluid object-fit-cover" style="width:7rem; height:7rem;" alt="image">
                            </td>
                            <td class="text-align-center"> 
                              <a href="{{ url('menu/'.$m->id.'/edit') }}" class="btn btn-warning btn-sm">Edit</a>  
                              <form action="{{ 'menu/'.$m->id }}" class="d-inline" method="POST" onsubmit="return confirm('Yakin akan menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" name="submit" type="submit">Delete</button>
                              </form> 
                            </td>
                          </tr>
                            @endforeach                          
                          </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              {{ $menu->withQueryString()->links() }}
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:../../partials/_footer.html -->
          @include('admin.footer')
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>

      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="assets/vendors/chart.js/Chart.min.js"></script>
    <script src="assets/vendors/progressbar.js/progressbar.min.js"></script>
    <script src="assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
    <script src="assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
    <script src="assets/js/jquery.cookie.js" type="text/javascript"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="assets/js/dashboard.js"></script>
    <!-- End custom js for this page -->
  </body>
</html>