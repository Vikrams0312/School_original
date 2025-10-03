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
        <title>Mark Entry</title>
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
                                <h5 class="card-header">MARK ENTRY</h5>
                                <div class="card-body">
                                    <form id="markEntryForm" method="POST" action="{{ url('mark-entry') }}">
                                        @csrf
                                        <div class="row m-3">
                                            <div class="col-md-3">
                                                <label for="exam" class="form-label">Select Exam</label>
                                                <select class="form-control" id="exam" name="exam" required>
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
                                                <select name="group" id="group" class="form-select" required="">
                                                    <option value="">Select Group</option>
                                                    @foreach($group_list as $grp)
                                                    <option value="{{ $grp->id }}">{{ $grp->group_short_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Section</label>
                                                <select class="form-control" name="section" id="section" required="">
                                                    <option value="">Select Section</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Subjects</label>
                                                <select class="form-control" name="subject" id="subject" required="">
                                                    <option value="">Select Subject</option>
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
                                            <div class="col-md-3 mt-4">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                    <div id="marks-table-container" class="table-responsive text-nowrap">
                                        @if(!empty($marks_table))
                                        {!! $marks_table !!}
                                        @else
                                        <div class="text-center alert-dark">Select the above details and submit</div>
                                        @endif
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
                    <!-- / Content wrapper -->
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
                // Initialize dropdowns
                initMarkEntrySelectors("{{ url('') }}");

                // Save Marks button
                $(document).on('click', '#saveMark', function () {
                    let marks = {};
                    let exam = $('#exam').val();
                    let standard = $('#standard').val();
                    let group = $('#group').val() || '';
                    let section = $('#section').val() || '';
                    let subject = $('#subject').val();
                    let academic_year = $('#academic_year').val();

                    if (!exam || !standard || !subject || !academic_year) {
                        alert('Please complete all form fields before saving marks.');
                        return;
                    }

                    $('.marks-input').each(function () {
                        let studentId = $(this).closest('tr').find('td:eq(0)').text(); // Enroll NO
                        let mark = $(this).val();
                        marks[studentId] = mark || '0';
                    });

                    if (Object.keys(marks).length === 0) {
                        alert('No marks entered to save.');
                        return;
                    }

                    $.ajax({
                        url: "{{ url('save-marks') }}",
                        type: 'POST',
                        data: {
                            exam: exam,
                            standard: standard,
                            group: group,
                            section: section,
                            subject: subject,
                            academic_year: academic_year,
                            marks: marks,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            alert('Marks saved successfully!');
                        },
                        error: function (xhr) {
                            console.error(xhr.responseText);
                            alert('Failed to save marks. Check console for details.');
                        }
                    });
                });

                // Render the marks table


                // Load Standards
                function loadStandards(examSelectId, standardSelectId, sectionSelectId, base_url) {
                    $('#' + examSelectId).on('change', function () {
                        var exam_id = $(this).val();
                        var $standard = $('#' + standardSelectId);
                        var $section = $('#' + sectionSelectId);

                        $standard.empty().append('<option value="">-- Select Standard --</option>');
                        $section.empty().append('<option value="">Select Section</option>');

                        if (exam_id) {
                            $.ajax({
                                url: base_url + '/get-standards/' + exam_id,
                                type: 'GET',
                                success: function (data) {
                                    if (data.length > 0) {
                                        $standard.prop('disabled', false);
                                        $.each(data, function (key, value) {
                                            $standard.append('<option value="' + value + '">' + value + '</option>');
                                        });
                                    } else {
                                        $standard.prop('disabled', true);
                                    }
                                },
                                error: function (xhr) {
                                    console.error(xhr.responseText);
                                    alert('Failed to load standards. Check console for error.');
                                }
                            });
                        } else {
                            $standard.prop('disabled', true);
                        }
                    });
                }

                // Load Sections
                function loadSections(standardSelectId, groupSelectId, sectionSelectId, subjectSelectId, base_url) {
                    $('#' + standardSelectId + ', #' + groupSelectId).on('change', function () {
                        var standard = $('#' + standardSelectId).val();
                        var group = $('#' + groupSelectId).val() || '';
                        var $section = $('#' + sectionSelectId);
                        var $subject = $('#' + subjectSelectId);

                        $section.empty().append('<option value="">Select Section</option>');
                        $subject.empty().append('<option value="">Select Subject</option>');

                        if (standard) {
                            var url = base_url + '/get-sections/' + standard;
                            if ([11, 12].includes(parseInt(standard))) {
                                url += '/' + group;
                            }

                            $.ajax({
                                url: url,
                                type: 'GET',
                                success: function (data) {
                                    if (data.length > 0) {
                                        $.each(data, function (key, value) {
                                            $section.append('<option value="' + value + '">' + value + '</option>');
                                        });
                                    }
                                },
                                error: function (xhr) {
                                    console.error(xhr.responseText);
                                    alert('Failed to load sections. Check console for error.');
                                }
                            });
                        }
                    });
                }

                // Load Subjects
                function loadSubjects(standardSelectId, groupSelectId, sectionSelectId, subjectSelectId, base_url) {
                    $('#' + standardSelectId + ', #' + groupSelectId + ', #' + sectionSelectId).on('change', function () {
                        var standard = $('#' + standardSelectId).val();
                        var group = $('#' + groupSelectId).val() || '';
                        var section = $('#' + sectionSelectId).val() || '';
                        var $subject = $('#' + subjectSelectId);

                        $subject.empty().append('<option value="">Select Subject</option>');

                        if (standard) {
                            var url = base_url + '/get-subjects/' + standard;
                            if ([11, 12].includes(parseInt(standard))) {
                                url += '/' + group;
                            }
                            if (section) {
                                url += '/' + section;
                            }

                            $.ajax({
                                url: url,
                                type: 'GET',
                                success: function (data) {
                                    if (data.length > 0) {
                                        $.each(data, function (key, value) {
                                            $subject.append('<option value="' + value.id + '">' + value.subject_name + '</option>');
                                        });
                                    }
                                },
                                error: function (xhr) {
                                    console.error(xhr.responseText);
                                    alert('Failed to load subjects. Check console for error.');
                                }
                            });
                        }
                    });
                }

                // Initialize all selectors
                function initMarkEntrySelectors(base_url) {
                    loadStandards('exam', 'standard', 'section', base_url);
                    loadSections('standard', 'group', 'section', 'subject', base_url);
                    loadSubjects('standard', 'group', 'section', 'subject', base_url);
                }
            });
            $('.mySelect').select2({
                tags: true, // allows custom values
                placeholder: "Enter mark", // ✅ your custom placeholder
                //allowClear: true     
            });
            // ✅ Force cursor to go into text box when opened
            $('.mySelect').on('select2:open', function () {
                setTimeout(() => {
                    document.querySelector('.select2-container--open .select2-search__field').focus();
                }, 100);
            });
        </script>
    </body>
</html>