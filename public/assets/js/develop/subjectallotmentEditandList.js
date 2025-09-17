function deleteAllotment(el) {
    const allotmentId = $(el).data('id');

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
                                    // Remove the row from the table
                                    $(el).closest('tr').remove();
                                    $.alert('Allotment deleted successfully.');
                                } else {
                                    $.alert('Error: ' + (data.message || 'Could not delete allotment.'));
                                }
                            },
                            error: function () {
                                $.alert('An unexpected error occurred.');
                            }
                        });
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

    return false; // Prevent default action if it's a link
}

document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('assignment-rows');
    const addRowBtn = document.getElementById('add-row');
    const form = document.getElementById('allotment-form');

    // -----------------------------
    // Function to toggle Group select
    // -----------------------------
    function toggleGroupSelect(row) {
        const classSelect = row.querySelector('.class-select');
        const groupSelect = row.querySelector('.group-select');
        if (!classSelect || !groupSelect)
            return;

        const classValue = parseInt(classSelect.value);
        if (classValue === 11 || classValue === 12) {
            groupSelect.disabled = false;
        } else {
            groupSelect.disabled = false;
            groupSelect.value = "";
        }
    }

    // Initialize existing rows
    container.querySelectorAll('.assignment-row').forEach(row => {
        toggleGroupSelect(row);
        row.querySelector('.class-select').addEventListener('change', () => toggleGroupSelect(row));
    });

    // -----------------------------
    // Add new row
    // -----------------------------
    // -----------------------------
    // Add new row
    // -----------------------------
    addRowBtn.addEventListener('click', function () {
        const firstRow = container.querySelector('.assignment-row');
        const newRow = firstRow.cloneNode(true);

        // Clear values in inputs/selects
        newRow.querySelectorAll('input, select').forEach(el => {
            if (el.name.includes('[]')) {
                el.value = '';
            }
        });

        // Clear the allotment_id field so this is treated as a new entry
        const allotmentIdInput = newRow.querySelector('input[name="allotment_ids[]"]');
        if (allotmentIdInput) {
            allotmentIdInput.value = '';
        }

        container.appendChild(newRow);
        toggleGroupSelect(newRow);

        // Attach change listener for class -> group toggle
        newRow.querySelector('.class-select').addEventListener('change', () => toggleGroupSelect(newRow));
    });

    // -----------------------------
    // Remove row
    // -----------------------------
   container.addEventListener('click', function (e) {
    let target = e.target;

    // If clicked element is the icon, find the button
    if (!target.classList.contains('remove-row')) {
        target = target.closest('.remove-row');
    }

    if (target && target.classList.contains('remove-row')) {
        const row = target.closest('.assignment-row');
        const allotmentId = row.querySelector('input[name="allotment_ids[]"]').value;

        $.confirm({
            icon: 'fa fa-warning',
            title: 'Confirm!',
            content: 'Do you want to remove this allotment?',
            buttons: {
                confirm: {
                    text: 'Yes, remove it!',
                    btnClass: 'btn-red',
                    action: function () {
                        if (allotmentId) {
                            $.ajax({
                                url: `${base_url}/subjectAllotmentDelete/${allotmentId}`,
                                method: 'GET',
                                headers: {
                                    'Accept': 'application/json'
                                },
                                success: function (data) {
                                    if (data.status === 'success') {
                                        row.remove();
                                        $.alert('Allotment has been removed.');
                                    } else {
                                        $.alert('Error: ' + (data.message || 'Could not remove allotment.'));
                                    }
                                },
                                error: function () {
                                    $.alert('An unexpected error occurred.');
                                }
                            });
                        } else {
                            row.remove();
                            $.alert('Allotment has been removed.');
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
    }
});

    // -----------------------------
    // AJAX form submission
    // -----------------------------
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
                .then(response => {
                    if (!response.ok)
                        throw new Error('Server error');
                    return response.json();
                })
                .then(data => {
                    if (data.status === 'success') {
                        // Show success alert
                        const alertBox = document.createElement('div');
                        alertBox.className = 'alert alert-success';
                        alertBox.innerText = data.message;
                        form.prepend(alertBox);

                        // Redirect after 1 second
                        setTimeout(() => {
                            if (data.redirect) {
                                window.location.href = data.redirect;
                            } else {
                                window.location.href = '/subject-allotment-list';
                            }
                        }, 1000);
                    } else {
                        alert(data.message || 'An error occurred.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An unexpected error occurred: ' + error.message);
                });
    });
});
         
         
$(document).ready(function () {
    // Apply input mask to all academic_years[] fields
    function applyAcademicYearMask() {
        $('input[name="academic_years[]"]').inputmask("9999-9999", {
            placeholder: "____-____",
            showMaskOnFocus: true,
            showMaskOnHover: false,
            definitions: {
                '9': {
                    validator: "[0-9]",
                }
            },
            clearIncomplete: true
        });
    }

    // Initially apply the mask
    applyAcademicYearMask();

    // Reapply the mask after adding a new row
    $('#add-row').on('click', function () {
        // Use setTimeout to ensure the new row is in the DOM
        setTimeout(function () {
            applyAcademicYearMask();
        }, 100);
    });
});