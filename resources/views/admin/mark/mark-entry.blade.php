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
        <title>Mark Entry</title
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
                                    <form id="markEntryForm">
                                        <div class="row m-3">
                                            <div class="col-md-3">
                                                <label for="exam" class="form-label">Select Exam</label>
                                                <select class="form-control" id="exam" required>
                                                    <option value="">-- Select Exam --</option>
                                                    @foreach($exams as $exam)
                                                    <option value="{{ $exam->id }}">{{ $exam->exam_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <label for="standard" class="form-label">Select Standard</label>
                                                <select name="standard" class="form-control" id="standard" required>
                                                    <option value="">-- Select Standard --</option>
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <label for="group" class="form-label">Group</label>
                                                <select name="group" id="group" class="form-select">
                                                    <option value="">Select Group</option>
                                                    @foreach($group_list as $grp)
                                                    <option value="{{ $grp->id }}">{{ $grp->group_short_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <label class="form-label">Section</label>
                                                <select class="form-control" name="section" id="section">
                                                    <option value="">Select Section</option>
                                                    
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <label class="form-label">Subjects</label>
                                                <select class="form-control" name="subject" id="subject">
                                                    <option value="">Select Subject</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="academic_year" class="form-label">Academic Year</label>
                                                <select name="academic_year" id="academic_year" class="form-select">
                                                    @foreach($Academic_year as $year)
                                                    <option value="{{ $year->academic_year }}">{{ $year->academic_year }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 mt-4">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </form>

                                    <div id="marks-table-container" class="table-responsive text-nowrap">
                                        <div  class="text-center alert-dark">Select the above details and submit</div>      
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
        <script>
            $(document).ready(function () {

                // Initialize dropdowns via your existing functions
                initMarkEntrySelectors("{{ url('') }}");

                // On form submit
                $('#markEntryForm').on('submit', function (e) {
                    e.preventDefault();

                    let standard = $('#standard').val();
                    let group = $('#group').val();
                    let section = encodeURIComponent($('#section').val());
                    let subjectId = $('#subject').val();
                    let subjectName = $('#subject option:selected').text();

                    if (!standard || !subjectId) {
                        alert('Please select Standard and Subject.');
                        return;
                    }

                    let url = "{{ url('get-students') }}/" + standard;
                    if (group)
                        url += "/" + group;
                    if (section)
                        url += "/" + section;

                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function (students) {
                            renderMarksTable(students, subjectId, subjectName);
                        },
                        error: function (xhr) {
                            console.error(xhr.responseText);
                            alert('Failed to fetch students. Check console for error.');
                        }
                    });
                });

                function renderMarksTable(students, subjectId, subjectName) {
                    let html = `<h3 class="mb-3" align-item-center>${subjectName} Mark Entry</h3>
    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead class="table-light">
                <tr>
                    <th>Enroll.NO</th>
                    <th>Name</th>
                    <th>Mark</th>
                     <th>Total</th>
                </tr>
            </thead>
            <tbody>`;

                    students.forEach(function (student) {
                        html += `<tr>
            <td>${student.enrollno}</td>
            <td>${student.name}</td>
            <td><input type="number" class="form-control form-control-sm" style="width: 60px;" name="marks[${student.id}]" min="0"></td>
        </tr>`;
                    });

                    html += `</tbody>
        </table>
    </div>`;

                    $('#marks-table-container').html(html);
                }

            });
        </script>

    </body>
</html>

