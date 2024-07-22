function init_form(formId, actionUrl) {
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
                    window.location.href = 'index.php?page=home';
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