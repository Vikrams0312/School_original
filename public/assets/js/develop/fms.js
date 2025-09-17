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

function deleteStudentType(element) {
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
                            url: base_url + '/deleteStudentType/' + id,
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

function deleteDepartment(element) {
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
                            url: base_url + '/deleteDepartment/' + id,
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

function deleteStudentFees(element) {
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
                            url: base_url + '/deleteStudentFees/' + id,
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