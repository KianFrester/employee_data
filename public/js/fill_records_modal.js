function openEditModal(data) {
    document.getElementById('edit_id').value = data.id;
    document.getElementById('edit_last_name').value = data.last_name;
    document.getElementById('edit_first_name').value = data.first_name;
    document.getElementById('edit_middle_name').value = data.middle_name;
    document.getElementById('edit_extensions').value = data.extensions;
    document.getElementById('edit_birthdate').value = data.birthdate;
    document.getElementById('edit_gender').value = data.gender;
    document.getElementById('edit_department').value = data.department;
    document.getElementById('edit_educational_attainment').value = data.educational_attainment;
    document.getElementById('edit_designation').value = data.designation;
    document.getElementById('edit_rate').value = data.rate;
    document.getElementById('edit_eligibility').value = data.eligibility;
    document.getElementById('edit_date_of_appointment').value = data.date_of_appointment;
    document.getElementById('edit_service_duration').value = data.service_duration;
    document.getElementById('edit_remarks').value = data.remarks;
}