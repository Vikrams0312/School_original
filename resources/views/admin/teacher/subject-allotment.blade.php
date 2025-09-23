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
        <div class="layout-wrapper layout-content-navbar">
            <div class="layout-container">

                @include('admin.includes.menu')

                <div class="layout-page">
                    @include('admin.includes.nav')

                    <div class="content-wrapper">
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <h4 class="fw-bold py-3 mb-4">
                                <span class="text-muted fw-light">Teacher /</span> Subject Allotment
                            </h4>

                            <div class="card mb-4">
                                <div class="card-body">
                                    <form action="{{ url('/save-subject-allotments') }}" method="POST">
                                        @csrf

                                        <!-- Teacher Dropdown -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="teacher" class="form-label">Select Teacher</label>
                                                <select class="form-control" name="teacher_id" id="teacher-select" required>
                                                    <option value="">-- Select Teacher --</option>
                                                    @foreach($teachers as $teacher)
                                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Assignment Rows -->
                                        <div id="assignment-rows"></div>

                                        <!-- Hidden Row Template -->
                                        <div id="row-template" class="row mb-3 assignment-row d-none">
                                            <div class="col-md-2">
                                                <label class="form-label">Class</label>
                                                <select class="form-control" name="class_ids[]" >
                                                    <option value="">-- Select --</option>
                                                    @foreach($classes as $class)
                                                    <option value="{{ $class->standard }}">{{ $class->standard }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Group</label>
                                                <select class="form-control" name="shortname_ids[]">
                                                    <option value="">-- Select --</option>
                                                    @foreach($groups as $group)
                                                    <option value="{{ $group->id }}">{{ $group->group_short_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Subject</label>
                                                <select class="form-control" name="subject_ids[]">
                                                    <option value="">-- Select --</option>
                                                    @foreach($subjects as $subject)
                                                    <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Section</label>
                                                <select class="form-control" name="sections[]">
                                                    <option value="">-- Select --</option>
                                                    <option value="No Section">No Section</option>
                                                    <option value="A">A</option>
                                                    <option value="B">B</option>
                                                    <option value="C">C</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Teacher Type</label>
                                                <select class="form-control" name="teacher_types[]">
                                                    <option value="">-- Select --</option>
                                                    <option value="CT">Class Teacher</option>
                                                    <option value="ST">Subject Teacher</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Academic Year</label>
                                                <select class="form-control" name="academic_years[]">
                                                    <option value="">-- Select --</option>
                                                    @foreach($academic_year as $year)
                                                    <option value="{{ $year->academic_year }}">{{ $year->academic_year }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <button type="button" id="add-row" class="btn btn-sm btn-success"><i class="fas fa-plus"></i></button>
                                        <!-- Buttons -->
                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-sm btn-primary">Save Allotments</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                        @include('admin.includes.footer')
                    </div>
                </div>
            </div>
        </div>

        @include('admin.includes.formjs')
        <script src="{{url('public/assets/js/develop/subject-allotment.js')}}" type="text/javascript"></script>
    </body>
</html>
