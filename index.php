<?php
$content = '
<div class="row">
  <div class="col-xs-12 col-md-6"> <!-- Левая колонка -->

    ' . createInfoBox("bg-aqua", "fa-file", "Общее количество вызовов", "countCalls") . '
    ' . createInfoBox("bg-red", "fa-wheelchair-alt", "Общее количество пациентов", "countPatients") . '
    ' . createProgressInfoBox("bg-green", "fa-comments-o", "Консультаций", "countConsultations", "countConsultationsProcentBar", "countConsultationsProcent") . '
    ' . createProgressInfoBox("bg-yellow", "fa-ambulance", "Выездов бригад", "сountDepartures", "countCallsProcentBar", "countCallsProcent") . '
    
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">График вызовов по месяцам</h3>
      </div>
      <div class="box-body">
        <canvas id="recordsChart" width="200" height="100"></canvas>
      </div>
    </div>
  </div>
  
  <div class="col-xs-12 col-md-6"> <!-- Правая колонка -->
    <div class="box">
      <div class="box-header">
        <div class="row">
          <div class="col-xs-9">
            <h3 class="box-title">Список бригад</h3>
          </div>
          <div class="col-xs-3">
            <form action="#" method="get" class="pull-right">
              <div class="input-group">
                <input type="text" name="search" id="search" class="form-control input-sm" onkeyup="searchFunction(\'crews\')" placeholder="Поиск">
                <span class="input-group-btn">
                  <button type="submit" name="search" id="search-btn" class="btn btn-flat btn-sm"><i class="fa fa-search"></i></button>
                </span>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="box-body table-responsive">
        <table id="crews" class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>Номер бригады</th>
              <th>Водитель</th>
              <th>Доктор</th>
              <th>Санитар</th>
              <th>Фельдшер</th>
            </tr>
          </thead>
          <tbody>
            <!-- Тут будут данные таблицы -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>';

include 'master.php';
?>

<script src="../dist/js/searchBar.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script>
    const ruDates = {
        "January": "Январь",
        "February": "Февраль",
        "March": "Март",
        "April": "Апрель",
        "May": "Май",
        "June": "Июнь",
        "July": "Июль",
        "August": "Август",
        "September": "Сентябрь",
        "October": "Октябрь",
        "November": "Ноябрь",
        "December": "Декабрь"
    };

    $(document).ready(function() {
        fetchData("../api/crew/read.php", fillCrewTable);
        fetchData("../api/call/getCount.php", updateText("#countCalls"));
        fetchData("../api/patient/getCount.php", updateText("#countPatients"));
        fetchData("../api/call/getCountConsultations.php", updateText("#countConsultations"));
        fetchData("../api/call/getCountDepartures.php", updateText("#сountDepartures"));
        fetchData("../api/call/getStats.php", updateStats);
        fetchData("../api/call/getDates.php", renderChart);
    });

    function fetchData(url, callback) {
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            success: callback
        });
    }

    function fillCrewTable(data) {
        let response = "";
        data.forEach(crew => {
            response += `
        <tr>
          <td>${crew.id_crew}</td>
          <td>${crew.driver_name}</td>
          <td>${crew.doctor_name}</td>
          <td>${crew.orderly_name}</td>
          <td>${crew.paramedic_name ?? "Отсутствует"}</td>
        </tr>`;
        });
        $(response).appendTo($("#crews tbody"));
    }

    function updateText(selector) {
        return function(data) {
            $(selector).text(data);
        };
    }

    function updateStats(data) {
        let consultationsProcent = (data * 100).toFixed(0);
        let callsProcent = (100 - consultationsProcent);

        $("#countConsultationsProcent").text(consultationsProcent + "% от общего числа вызовов");
        $("#countConsultationsProcentBar").width(consultationsProcent + "%");

        $("#countCallsProcent").text(callsProcent + "% от общего числа вызовов");
        $("#countCallsProcentBar").width(callsProcent + "%");
    }

    function renderChart(data) {
        let labels = data.map(item => ruDates[item.month_name] + " " + item.year);
        let dataset = data.map(item => item.calls_count);

        let ctx = document.getElementById('recordsChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Количество вызовов',
                    data: dataset,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            stepSize: 2
                        }
                    }]
                }
            }
        });
    }
</script>

<?php
function createInfoBox($bgClass, $iconClass, $text, $id) {
  return '
    <div class="info-box">
      <span class="info-box-icon ' . $bgClass . '"><i class="fa ' . $iconClass . '"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">' . $text . '</span>
        <span class="info-box-number" id="' . $id . '"></span>
      </div>
    </div>';
}

function createProgressInfoBox($bgClass, $iconClass, $text, $id, $progressBarId, $progressTextId) {
  return '
    <div class="info-box ' . $bgClass . '">
      <span class="info-box-icon"><i class="fa ' . $iconClass . '"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">' . $text . '</span>
        <span class="info-box-number" id="' . $id . '"></span>
        <div class="progress">
          <div class="progress-bar" id="' . $progressBarId . '"></div>
        </div>
        <span class="progress-description" id="' . $progressTextId . '"></span>
      </div>
    </div>';
}
?>
