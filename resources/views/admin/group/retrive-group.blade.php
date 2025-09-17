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
        <title>Department List</title>
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
                            <h4 class="fw-bold py-1 mb-1">Group</h4>


                            <!-- Bordered Table -->
                            <div class="card">
                                <h5 class="card-header">Group list</h5>
                                <div class="card-body">
                                    <div class="table-responsive text-nowrap">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <a class="btn btn-sm btn-primary" href="{{url('/create-group')}}">
                                                            <i class="bx bx-plus-circle me-1" ></i> Add New
                                                        </a>
                                                    </th>
                                                    <th>S.NO</th>
                                                    <th>Class</th>
                                                    <th>Group</th>
                                                    <th>Short Name</th>
                                                    <th>Created At</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php ($sno=1)
                                                @foreach ($groups as $d)
                                                <tr>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button
                                                                type="button"
                                                                class="btn p-0 dropdown-toggle hide-arrow"
                                                                data-bs-toggle="dropdown"
                                                                >
                                                                <i class="bx bx-dots-vertical-rounded"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="{{url('/edit-group/'.$d->id)}}" 
                                                                   ><i class="bx bx-edit-alt me-1" ></i> Edit</a
                                                                >
                                                                <a class="dropdown-item cursor-pointer" data-id="{{$d->id}}"  onclick="return deleteGroup(this);"
                                                                   ><i class="bx bx-trash me-1"></i> Delete</a
                                                                >
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{$sno++}}</td>
                                                    <td>{{$d->standard}}</td>
                                                    <td>{{$d->group_name}}</td>
                                                    <td>{{$d->group_short_name}}</td>
                                                    <td>{{$d->created_at}}</td>
                                                </tr>
                                                @endforeach
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

