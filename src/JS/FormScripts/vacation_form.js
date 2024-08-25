function init_form(formId, actionUrl) {
    var vacationType = document.getElementById("vacation-type");
    var vacationTime = document.getElementById("vacation-time");
    var labelVacationTime = document.getElementById("field-vacation-time")

    var dateStartField = document.getElementById("date-start");
    var dateEndField = document.getElementById("date-end");
    var labelStartField = document.getElementById("field-date-start")
    var labelEndField = document.getElementById("field-date-end")

    var datetimeStartField = document.getElementById("datetime-start");
    var datetimeEndField = document.getElementById("datetime-end");
    var labelDatetimeStartField  = document.getElementById("field-datetime-start")
    var labelDatetimeEndField = document.getElementById("field-datetime-end")

    dateStartField.style.display = "block";
    dateEndField.style.display = "block";
    labelStartField.style.display = "block";
    labelEndField.style.display = "block";

    vacationTime.style.display = "none";
    labelVacationTime.style.display = "none";

    datetimeStartField.style.display = "none";
    datetimeEndField.style.display = "none";
    labelDatetimeStartField.style.display = "none";
    labelDatetimeEndField.style.display = "none";
    
    vacationType.addEventListener("change", function() {
        if (this.value === "paid") {
            dateStartField.style.display = "block";
            dateEndField.style.display = "block";
            labelStartField.style.display = "block";
            labelEndField.style.display = "block";

            vacationTime.style.display = "none";
            labelVacationTime.style.display = "none";

            datetimeStartField.style.display = "none";
            datetimeEndField.style.display = "none";
            labelDatetimeStartField.style.display = "none";
            labelDatetimeEndField.style.display = "none";
        } else {
            labelVacationTime.style.display = "block";
            vacationTime.style.display = "block";

        }
    });
    
    vacationTime.addEventListener("change", function(){
        if(this.value === "fullDay"){
            dateStartField.style.display = "block";
            dateEndField.style.display = "block";
            labelStartField.style.display = "block";
            labelEndField.style.display = "block";

            datetimeStartField.style.display = "none";
            datetimeEndField.style.display = "none";
            labelDatetimeStartField.style.display = "none";
            labelDatetimeEndField.style.display = "none";
        } else {
            dateStartField.style.display = "none";
            dateEndField.style.display = "none";
            labelStartField.style.display = "none";
            labelEndField.style.display = "none";

            datetimeStartField.style.display = "block";
            datetimeEndField.style.display = "block";
            labelDatetimeStartField.style.display = "block";
            labelDatetimeEndField.style.display = "block";
        }
    });

    var form = document.getElementById(formId);
    if (form) {
        form.addEventListener("submit", function (event) {
            event.preventDefault();
            var formData = new FormData(this);
            fetch(actionUrl, {
                method: "POST",
                body: formData,
            })
            .then((response) => response.json())
            .then((data) => {
                var errorElement = document.querySelector(".message-error");
                var confirmElement = document.querySelector(".message-confirm");
               
                if (data.error) {
                    confirmElement.style.display = "none";
                    errorElement.style.display = "block";
                    if (errorElement) errorElement.innerText = data.error;
                    if (confirmElement) confirmElement.innerText = "";
                } else if (data.confirm) {
                    confirmElement.style.display = "block";
                    errorElement.style.display = "none";
                    if (confirmElement) confirmElement.innerText = data.confirm;
                    if (errorElement) errorElement.innerText = "";
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                var errorElement = document.querySelector(".message-error");
                errorElement.style.display = "block";
                errorElement.innerText = "Error: " + error.message;
            });
        });
    }
}