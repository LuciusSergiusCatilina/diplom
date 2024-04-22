function filterByDate() {
  let startDateInput = document.getElementById("startDate").value;
  let endDateInput = document.getElementById("endDate").value;

  // Преобразование строк в объекты Date
  let startDate = new Date(startDateInput);
  let endDate = new Date(endDateInput);

  var tableRows = document.getElementById("calls").getElementsByTagName("tr");
  for (let i = 1; i < tableRows.length; i++) {
    let rowDateText = tableRows[i].getElementsByTagName("td")[6].textContent;
    let rowDate = new Date(rowDateText);

    // Проверка, попадает ли дата строки в выбранный пользователем диапазон
    if (rowDate < startDate || rowDate > endDate) {
      tableRows[i].style.display = "none";
    } else {
      tableRows[i].style.display = "";
    }
  }
}

// Обработчики изменения даты
let startDateInput = document.getElementById("startDate");
let endDateInput = document.getElementById("endDate");

startDateInput.addEventListener("change", function () {
  if (startDateInput.value > endDateInput.value) {
    endDateInput.value = startDateInput.value;
  }
  filterByDate(); // Вызов функции фильтрации после изменения даты
});

endDateInput.addEventListener("change", function () {
  if (endDateInput.value < startDateInput.value) {
    startDateInput.value = endDateInput.value;
  }
  filterByDate(); // Вызов функции фильтрации после изменения даты
});
