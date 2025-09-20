<!DOCTYPE html>
<html
    lang="en"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="assets/"
    data-template="vertical-menu-template-free"
    >
    <head>
        <title>Create Teacher</title>

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
                            <h4 class="fw-bold py-1 mb-1">Teacher</h4>

                            <div class="row">

                                <!-- Basic with Icons -->
                                <div class="col-xxl">
                                    <div class="card mb-4">
                                        <div class="card-header d-flex align-items-center justify-content-between">
                                            <h5 class="mb-0">Create Teacher Subject Allotment</h5>

                                        </div>
                                        <div class="card-body">
                                            <form method="POST" action="{{url('/save-subject-allotments')}}">
                                                @csrf

                                                <!-- Teacher -->
                                                <div class="col-md-6">
                                                    <label class="form-label">Teacher</label>
                                                    <select name="teacher_id" id="teacher-select" class="form-select" required>
                                                        <option value="">-- Select Teacher --</option>
                                                        @foreach($teachers as $teacher)
                                                        <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div id="assignment-rows" class="mt-3">
                                                    <div class="row mb-3 assignment-row">

                                                        <!-- Class -->
                                                        <div class="col-md-2">
                                                            <label class="form-label">Class</label>
                                                            <select name="class_ids[]" class="form-select" required>
                                                                <option value="">-- Select Class --</option>
                                                                @foreach($classes as $class)
                                                                <option value="{{ $class->standard }}">{{ $class->standard }}</option>
                                                                @endforeach
                                                            </select>

                                                        </div>

                                                        <!-- Group / Short Name -->
                                                        <div class="col-md-2">
                                                            <label class="form-label">Group Name</label>
                                                            <select name="shortname_ids[]" class="form-select">
                                                                <option value="">-- Select Group --</option>
                                                                @foreach($groups as $group)
                                                                <option value="{{ $group->id }}">{{ $group->group_short_name }}</option>
                                                                @endforeach
                                                            </select>


                                                        </div>

                                                        <!-- Subject -->
                                                        <div class="col-md-2">
                                                            <label class="form-label">Subjects</label>
                                                            <select class="form-select" name="subject_ids[]" required>
                                                                <option value="">-- Select Subject --</option>
                                                                @foreach($subjects as $subject)
                                                                <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <!-- Section -->
                                                        <div class="col-md-2">
                                                            <label class="form-label">Section</label>
                                                            <select name="sections[]" class="form-select" required>
                                                                <option value="">-- Select Section --</option>
                                                                <option value="NoSection">No Section</option>
                                                                @foreach(range('A', 'G') as $section)
                                                                <option value="{{ $section }}">{{ $section }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <!-- Teacher Type -->
                                                        <div class="col-md-2">
                                                            <label class="form-label">Teacher Type</label>
                                                            <select name="teacher_types[]" class="form-select" required>
                                                                <option value="">-- Select Type --</option>
                                                                <option value="CT">Class Teacher</option>
                                                                <option value="ST">Subject Teacher</option>
                                                            </select>
                                                        </div>

                                                        <!-- Academic Year -->
                                                        <div class="col-md-2">
                                                            <label class="form-label">Academic Year</label>
                                                            <select name="academic_years[]" id="academic_year" class="form-select" required>
                                                                <option value="">Select Academic Year</option>
                                                                @foreach($academic_year as $year)
                                                                <option value="{{ $year->academic_year }}" 
                                                                        {{ request('academic_year') == $year->academic_year ? 'selected' : '' }}>
                                                                    {{ $year->academic_year }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>
                                                <!-- Add Row Button -->
                                                <div class="mb-3">
                                                    <button type="button" class="btn btn-sm btn-success" id="add-assignment-row">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                                <div class="row justify-content-start">
                                                    <div class="col-sm-10">
                                                        <button type="submit"  class="btn btn-info">Save</button>
                                                        <!-- Show List button -->
                                                        <a href="#" id="show-list-btn" class="btn btn-primary">Show list</a>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
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
        <script src="{{url('public/assets/js/develop/subject-allotment.js')}}" type="text/javascript"></script>
        <script>
        $(document).ready(function () {
            handleShowList();
        });
        </script>
    </body>
</html>

