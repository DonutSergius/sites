function init_form(formId, actionUrl) {
    console.log('formElement:', formId);
    console.log('Action URL:', actionUrl);
    
        var vacationType = document.getElementById("vacation-type");
        var vacationTimeField = document.getElementById("vacation-time");

        var dateStartField = document.getElementById("date-start");
        var dateEndField = document.getElementById("date-end");

        var datetimeStartField = document.getElementById("datetime-start");
        var datetimeEndField = document.getElementById("datetime-end");

        dateStartField.style.display = "block";
        dateEndField.style.display = "block";
        vacationTimeField.style.display = "none";
        datetimeStartField.style.display = "none";
        datetimeEndField.style.display = "none";
        
        vacationType.addEventListener("change", function() {
                          
            if (this.value === "paid") {
                dateStartField.style.display = "block";
                dateEndField.style.display = "block";
                vacationTimeField.style.display = "none";
                datetimeStartField.style.display = "none";
                datetimeEndField.style.display = "none";
            } else {

            
                dateStartField.style.display = "none";
                dateEndField.style.display = "none";
                vacationTimeField.style.display = "block";
                datetimeStartField.style.display = "block";
                datetimeEndField.style.display = "block";
            }
        });
        

        var form = document.getElementById(formId);
        if (form) {
            console.log('sdfs');
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
                    console.log('test');
                    if (data.error) {
                        if (errorElement) errorElement.innerText = data.error;
                        if (confirmElement) confirmElement.innerText = "";
                    } else if (data.confirm) {
                        if (confirmElement) confirmElement.innerText = data.confirm;
                        if (errorElement) errorElement.innerText = "";
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                    var errorElement = document.querySelector(".message-error");
                    if (errorElement) errorElement.innerText = "Error: " + error.message;
                });
            });
        }

}