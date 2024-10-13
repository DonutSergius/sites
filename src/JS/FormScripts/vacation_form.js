function init_form(formId, actionUrl) {

    var fieldVacationTime = document.querySelector(".field-vacation-time");
    var fieldDateStart = document.querySelector(".field-date-start");
    var fieldDateEnd = document.querySelector(".field-date-end");
    var fieldDateTimeStart = document.querySelector(".field-datetime-start");
    var fieldDateTimeEnd = document.querySelector(".field-datetime-end");

    var vacationType = document.getElementById("vacation-type");
    var vacationTime = document.getElementById("vacation-time");

    fieldDateStart.style.display = "block";
    fieldDateEnd.style.display = "block";

    fieldVacationTime.style.display = "none";

    fieldDateTimeStart.style.display = "none";
    fieldDateTimeEnd.style.display = "none";
    
    vacationType.addEventListener("change", function() {
        if (this.value === "paid") {
            fieldDateStart.style.display = "block";
            fieldDateEnd.style.display = "block";

            fieldVacationTime.style.display = "none";

            fieldDateTimeStart.style.display = "none";
            fieldDateTimeEnd.style.display = "none";

            vacationTime.value = "fullDay";
        } else {
            fieldVacationTime.style.display= "block";
        }
    });
    
    vacationTime.addEventListener("change", function(){
        if(this.value === "fullDay"){
            fieldDateStart.style.display = "block";
            fieldDateEnd.style.display = "block";

            fieldDateTimeStart.style.display = "none";
            fieldDateTimeEnd.style.display = "none";
        } else {
            fieldDateStart.style.display = "none";
            fieldDateEnd.style.display = "none";

            fieldDateTimeStart.style.display = "block";
            fieldDateTimeEnd.style.display = "block";
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