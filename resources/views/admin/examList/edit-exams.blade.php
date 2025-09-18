<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr"
      data-theme="theme-default" data-assets-path="assets/"
      data-template="vertical-menu-template-free">
<head>
    <title>Edit Exam</title>
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
                    <h4 class="fw-bold py-1 mb-1">Exams</h4>
                    <hr class="my-2" />

                    <div class="row">
                        <div class="col-xxl">
                            <div class="card mb-4">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <h5 class="mb-0">Edit Exam</h5>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="{{ url('/update-exams/'.$exam->id) }}">
                                        @csrf
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        <!-- Standard -->
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label">Standard</label>
                                            <div class="col-sm-10">
                                                <div class="input-group input-group-merge">
                                                    <span class="input-group-text"><i class="bx bx-user"></i></span>
                                                    <select class="form-select" name="standard" required>
                                                        <option value="">SELECT STANDARD</option>
                                                        @foreach($standards as $dt)
                                                            <option value="{{ $dt->standard }}"
                                                                {{ $exam->standard == $dt->standard ? 'selected' : '' }}>
                                                                {{ $dt->standard }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Exam Name -->
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label">Exam Name</label>
                                            <div class="col-sm-10">
                                                <div class="input-group input-group-merge">
                                                    <span class="input-group-text"><i class="bx bx-book"></i></span>
                                                    <input type="text" class="form-control"
                                                           name="exam_name" required
                                                           value="{{ old('exam_name', $exam->exam_name) }}"
                                                           placeholder="Enter exam name">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Academic Year -->
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label">Academic Year</label>
                                            <div class="col-sm-10">
                                                <div class="input-group input-group-merge">
                                                    <span class="input-group-text"><i class="bx bx-calendar-check"></i></span>
                                                    <input type="text" class="form-control"
                                                           name="academic_year" required
                                                           value="{{ old('academic_year', $exam->academic_year) }}"
                                                           placeholder="____-____">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Buttons -->
                                        <div class="row justify-content-end">
                                            <div class="col-sm-10">
                                                <button type="submit" class="btn btn-primary">Update</button>
                                                <a href="{{ url('/list-exams') }}" class="btn btn-secondary">Back</a>
                                            </div>
                                        </div>
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
    <div class="layout-overlay layout-menu-toggle"></div>
</div>
@include('admin.includes.floatmsg')
@include('admin.includes.formjs')
</body>
</html>
