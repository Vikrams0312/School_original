function handleGroupDropdown(row) {
    let classValue = parseInt(row.find('select[name="class_ids[]"]').val());
    let groupSelect = row.find('select[name="shortname_ids[]"]');

    if (classValue >= 1 && classValue <= 10) {
        groupSelect.val('');        // clear selection
        
    } else {
        groupSelect.prop('disabled', false); // enable dropdown for class 11,12
    }
}


    // Add row function
    function addAssignmentRow() {
        let newRow = $('#row-template').clone().removeClass('d-none').removeAttr('id');
        newRow.find('select').prop('required', true);
        newRow.find('input[type="hidden"]').remove();

        // Handle Group for default/new row
        handleGroupDropdown(newRow);

        // Add remove button
        newRow.append(`
            <div class="col-md-1 d-flex align-items-end mt-2">
                <button type="button" class="btn btn-sm btn-danger remove-row">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        `);

        $('#assignment-rows').append(newRow);
    }

    // Teacher change → load allotments
    $('#teacher-select').on('change', function () {
        let teacherId = $(this).val();
        $('#assignment-rows').empty();

        if (!teacherId)
            return;

        $.get(base_url + '/get-teacher-allotments/' + teacherId, function (data) {
            if (data.length === 0) {
                addAssignmentRow(); // Empty row for fresh teacher
            } else {
                data.forEach(allot => {
                    let newRow = $('#row-template').clone().removeClass('d-none').removeAttr('id');
                    newRow.find('select[name="class_ids[]"]').val(allot.standard);
                    newRow.find('select[name="shortname_ids[]"]').val(allot.group_name_id);
                    newRow.find('select[name="subject_ids[]"]').val(allot.subject_id);
                    newRow.find('select[name="sections[]"]').val(allot.section);
                    newRow.find('select[name="teacher_types[]"]').val(allot.teacher_type);
                    newRow.find('select[name="academic_years[]"]').val(allot.academic_year);

                    // Handle Group for loaded row
                    handleGroupDropdown(newRow);

                    // Hidden allotment id → used to update
                    newRow.append(`<input type="hidden" name="allotment_ids[]" value="${allot.id}">`);

                    // Add remove button
                    newRow.append(`
                        <div class="col-md-1 d-flex align-items-end mt-2">
                            <button type="button" class="btn btn-sm btn-danger remove-row " data-id="${allot.id}">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    `);

                    $('#assignment-rows').append(newRow);
                });
            }
        });
    });

    // Add row button
    $('#add-row').on('click', function () {
        addAssignmentRow();
    });

    // Remove row
    $(document).on('click', '.remove-row', function () {
        let allotmentId = $(this).data('id');
        let row = $(this).closest('.assignment-row');

        $.confirm({
            icon: 'fa fa-warning',
            title: 'Confirm Deletion',
            content: 'Are you sure you want to delete this allotment?',
            buttons: {
                confirm: {
                    text: 'Yes, Delete!',
                    btnClass: 'btn-red',
                    action: function () {
                        if (allotmentId) {
                            $.ajax({
                                url: `${base_url}/subjectAllotmentDelete/${allotmentId}`,
                                method: 'GET', // Or 'DELETE' if your route accepts it
                                headers: {
                                    'Accept': 'application/json'
                                },
                                success: function (data) {
                                    if (data.status === 'success') {
                                        row.remove();
                                        $.alert('Allotment deleted successfully.');
                                    } else {
                                        $.alert('Error: ' + (data.message || 'Could not delete allotment.'));
                                    }
                                },
                                error: function () {
                                    $.alert('An unexpected error occurred.');
                                }
                            });
                        } else {
                            row.remove(); // for unsaved rows
                        }
                    }
                },
                cancel: {
                    text: 'Cancel',
                    action: function () {
                        // Do nothing
                    }
                }
            }
        });
    });

    // Handle Class change → disable/enable Group
    $(document).on('change', 'select[name="class_ids[]"]', function() {
        let row = $(this).closest('.assignment-row');
        handleGroupDropdown(row);
    });