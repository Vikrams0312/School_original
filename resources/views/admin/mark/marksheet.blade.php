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
        <title>Assign Mark Table</title>
        @include('admin.includes.formcss')

    </head>

    <body data-success="{{ session('success') ? 'true' : 'false' }}">

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

                            <!-- Basic Layout & Basic with Icons -->
                            <div class="row">
                                <!-- Basic with Icons -->
                                <div class="col-xxl">
                                    <div class="card mb-4">
                                        <div class="card-header d-flex align-items-center justify-content-between">
                                            <h4>Mark sheet</h4>
                                        </div>
                                        <div class="card-body">
                                            <form method="GET" action="{{ url('mark-sheet') }}" class="row g-3 mb-4">
                                                <div class="col-md-3">
                                                    <label for="exam" class="form-label">Exam</label>
                                                    <select name="exam" id="exam" class="form-select" required="">
                                                        <option value="">Select Exam</option>
                                                        @foreach($exams as $ex)
                                                        <option value="{{ $ex->id }}"> {{ $ex->exam_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="standard" class="form-label">Class</label>
                                                    <select name="standard" id="standard" class="form-select" required="">
                                                        <option value="">Select Class</option>
                                                        @for($i=1;$i<=12;$i++)
                                                        <option value="{{ $i }}" {{ $standard == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                </div>


                                                <div class="col-md-3">
                                                    <label for="group" class="form-label">Group</label>
                                                    <select name="group"  class="form-select" required="">
                                                        <option value="">Select Group</option>
                                                        @foreach($groups as $g)
                                                        <option value="{{ $g->group_short_name }}">
                                                            {{ $g->group_short_name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>


                                                <div class="col-md-3">
                                                    <label for="section" class="form-label">Section</label>
                                                    <select name="section" id="section" class="form-select" required>

                                                        <option value="No Section">No Section</option>
                                                        @foreach(range('A', 'G') as $section)
                                                        <option  value="{{ $section }}">{{ $section }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="academic_year" class="form-label">Academic Year</label>
                                                    <select name="academic_year" id="academic_year" class="form-select" required="">
                                                        @foreach($Academic_year as $year)
                                                        <option value="{{ $year->academic_year }}">{{ $year->academic_year }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-2 mt-5">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </form>
                                            @if($students->count())
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-fixed mt-3">
                                                    <thead class="table-secondary">
                                                        <tr>
                                                            <th>Roll No</th>
                                                            <th class="sticky-col">Name</th>
                                                            @foreach($subjects as $sub)
                                                            <th>{{ ucfirst($sub) }}</th>
                                                            @endforeach
                                                            <th>Total</th>
                                                            <th>Rank</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($students as $stu)
                                                        <tr>
                                                            <td>{{ $stu->enrollno }}</td>
                                                            <td class="sticky-col">{{ $stu->student_name }}</td>
                                                            @foreach($subjects as $sub)
                                                            @php
                                                            $mark = $stu->$sub;
                                                            $isAbsent = $mark == -1;
                                                            @endphp
                                                            <td @if($isAbsent) class="text-danger text-bold" @endif>
                                                                {{ $isAbsent ? '-A-' : ($mark ?? '-') }}
                                                            </td>
                                                            @endforeach
                                                            <td>{{ $stu->total ?? 0 }}</td>
                                                            <td>{{ $stu->student_rank ?? '-' }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            @else
                                            <p class="text-center">No records found for selected filters.</p>
                                            @endif

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
    </body>
</html>



