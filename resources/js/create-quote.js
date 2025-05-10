document.addEventListener("DOMContentLoaded", () => {
    /*
    * show / hide completed_date and expired_date fields depending on the quote_status
    * */
    const statusField = document.getElementById("quote_status");
    const completedDateField = document.getElementById("completed_date_field");
    const expiredDateField = document.getElementById("expired_date_field");

    const toggleDateFields = () => {
        const selectedStatus = statusField.value;

        if (selectedStatus === "completed") {
            completedDateField.classList.remove("hidden");
            expiredDateField.classList.add("hidden");
            document.getElementById("expired_date").value = "";
        } else if (selectedStatus === "expired") {
            expiredDateField.classList.remove("hidden");
            completedDateField.classList.add("hidden");
            document.getElementById("completed_date").value = "";
        }else{
            completedDateField.classList.add("hidden");
            expiredDateField.classList.add("hidden");
            document.getElementById("completed_date").value = "";
            document.getElementById("expired_date").value = "";
        }
    };

    toggleDateFields();

    statusField.addEventListener("change", toggleDateFields);
});
