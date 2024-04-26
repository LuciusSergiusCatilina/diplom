function filterByDate() {
  let startDateInput = document.getElementById("startDate").value;
  let endDateInput = document.getElementById("endDate").value;
  //console.log("sdi: " + startDateInput);

  let startDate = new Date(startDateInput).toLocaleDateString('ru-RU');;
  let endDate = new Date(endDateInput).toLocaleDateString('ru-RU');;
  //console.log("sd: " + startDate);

  var tableRows = document.getElementById("calls").getElementsByTagName("tr");
  for (let i = 1; i < tableRows.length; i++) {
    let rowDateText = tableRows[i].getElementsByTagName("td")[6].getAttribute("data-time");
    let rowDate = new Date(rowDateText);

    //console.log(rowDate," | ", startDate, " | ", endDate);
    if (rowDate < startDate || rowDate > endDate) {
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
