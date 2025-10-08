
function initMarkEntryScript(base_url) {
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
                let studentId = $(this).closest('tr').find('td:eq(0)').text(); // Enroll No
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

        // Initialize Select2 for mark inputs
        $('.mySelect').select2({
            tags: true,
            placeholder: "Enter mark",
        });

        // Focus on text box when Select2 opens
        $('.mySelect').on('select2:open', function () {
            setTimeout(() => {
                document.querySelector('.select2-container--open .select2-search__field').focus();
            }, 100);
        });

        // ---- Internal helper functions ----
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
                                $.each(data, function (_, value) {
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
                                $.each(data, function (_, value) {
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
                                $.each(data, function (_, value) {
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

        function initMarkEntrySelectors(base_url) {
            loadStandards('exam', 'standard', 'section', base_url);
            loadSections('standard', 'group', 'section', 'subject', base_url);
            loadSubjects('standard', 'group', 'section', 'subject', base_url);
        }
    });
}


function resetFormOnSuccess(filterFormId, groupId) {
    const filterForm = document.getElementById(filterFormId);
    const group = document.getElementById(groupId);

    if (filterForm) {
        filterForm.reset();
    }
    if (group) {
        group.disabled = true;
    }
    const subjectsBlock = document.querySelector(".mt-3");
    if (subjectsBlock) {
        subjectsBlock.remove();
    }
}

function clearSubjectsOnChange(elements) {
    function clearSubjects() {
        const subjectsBlock = document.querySelector(".mt-3");
        if (subjectsBlock) {
            subjectsBlock.remove();
        }
    }

    elements.forEach(el => {
        if (el) {
            el.addEventListener("change", clearSubjects);
        }
    });
}

function toggleGroupOnClassChange(standardId, groupId) {
    const standard = document.getElementById(standardId);
    const group = document.getElementById(groupId);

    if (!standard || !group) return;

    standard.addEventListener("change", function () {
        const value = parseInt(this.value);
        if (!isNaN(value) && value <= 10) {
            group.value = "";
            group.disabled = true;
        } else {
            group.disabled = false;
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    const filterForm = document.getElementById("filterForm");
    const standard = document.getElementById("standard");
    const group = document.getElementById("group");
    const year = document.getElementById("academic_year");

    // ✅ Case 1: Reset form after success
    if (document.body.dataset.success === "true") {
        resetFormOnSuccess("filterForm", "group");
    }

    // ✅ Case 2: Clear subjects when dropdown changes
    clearSubjectsOnChange([standard, group, year]);

    // ✅ Case 3: Toggle group dynamically
    toggleGroupOnClassChange("standard", "group");
});


function getPaymentHistory(element){
    var form=$(element).parents('form');
    var regno = $(form).find("#register_number").val();
    var facademic = $(form).find("#fees_academic_year").val();
    $.ajax({
        type: 'get',
        url: base_url + '/getPaymentHistory' + '/' + regno+'/'+facademic,
        async: false,
        success: function (resp) {
            var info = $.parseJSON(resp);
            if (info.status == 1) {
                $('#payment_history').html($.parseHTML(info.html));
            } else {
                $('#payment_history').html('');
                $.alert(info.message);
            }
        }
    });
}

function getStudentDetailsForPaymentHistory(element){
   var regno = $(element).parents('form').find('#register_number').val();
       if (regno == '') {
        $alert('Please enter register number');
    } else {
        $.ajax({
            type: 'get',
            url: base_url + '/getStudentDetailsForPaymentHistory' + '/' + regno,
            async: false,
            success: function (resp) {
                var info = $.parseJSON(resp);
                if (info.status == 1) {
                    $('#student_details').html($.parseHTML(info.html));
                } else {
                    $('#student_details').html('');
                    $.alert(info.message);
                }
            }
        });

    }
}

function getConfermation(element) {
    var resp = 0;
    $.confirm({
        title: 'Warning',
        content: '<p>Please ensure your payment one you click continue you can\'t cancel your payment.</p><p>Are you sure poceed to pay?</p>',
        useBootstrap: false,
        buttons: {
            continue: {
                text: 'continue',
                btnClass: 'btn btn-info',
                action: function () {                    
                    $(element).parents('form').submit();
                }
            },
            cancel: {
                text: 'cancel',
                btnClass: 'btn btn-danger',
                action: function () {

                }
            }
        }
    });
    return false;
}
function showBalance(element) {
    //var total_text = $(element).parent('div').prev('div').find('.total_amount').text();
    //var total = parseInt(total_text);
    var paying = $(element).val();
    var databalance = parseInt($(element).attr('data-balance'));
    console.log(databalance);

    var paying_amount = '';
    if (paying == '') {
        paying_amount = 0;
    } else {
        paying_amount = parseInt(paying);
    }
    var balance = databalance - paying_amount;
    if (paying_amount > databalance) {
        $(element).next('span.errormsg').html('Entered amount is grater than balance amount <i class="bx bx-rupee"></i>' + databalance);
        $(element).parent('div').next('div').find('.balance_amount').text(databalance);

    } else {
        $(element).next('span.errormsg').text('');
        $(element).parent('div').next('div').find('.balance_amount').text(balance);
    }
    var tot_bal_amount = 0;
    $('.balance_amount').each(function () {
        // trim() function is used to remove the white space front and back   
        tot_bal_amount += parseInt($(this).text().trim());
    });
    $('#all_balance').text(tot_bal_amount);
    var all_paying_amount = 0;
    $('.paying_amount').each(function () {
        var amtext = $(this).val();
        if (amtext !== '') {
            all_paying_amount += parseInt(amtext);
        }
    });
    $('#all_paying_amount').text(all_paying_amount);
    $('#total_paying_amount').val(all_paying_amount);
    var error = '';
    $('.errormsg').each(function () {
        if ($(this).text() !== '') {
            error = $(this).text();
            return false;
        }
    });
    if (error == '' && all_paying_amount !== 0) {
        $('#payment_submit').removeAttr('disabled');
    } else {
        $('#payment_submit').attr('disabled', '');
    }
}
function selectAll(element) {
    $(element).parents('table').find('tbody input:checkbox').prop('checked', $(element).prop("checked"));
}
function numberValidation(element, ndigit) {
    var phone = $(element).val();
    if (phone.length > ndigit) {
        $(element).val(phone.substring(0, ndigit));
    }
}
function nextNumber(element, acount) {
    var acyearfrom = $(element).val();
    var newval = '';
    if (acyearfrom !== '') {
        newval = parseInt(acyearfrom) + parseInt(acount);
    }
    $(document).find('#academic_year_to').val(newval);
}
function generateStudentAcademicYears(element) {
    var yearstr = $(element).val();
    var yearsList = yearstr.split('-');
    var year = parseInt(yearsList[0]);
    var str = '<option value="">SELECT YEAR</option>';
    str += '<option value="1_' + year + '-' + (year + 1) + '">1st Year (' + year + '-' + (year + 1) + ')</option>';
    str += '<option value="2_' + (year + 1) + '-' + (year + 2) + '">2nd year (' + (year + 1) + '-' + (year + 2) + ')</option>';
    str += '<option value="3_' + (year + 2) + '-' + (year + 3) + '">3rd Year (' + (year + 2) + '-' + (year + 3) + ')</option>';
    str += '<option value="4_' + (year + 3) + '-' + (year + 4) + '">4th Year (' + (year + 3) + '-' + (year + 4) + ')</option>';
    $('#student_year').html(str);
}

function getStudentList(element) {
    var stypeid = $(element).parents('form').find("#student_type").val();
    var departmentid = $(element).parents('form').find("#department_id").val();
    var stdbatch = $(element).parents('form').find("#student_batch").val();
    var stdyear = $(element).parents('form').find("#student_year").val();

    if (stdbatch == '') {
        $.alert('Please select student batch');
        return false;
    } else if (stdyear == '') {
        $.alert('Please select student Year');
        return false;
    } else if (departmentid == '') {
        $.alert('Please select department');
        return false;
    } else if (stypeid == '') {
        $.alert('Please select student type');
        return false;
    } else {
        $.ajax({
            type: 'get',
            url: base_url + '/getStudentList/' + stdbatch + '/' + stdyear + '/' + stypeid + '/' + departmentid,
            async: false,
            success: function (resp) {
                //console.log(resp);
                var info = $.parseJSON(resp);
                if (info.status == 1) {
                    $('#student_type_result').html($.parseHTML(info.html));
                }
            }
        });
    }
}

function getPaymentFeesType(element) {
    var stypeid = $(element).val();
    var register_number = $(element).parents('.row').prev('.row').find('#register_number').val();
    if (register_number == '') {
        $.alert('Please enter register number');
        $(element).parents('.row').prev('.row').find('#register_number').css({'border-color': 'red'});
        return false;
    } else {
        $.ajax({
            type: 'get',
            url: base_url + '/getPaymentFeesType/' + stypeid + '/' + register_number,
            async: false,
            success: function (resp) {
                var info = $.parseJSON(resp);
                if (info.status == 1) {
                    $('#fees_types_result').html($.parseHTML(info.html));
                } else {
                    $.alert(info.message);

                }
            }
        });
    }


}

function getFeesType(element, id = 0) {
    var stypeid = $(element).val();
    $.ajax({
        type: 'get',
        url: base_url + '/getFeesType/' + stypeid + '/' + id,
        async: false,
        success: function (resp) {
            var info = $.parseJSON(resp);
            if (info.status == 1) {
                $('#fees_type_result').html($.parseHTML(info.html));
            } else {
                $.alert(info.message);
            }
        }
    });
}

function getStudentDetails(element) {
    $('#student_details').html('');
    $('#fees_details').html('');
    var regno = $(element).parents('form').find("#register_number").val();
    if (regno == '') {
        $alert('Please enter register number');
    } else {
        $.ajax({
            type: 'get',
            url: base_url + '/getStudentDetails' + '/' + regno,
            async: false,
            success: function (resp) {
                var info = $.parseJSON(resp);
                if (info.status == 1) {
                    $('#student_details').html($.parseHTML(info.html));
                } else {
                    $('#student_details').html('');
                    $.alert(info.message);
                }
            }
        });

    }
}
function getFeesDetails(element) {
    var form = $(element).parents('form');
    var register_number = $(form).find("#register_number").val();
    var department_id = $(form).find("#department_id").val();
    var student_type_id = $(form).find("#student_type_id").val();
    var facademic_year = $(form).find("#fees_academic_year").val();
    var facyear = facademic_year.split('_');
    var study_year = facyear[0];
    var fees_academic_year = facyear[1];
    if (register_number == '') {
        $alert('Please enter register number');
    } else {
        $.ajax({
            type: 'get',
            url: base_url + '/getFeesDetails' + '/' + register_number + '/' + department_id + '/' + student_type_id + '/' + fees_academic_year + '/' + study_year,
            async: false,
            success: function (resp) {
                var info = $.parseJSON(resp);
                if (info.status == 1) {
                    $('#feesErrorAlert').text('');
                    $('#fees_details').html($.parseHTML(info.html));
                } else {
                    $('#fees_details').html('');
                    $('#feesErrorAlert').text(info.message);
                    //$.alert(info.message);
                }
            }
        });

    }
}

function deleteFeesCategory(element) {


    var cat = $(element).parents('tr').find('td:nth-child(3)').text();
    $.confirm({
        animation: 'zoom',
        closeAnimation: 'scale',
        title: 'Delete',
        content: 'Are you sure to delete \"' + cat + '\"?',
        useBootstrap: false,
        onOpenBefore: function () {
            // Add zoom class before opening
            this.$content.addClass('zoom');
        },
        buttons: {
            delete: {
                text: 'delete',
                btnClass: 'btn-primary',
                action: function () {
                    $('.loader').show();
                    setTimeout(function () {
                        var id = $(element).attr('data-id');
                        $.ajax({
                            type: 'get',
                            url: base_url + '/deleteFeesCategory/' + id,
                            async: false,
                            success: function (resp) {
                                var info = $.parseJSON(resp);
                                if (info.status == 1) {
                                    $('.loader').hide();
                                    $.alert({

                                        type: 'green',
                                        icon: 'bx bx-check',
                                        title: "Success",
                                        content: '\"' + cat + '\" deleted successfully',
                                        buttons: {
                                            close: {
                                                text: 'close',
                                                btnClass: 'btn-primary',
                                                action: function () {
                                                }
                                            }
                                        }
                                    });
                                    $(element).closest('tr').remove();
                                } else {
                                    $.alert(info.message);
                                }

                            }
                        });
                    }, 100);
                }
            },
            cancel: {
                text: 'cancel',
                btnClass: 'btn-dark',
                action: function () {

                }
            }
        }
    });
    return false;


}

function deleteTeacher(element) {
    var cat = $(element).parents('tr').find('td:nth-child(3)').text();
    var id = $(element).attr('data-id');

    $.confirm({
      
        title: 'Delete',
        content: 'Are you sure to delete "' + cat + '"?',
        useBootstrap: false,
        buttons: {
            delete: {
                text: 'Delete',
                btnClass: 'btn-primary',
                action: function () {
                    $('.loader').show();
                    setTimeout(function () {
                        $.ajax({
                            type: 'GET',
                            url: base_url + '/deleteTeacher/' + id,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (resp) {
                                var info = (typeof resp === "string") ? $.parseJSON(resp) : resp;

                                $('.loader').hide();
                                if (info.status == 1) {
                                    $.alert({
                                        type: 'green',
                                        icon: 'bx bx-check',
                                        title: "Success",
                                        content: '"' + cat + '" deleted successfully',
                                    });
                                    $(element).closest('tr').remove();
                                } else {
                                    $.alert(info.message);
                                }
                            },
                            error: function (xhr) {
                                $('.loader').hide();
                                $.alert("Error: " + xhr.statusText);
                            }
                        });
                    }, 100);
                }
            },
            cancel: {
                text: 'Cancel',
                btnClass: 'btn-dark'
            }
        }
    });

    return false;
}


function deleteGroup(element) {
    var cat = $(element).parents('tr').find('td:nth-child(3)').text();
    $.confirm({
        title: 'Delete',
        content: 'Are you sure to delete \"' + cat + '\"?',
        useBootstrap: false,
        buttons: {
            delete: {
                text: 'delete',
                btnClass: 'btn-primary',
                action: function () {
                    $('.loader').show();
                    setTimeout(function () {
                        var id = $(element).attr('data-id');
                        $.ajax({
                            type: 'get',
                            url: base_url + '/deleteGroup/' + id,
                            async: false,
                            success: function (resp) {

                                var info = $.parseJSON(resp);
                                if (info.status == 1) {
                                    $('.loader').hide();
                                    $.alert({
                                        type: 'green',
                                        icon: 'bx bx-check',
                                        title: "Success",
                                        content: '\"' + cat + '\" deleted successfully',
                                        buttons: {
                                            close: {
                                                text: 'close',
                                                btnClass: 'btn-primary',
                                                action: function () {
                                                }
                                            }
                                        }
                                    });
                                    $(element).closest('tr').remove();
                                } else {
                                    $.alert(info.message);
                                }

                            }
                        });
                    }, 600);
                }
            },
            cancel: {
                text: 'cancel',
                btnClass: 'btn-dark',
                action: function () {

                }
            }

        }
    });
    return false;
}

function deleteStudent(element) {
    var cat = $(element).parents('tr').find('td:nth-child(3)').text();
    $.confirm({
        title: 'Delete',
        content: 'Are you sure to delete \"' + cat + '\" student detail?',
        useBootstrap: false,
        buttons: {
            delete: {
                text: 'delete',
                btnClass: 'btn-primary',
                action: function () {
                    $('.loader').show();
                    setTimeout(function () {
                        var id = $(element).attr('data-id');
                        $.ajax({
                            type: 'get',
                            url: base_url + '/deleteStudent/' + id,
                            async: false,
                            success: function (resp) {

                                var info = $.parseJSON(resp);
                                if (info.status == 1) {
                                    $('.loader').hide();
                                    $.alert({
                                        type: 'green',
                                        icon: 'bx bx-check',
                                        title: "Success",
                                        content: '\"' + cat + '\"student detail deleted successfully',
                                        buttons: {
                                            close: {
                                                text: 'close',
                                                btnClass: 'btn-primary',
                                                action: function () {
                                                }
                                            }
                                        }
                                    });
                                    $(element).closest('tr').remove();
                                } else {
                                    $.alert(info.message);
                                }

                            }
                        });
                    }, 400);
                }
            },
            cancel: {
                text: 'cancel',
                btnClass: 'btn-dark',
                action: function () {

                }
            }

        }
    });
    return false;
}

function deleteSubject(element) {
    var str = '<p>Are you sure to delete?</p>';
    str += '<table class="table table-bordered">';
    $(element).parents('tr').find('td').each(function (sno) {
        if (sno > 0 && sno < 5) {
            str += '<tr>';
            str += '<td>' + $(this).parents('table').find('thead').find('th').eq(sno).text() + '</td>';
            str += '<td>' + $(this).text() + '</td>';
            str += '</tr>';
        }
    });
    str += '</table>';
    $.confirm({
        title: 'Delete',
        content: str,
        useBootstrap: false,
        buttons: {
            delete: {
                text: 'delete',
                btnClass: 'btn-primary',
                action: function () {
                    $('.loader').show();
                    setTimeout(function () {
                        var id = $(element).attr('data-id');
                        $.ajax({
                            type: 'get',
                            url: base_url + '/deleteSubject/' + id,
                            async: false,
                            success: function (resp) {

                                var info = $.parseJSON(resp);
                                if (info.status == 1) {
                                    $('.loader').hide();
                                    $.alert({
                                        type: 'green',
                                        icon: 'bx bx-check',
                                        title: "Success",
                                        content: 'Deleted successfully',
                                        buttons: {
                                            close: {
                                                text: 'close',
                                                btnClass: 'btn-primary',
                                                action: function () {
                                                }
                                            }
                                        }
                                    });
                                    $(element).closest('tr').remove();
                                } else {
                                    $.alert(info.message);
                                }

                            }
                        });
                    }, 400);
                }
            },
            cancel: {
                text: 'cancel',
                btnClass: 'btn-dark',
                action: function () {

                }
            }

        }
    });
    return false;
}
function applyAcademicYearMask() {
    $('#academic_year').inputmask("9999-9999", {
        placeholder: "____-____",
        showMaskOnFocus: true,
        showMaskOnHover: false,
        definitions: {
            '9': {
                validator: "[0-9]", // Only digits allowed
            }
        },
        clearIncomplete: true
    });
}

$(document).ready(function () {
    applyAcademicYearMask();
        // Reapply the mask after adding a new row
    $('#add-assignment-row').on('click', function () {
        // Use setTimeout to ensure the new row is in the DOM
        setTimeout(function () {
            applyAcademicYearMask();
        }, 100);
    });
});

function deleteDesignation(element) {
    var name = $(element).parents('tr').find('td:nth-child(3)').text();
    $.confirm({
        title: 'Delete',
        content: 'Are you sure you want to delete the designation: <b>' + name + '</b>?',
        useBootstrap: false,
        buttons: {
            delete: {
                text: 'Delete',
                btnClass: 'btn-primary',
                action: function () {
                    $('.loader').hide();
                    setTimeout(function () {
                        var id = $(element).attr('data-id');

                        $.ajax({
                            type: 'GET',
                            url: base_url + '/delete-designation/' + id,
                            async: false,
                            success: function (resp) {
                                $('.loader').hide();
                                var info = typeof resp === 'object' ? resp : $.parseJSON(resp);

                                if (info.status == 1) {
                                    $.alert({
                                        type: 'green',
                                        icon: 'bx bx-check',
                                        title: "Success",
                                        content: 'Designation deleted successfully.',
                                        buttons: {
                                            close: {
                                                text: 'Close',
                                                btnClass: 'btn-primary',
                                                action: function () {}
                                            }
                                        }
                                    });
                                    $(element).closest('tr').remove();
                                } else {
                                    $.alert(info.message || 'Failed to delete the designation.');
                                }
                            },
                            error: function () {
                                $('.loader').hide();
                                $.alert('Server error occurred.');
                            }
                        });

                    }, 400);
                }
            },
            cancel: {
                text: 'Cancel',
                btnClass: 'btn-dark',
                action: function () {}
            }
        }
    });
    return false;
}
function applyDateMask() {
    $('.join_date').inputmask('99-99-9999', { placeholder: "dd-mm-yyyy" });
}

$(document).ready(function(){
    applyDateMask();
});
 function toggleGroup() {
                let standard = document.getElementById("standard").value;
                let group = document.getElementById("group");

                if (parseInt(standard) <= 10) {
                    group.disabled = true;
                    group.value = ""; // clear selection
                } else {
                    group.disabled = false;
                }
            }