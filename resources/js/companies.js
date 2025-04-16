document.addEventListener("DOMContentLoaded", () => {
    document.getElementById('primary_contact_phone').addEventListener('input', function (e) {
        e.target.value = e.target.value.replace(/[^0-9]/g, ''); // Allow only digits
    });
});
