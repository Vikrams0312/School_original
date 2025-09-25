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
                            <div class="card">
                                <h5 class="card-header">Mark Entry</h5>
                                <div class="card-body">
                                    <form  method="GET" action="{{ url('/markentry') }}">
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="exams" class="form-label">Exam</label>
                                                <select name="exams" id="exams" class="form-select" required="">
                                                    <option value="" >Select Exam</option>
                                                    @foreach($exams as $exam)
                                                    <option value="{{ $exam->id }}" 
                                                            {{ request('exam') == $exam->id ? 'selected' : '' }}>
                                                        {{ $exam->exam_name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!-- Standard Dropdown -->
                                            <div class="col-md-3">
                                                <label for="standard" class="form-label">Class</label>
                                                <select name="standard" id="standard" class="form-select" onchange="toggleGroup()" required>
                                                    <option value="">Select Class</option>
                                                    @foreach($standards as $std)
                                                    <option value="{{ $std}}" 
                                                            {{ request('standard') == $std ? 'selected' : '' }}>
                                                        {{ $std}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!-- Group Dropdown -->
                                            <div class="col-md-3">
                                                <label for="group" class="form-label">Group</label>
                                                <select name="group" id="group" class="form-select"
                                                        {{ request('standard') && request('standard') <= 10 ? 'disabled' : '' }} required>
                                                    <option value="">Select Group</option>
                                                    @foreach($group_list as $grp)
                                                    <option value="{{ $grp->id }}" 
                                                            {{ request('group') == $grp->id ? 'selected' : '' }}>
                                                        {{ $grp->group_short_name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Section</label>
                                                <select class="form-control" name="sections[]">
                                                    <option value="">Select Section</option>
                                                    <option value="No Section">No Section</option>
                                                    @foreach($sections as $section)
                                                    <option  value="{{ $section }}">{{ $section }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Subjects</label>
                                                <select class="form-control" name="subjects[]">
                                                    <option value="">Select Subject</option>
                                                    @foreach($subject_list as $subject)
                                                    <option  value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Submit button -->
                                            <div class="col-md-3 mt-4">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="table-responsive text-nowrap">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Enroll.NO</th>
                                                    <th>Name</th>
                                                    <th>Subject</th>
                                                    <th>total</th>


                                                </tr>
                                            </thead>

                                        </table>
                                    </div>
                                </div>
                            </div>

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

