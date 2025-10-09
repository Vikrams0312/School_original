

$(document).ready(function () {
    // Initialize dropdowns
    initMarkEntrySelectors(base_url);

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
            url: base_url + '/save-marks',
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
            success: function () {
                alert('Marks saved successfully!');
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert('Failed to save marks. Check console for details.');
            }
        });
    });

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
                        alert('Failed to load standards.');
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
                        alert('Failed to load sections.');
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
                        alert('Failed to load subjects.');
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

// Select2 initialization
$('.mySelect').select2({
    tags: true,
    placeholder: "Enter mark"
});

$('.mySelect').on('select2:open', function () {
    setTimeout(() => {
        document.querySelector('.select2-container--open .select2-search__field').focus();
    }, 100);
});

