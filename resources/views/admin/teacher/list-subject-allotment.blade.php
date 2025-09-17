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
                            <h4 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Teacher /</span>  Subject Allotment List </h4>

                            <!-- Bordered Table -->
                            <div class="card">
                                <h5 class="card-header">Teacher Subject Allotment list</h5>
                                <div class="text-start">
                                    @if($allotments->count() > 0)
                                    <a class="btn btn-sm btn-primary ms-4" href="{{ url('/edit-subject-allotment/'.$allotments->first()->teacher_id) }}">
                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                    </a>
                                    @endif

                                    <a class="btn btn-sm btn-danger ms-3" href="{{ url('/teacher-list') }}">
                                        <i class="bx bx-undo me-1"></i> Back
                                    </a>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive text-nowrap">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Teacher</th>
                                                    <th>Class</th>
                                                    <th>Group</th>
                                                    <th>Subject</th>
                                                    <th>Section</th>
                                                    <th>Teacher Type</th>
                                                    <th>Academic Year</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($allotments as $row)
                                                <tr>
                                                    <td>
                                                        <a class="dropdown-item cursor-pointer" data-id="{{ $row->id }}" onclick="return deleteAllotment(this);">
                                                            <i class="bx bx-trash me-1"></i> Delete
                                                        </a>

                                                    </td>
                                                    <td>{{ $row->teacher_name }}</td>
                                                    <td>{{ $row->standard }}</td>
                                                    <td>{{ $row->group_short_name}}</td>
                                                    <td>{{ $row->subject_name }}</td>
                                                    <td>{{ $row->section }}</td>
                                                    <td>{{ $row->teacher_type == 'CT' ? 'Class Teacher' : 'Subject Teacher' }}</td>
                                                    <td>{{ $row->academic_year }}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">No allotments found</td>
                                                </tr>
                                                @endforelse

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
        <script src="{{url('public/assets/js/develop/subjectallotmentEditandList.js')}}" type="text/javascript"></script>

    </body>
</html>


