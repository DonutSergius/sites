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
                .then((response) => response.json()) // Обробляємо JSON відповідь
                .then((data) => {
                    console.log('Data received:', data); // Логування отриманих даних
                    displayResult(data); // Виклик функції для відображення результату
                })
                .catch((error) => {
                    console.error("Error:", error);
                });

        });
    }
}

function displayResult(data) {
    var tableBody = document.querySelector('.table-home-page-vacation-list tbody');
    tableBody.innerHTML = '';

    if (data && data.length > 0) {
        data.forEach(function (row) {
            var tr = document.createElement('tr');

            var userCell = document.createElement('td');
            userCell.textContent = row.user_nickname;
            tr.appendChild(userCell);

            var typeCell = document.createElement('td');
            typeCell.textContent = row.vacation_type;
            tr.appendChild(typeCell);

            var timeCell = document.createElement('td');
            timeCell.textContent = row.vacation_date_type;
            tr.appendChild(timeCell);

            var startDateCell = document.createElement('td');
            startDateCell.textContent = row.vacation_date_start;
            tr.appendChild(startDateCell);

            var endDateCell = document.createElement('td');
            endDateCell.textContent = row.vacation_date_end;
            tr.appendChild(endDateCell);

            var reasonCell = document.createElement('td');
            reasonCell.textContent = row.vacation_reason;
            tr.appendChild(reasonCell);

            tableBody.appendChild(tr);
        });
    } else {
        var noResultRow = document.createElement('tr');
        var noResultCell = document.createElement('td');
        noResultCell.textContent = 'No results found';
        noResultCell.colSpan = 6;
        noResultRow.appendChild(noResultCell);
        tableBody.appendChild(noResultRow);
    }
}