// Initialize Select2
function initSelect2() {
    $('#multiple-select-custom-field').select2({
        theme: 'bootstrap4',
        width: '100%',
        placeholder: $('#multiple-select-custom-field').data('placeholder'),
        closeOnSelect: false,
        tags: false
    });
}

// Add new assignment row
function addAssignmentRow() {
    let newRow = $('.assignment-row:first').clone();

    // Clear selected values
    newRow.find('select').val('');
    newRow.find('input').val('');

    // Add remove button if not exists
    if (newRow.find('.remove-row').length === 0) {
        newRow.append(`
            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-sm btn-danger remove-row">
                    <i class="fa-solid fa-xmark"></i> 
                </button>
            </div>
        `);
    }
    $('#assignment-rows').append(newRow);
}

// Remove assignment row
function removeAssignmentRow(element) {
    if ($('.assignment-row').length > 1) {
        $(element).closest('.assignment-row').remove();
    }
}

// Disable/Enable group select based on class
function toggleGroupSelect(e) {
    if (e.target.matches('select[name="class_ids[]"]')) {
        const row = e.target.closest('.assignment-row');
        const classValue = parseInt(e.target.value);
        const shortnameSelect = row.querySelector('select[name="shortname_ids[]"]');

        if (classValue >= 1 && classValue <= 10) {
            shortnameSelect.value = '';
            shortnameSelect.disabled = true;
        } else {
            shortnameSelect.disabled = false;
        }
    }
}

// Initialize all event listeners
function initTeacherForm() {
    // Select2
    initSelect2();

    // Add row
    $('#add-assignment-row').on('click', addAssignmentRow);

    // Remove row
    $(document).on('click', '.remove-row', function () {
        removeAssignmentRow(this);
    });

    // Toggle group select
    document.addEventListener('change', toggleGroupSelect);
}

// Run on document ready
$(document).ready(function () {
    initTeacherForm();
});

function handleShowList() {
    $('#show-list-btn').on('click', function (e) {
        e.preventDefault();

        let teacherSelect = $('#teacher-select');
        let teacherId = teacherSelect.val();

        if (!teacherId) {
            $.alert({
                title: 'Alert!',
                content: 'Please select a teacher first.',
                type: 'red',
            });
            return;
        }
        
        let url =  base_url + '/subject-allotment-list/' + teacherId;
        window.location.href = url;
    });
}
