<?php
$content = '
<div class="row">
  <div class="col-xs-12 col-md-6"> <!-- Левая колонка -->

    
    <div class="info-box">
      <span class="info-box-icon bg-aqua"><i class="fa fa-file"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Общее количество вызовов</span>
        <span class="info-box-number" id="countCalls"></span>
      </div>
    </div>
    
    <div class="info-box">
      <span class="info-box-icon bg-red"><i class="fa fa-wheelchair-alt"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Общее количество пациентов</span>
        <span class="info-box-number" id="countPatients"></span>
      </div>
    </div>
    
    <div class="info-box bg-green">
      <span class="info-box-icon"><i class="fa fa-comments-o"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Консультаций</span>
        <span class="info-box-number" id="countConsultations"></span>
        <div class="progress">
          <div class="progress-bar" style="width: 70%" id="countConsultationsProcentBar"></div>
        </div>
        <span class="progress-description" id="countConsultationsProcent"></span>
      </div>
    </div>
    
    <div class="info-box bg-yellow">
      <span class="info-box-icon"><i class="fa fa-ambulance"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Выездов бригад</span>
        <span class="info-box-number" id="сountDepartures"></span>
        <div class="progress">
          <div class="progress-bar" style="width: 70%" id="countCallsProcentBar"></div>
        </div>
        <span class="progress-description" id="countCallsProcent"></span>
      </div>
    </div>
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
                <input type="text" name="search" id="search" class="form-control input-sm" onkeyup="searchFunction(`crews`)" placeholder="Поиск">
                <span class="input-group-btn">
                  <button type="submit" name="search" id="search-btn" class="btn btn-flat btn-sm"><i class="fa fa-search"></i></button>
                </span>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- /.box-header -->
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
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
</div>



      
';

include 'master.php';
?>
<script src = "../dist/js/searchBar.js"></script>
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
        $.ajax({
            type: "GET",
            url: "../api/crew/read.php",
            dataType: 'json',
            success: function(data) {
                let response = "";
                for (var crew in data) {
                    response += "<tr>" +
                        "<td>" + data[crew].id_crew + "</td>" +
                        "<td>" + data[crew].driver_name + "</td>" +
                        "<td>" + data[crew].doctor_name + "</td>" +
                        "<td>" + data[crew].orderly_name + "</td>" +
                        "<td>" + ((data[crew].paramedic_name) ?? "Отсутствует") + "</td>" +
                        "</tr>";
                }
                $(response).appendTo($("#crews tbody"));
            }
        });
        $.ajax({
            type: "GET",
            url: "../api/call/getCount.php",
            dataType: 'json',
            success: function(data) {
                $("#countCalls").text(data);

            }
        });
        $.ajax({
            type: "GET",
            url: "../api/patient/getCount.php",
            dataType: 'json',
            success: function(data) {
                $("#countPatients").text(data);
            }
        });

        $.ajax({
            type: "GET",
            url: "../api/call/getCountConsultations.php",
            dataType: 'json',
            success: function(data) {
                $("#countConsultations").text(data);
            }
        });

        $.ajax({
            type: "GET",
            url: "../api/call/getCountDepartures.php",
            dataType: 'json',
            success: function(data) {
                $("#сountDepartures").text(data);
            }
        });

        $.ajax({
            type: "GET",
            url: "../api/call/getStats.php",
            dataType: 'json',
            success: function(data) {
                let consultationsProcent = (data * 100).toFixed(0);
                let callsProcent = (100 - consultationsProcent);

                $("#countConsultationsProcent").text(consultationsProcent + "% от общего числа вызовов");
                $("#countConsultationsProcentBar").width(consultationsProcent + "%");

                $("#countCallsProcent").text(callsProcent + "% от общего числа вызовов");
                $("#countCallsProcentBar").width(callsProcent + "%")
            }
        });

        $.ajax({
            type: "GET",
            url: "../api/call/getDates.php",
            dataType: 'json',
            success: function(data) {
              console.log("succsess")
              let labels = [];
              let dataset = [];
                for (var item in data){
                  labels.push(ruDates[data[item].month_name] + " " + data[item].year);
                  dataset.push(data[item].calls_count);
                }
                console.log(dataset);

                let ctx = document.getElementById('recordsChart').getContext('2d');
                let myChart = new Chart(ctx, {
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
        });

    });
</script>
