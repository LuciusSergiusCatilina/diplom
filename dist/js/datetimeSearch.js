function filterByDate() {
  let startDateInput = document.getElementById("startDate").value;
  let endDateInput = document.getElementById("endDate").value;

  // Если значения startDate и endDate пусты, показываем все строки таблицы
  if (!startDateInput && !endDateInput) {
    var tableRows = document.getElementById("calls").getElementsByTagName("tr");
    for (let i = 0; i < tableRows.length; i++) {
      tableRows[i].style.display = ""; // Устанавливаем стиль для каждого <tr>
    }
    return; // Завершаем функцию, так как нет необходимости в дополнительной фильтрации
  }

  let startDate = new Date(startDateInput).toLocaleDateString('ru-RU');
  let endDate = new Date(endDateInput).toLocaleDateString('ru-RU');

  var tableRows = document.getElementById("calls").getElementsByTagName("tr");
  for (let i = 1; i < tableRows.length; i++) {
    let rowDateText = tableRows[i].getElementsByTagName("td")[6].getAttribute("data-time");
    let rowDate = new Date(rowDateText).toLocaleDateString('ru-RU');

    if (new Date(rowDateText) < new Date(startDateInput) || new Date(rowDateText) > new Date(endDateInput)) {
      tableRows[i].style.display = "none";
    } else {
      tableRows[i].style.display = "";
    }
  }
}

let startDateInput = document.getElementById("startDate");
let endDateInput = document.getElementById("endDate");

startDateInput.addEventListener("change", function () {
  if (startDateInput.value > endDateInput.value) {
    endDateInput.value = startDateInput.value;
  }
  filterByDate();
});

endDateInput.addEventListener("change", function () {
  if (endDateInput.value < startDateInput.value) {
    startDateInput.value = endDateInput.value;
  }
  filterByDate();
});
