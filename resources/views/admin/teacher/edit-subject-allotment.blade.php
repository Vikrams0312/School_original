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
        <title>Edit Teacher</title>
        @include('admin.includes.formcss')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <body>
        <div class="layout-wrapper layout-content-navbar">
            <div class="layout-container">
                @include('admin.includes.menu')
                <div class="layout-page">
                    @include('admin.includes.nav')
                    <div class="content-wrapper">
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <h4 class="fw-bold py-1 mb-1"><span class="text-muted fw-light">Form/</span>Teacher</h4>
                            <hr class="my-2" />
                            <div class="row">
                                <div class="col-xxl">
                                    <div class="card mb-4">
                                        <div class="card-header d-flex align-items-center justify-content-between">
                                            <h5>Edit Subject Allotments for {{ $teacher->name }}</h5>
                                        </div>
                                        <div class="container">
                                            <form id="allotment-form" action="{{ url('/update-subject-allotment') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
                                                <div id="assignment-rows">
                                                    @foreach($allotments as $allotment)
                                                    <div class="row mb-3 assignment-row">
                                                        <input type="hidden" name="allotment_ids[]" value="{{ $allotment->id }}">

                                                        <div class="col-md-2">
                                                            <label class="form-label">Class</label>
                                                            <select name="class_ids[]" class="form-select class-select" required>
                                                                <option value="">-- Select Class --</option>
                                                                @foreach($class_list as $standard)
                                                                <option value="{{ $standard->standard }}" {{ $allotment->standard == $standard->standard ? 'selected' : '' }}>
                                                                    {{ $standard->standard }}
                                                                </option>
                                                                @endforeach
                                                            </select>

                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-label">Group Name</label>
                                                            <select name="shortname_ids[]" class="form-select group-select" {{ ($allotment->standard == 11 || $allotment->standard == 12) ? '' : 'disabled' }}>
                                                                <option value="">-- Select Group --</option>
                                                                @foreach($groups as $shortname)
                                                                                                                       
                                                                <option value="{{ $shortname->id }}" {{ $shortname->id == $allotment->group_name_id ? 'selected' : '' }}>
                                                                    {{ $shortname->group_short_name }}
                                                                </option>
                                      
                                                                @endforeach
                                                            </select>



                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-label">Subjects</label>
                                                            <select class="form-select" name="subject_ids[]" required>
                                                                <option value="">-- Select Subject --</option>
                                                                @foreach($subjects as $subject)
                                                                <option value="{{ $subject->id }}" {{ $allotment->subject_id == $subject->id ? 'selected' : '' }}>
                                                                    {{ $subject->subject_name }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-label">Section</label>
                                                            <select name="sections[]" class="form-select" required>
                                                                <option value="">-- Select Section --</option>
                                                                <option value="NoSection" {{ $allotment->section == 'NoSection' ? 'selected' : '' }}>No Section</option>
                                                                @foreach(range('A', 'G') as $section)
                                                                <option value="{{ $section }}" {{ $allotment->section == $section ? 'selected' : '' }}>{{ $section }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-label">Teacher Type</label>
                                                            <select name="teacher_types[]" class="form-select" required>
                                                                <option value="">-- Select Type --</option>
                                                                <option value="CT" {{ $allotment->teacher_type == 'CT' ? 'selected' : '' }}>Class Teacher</option>
                                                                <option value="ST" {{ $allotment->teacher_type == 'ST' ? 'selected' : '' }}>Subject Teacher</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-label">Academic Year</label>
                                                            <input type="text" class="form-control" placeholder="____-____" name="academic_years[]" value="{{ $allotment->academic_year }}" required />
                                                        </div>

                                                        <div class="col-md-1 d-flex align-items-end">
                                                            <button type="button" class="btn btn-sm btn-danger remove-row"><i class="fa-solid fa-xmark"></i></button>
                                                        </div> 
                                                    </div>
                                                    @endforeach
                                                </div>

                                                <button type="button" class="btn btn-sm btn-success mb-3" id="add-row"><i class="fas fa-plus"></i></button>
                                                <br>
                                                <button type="submit" class="btn btn-sm btn-primary mb-4">Update Allotments</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include('admin.includes.footer')
                        <div class="content-backdrop fade"></div>
                    </div>
                </div>
            </div>
            @include('admin.includes.floatmsg')
            @include('admin.includes.formjs')
            <script src="{{url('public/assets/js/develop/subjectallotmentEditandList.js')}}" type="text/javascript"></script>
           
    </body>
</html>