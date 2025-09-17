<!DOCTYPE html>
<!-- beautify ignore:start -->
<html
    lang="en"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="assets/"
    data-template="vertical-menu-template-free"
    >
    <head>
        <title>Designation List</title
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @include('admin.includes.formcss')
    </head>

    <body>
        <!-- Layout wrapper -->
        <div class="layout-wrapper layout-content-navbar">
            <div class="layout-container">
                <!-- Menu -->

                @include('admin.includes.menu')
                <!-- / Menu -->
                <!-- Layout container -->
                <div class="layout-page">
                    <!-- Navbar -->
                    @include('admin.includes.nav')

                    <!-- / Navbar -->

                    <!-- Content wrapper -->
                    <div class="content-wrapper">
                        <!-- Content -->

                        <div class="container-xxl flex-grow-1 container-p-y">
                            <h4 class="fw-bold py-2 mb-2">Designation  </h4>



                            <!-- Bordered Table -->
                            <div class="card">
                                <h5 class="card-header">Designations list</h5>
                                <div class="card-body">
                                    <div class="table-responsive text-nowrap">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <a class="btn btn-sm btn-primary" href="{{url('/create-designation')}}">
                                                            <i class="fa-regular fa-square-plus" ></i> Add New
                                                        </a>
                                                    </th>
                                                    <th>ID</th>
                                                    <th>Designation</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(count($designations)>0)
                                                @foreach($designations as $d)
                                                <tr id="row-{{ $d->id }}">
                                                    <td>
                                                        <div class="dropdown">
                                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="{{ url('/edit-designation/'.$d->id) }}">
                                                                    <i class="fa-solid fa-pen"></i> Edit
                                                                </a>
                                                                <a class="dropdown-item cursor-pointer" data-id="{{ $d->id }}" onclick="return deleteDesignation(this);">
                                                                    <i class="fa-solid fa-trash"></i> Delete
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $d->id }}</td>
                                                    <td>{{ $d->designation }}</td>
                                                </tr>
                                                @endforeach
                                                @else
                                                <tr>
                                                    <td colspan="4" class="text-center">Record Not Found!</td>
                                                </tr>
                                                @endif
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!--/ Bordered Table -->


                        </div>
                        <!-- / Content -->

                        <!-- Footer -->
                        @include('admin.includes.footer')
                        <!-- / Footer -->

                        <div class="content-backdrop fade"></div>
                    </div>
                    <!-- Content wrapper -->
                </div>
                <!-- / Layout page -->
            </div>

            <!-- Overlay -->
            <div class="layout-overlay layout-menu-toggle"></div>
        </div>
        <!-- / Layout wrapper -->

        @include('admin.includes.floatmsg')

        <!-- Core JS -->
        @include('admin.includes.formjs')
    </body>
</html>


