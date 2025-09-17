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
        <title>Teacher List</title
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
                            <h4 class="fw-bold py-2 mb-2">Employee List</h4>

                            <div class="mb-2 col-md-4 d-flex">
                                <form action="{{ url('/teacher-list') }}" method="GET" class="mb-2 d-flex">
                                    @csrf
                                    <select name="designation" class="form-select" required>
                                        <option value="">-- Select designation --</option>
                                        @foreach($designations as $designation)
                                        <option value="{{ $designation->id }}" {{ request('designation') == $designation->id ? 'selected' : '' }}>
                                            {{ $designation->designation }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-sm btn-primary ms-2" type="submit">Submit</button>
                                </form>
                            </div>

                            <!-- Show message if no designation selected -->
                            @if(!isset($designation_id) || !$designation_id)
                            <div class="alert alert-light">
                                Please select a designation to view employee details.
                            </div>
                            @else
                            <div class="card">
                                <h5 class="card-header">Employee list</h5>
                                <div class="card-body">
                                    <div class="table-responsive text-nowrap">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <a class="btn btn-sm btn-primary" href="{{url('/create-teacher')}}">
                                                            <i class="bx bx-plus-circle me-1"></i> Add New
                                                        </a>
                                                    </th>
                                                    <th>S.NO</th>
                                                    <th>Name</th>
                                                    <th>Subject Allotment</th>
                                                    <th>Email</th>
                                                    <th>Mobile</th>
                                                    <th>Experience</th>
                                                    <th>Previous Work</th>
                                                    <th>Qualification</th>
                                                    <th>Designation</th>
                                                    <th>Join Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php($sno=1)
                                                @if(count($teacher)>0)
                                                @foreach($teacher as $d)
                                                <tr>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                                <i class="bx bx-dots-vertical-rounded"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="{{url('/edit-teacher/'.$d->id)}}">
                                                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                                                </a>
                                                                <a class="dropdown-item cursor-pointer" data-id="{{$d->id}}" onclick="return deleteTeacher(this);">
                                                                    <i class="bx bx-trash me-1"></i> Delete
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{$sno++}}</td>
                                                    <td>{{$d->name}}</td>
                                                    <td>
                                                        <a class="btn btn-sm btn-primary text-white" href="{{ url('/subject-allotment-list/'.$d->id) }}">
                                                            Subjects
                                                        </a>
                                                    </td>
                                                    <td>{{$d->email}}</td>
                                                    <td>{{$d->mobile}}</td>
                                                    <td>{{$d->experience}}</td>
                                                    <td>{{$d->previous_work_station}}</td>
                                                    <td>{{$d->qualification}}</td>
                                                    <td>{{$d->designation_name}}</td>
                                                    <td>{{$d->join_date}}</td>
                                                </tr>
                                                @endforeach
                                                @else
                                                <tr>
                                                    <td colspan="11" class="text-center">Record Not Found!</td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endif
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

