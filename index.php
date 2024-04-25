<?php
 $content = '
 <div class="row">
 <div class="col-md-6">
   <div class="row">
     <!-- Пример блока с общим количеством записей -->
     <div class="col-md-6 col-sm-6 col-xs-12">
       <div class="info-box">
         <span class="info-box-icon bg-aqua"><i class="fa fa-file"></i></span>
         <div class="info-box-content">
           <span class="info-box-text">Общее количество вызовов</span>
           <span class="info-box-number">150</span>
         </div>
       </div>
     </div>
     <div class="col-md-6 col-sm-6 col-xs-12">
       <div class="info-box">
         <span class="info-box-icon bg-red"><i class="fa fa-wheelchair-alt"></i></span>
         <div class="info-box-content">
           <span class="info-box-text">Общее количество пациентов</span>
           <span class="info-box-number">150</span>
         </div>
       </div>
     </div>
     <!-- Добавьте другие блоки с другой статистикой здесь -->
   </div>

   <div class="row">
     <div class="col-md-6 col-sm-6 col-xs-12">
       <div class="info-box bg-green">
         <span class="info-box-icon"><i class="fa fa-comments-o"></i></span>
         <div class="info-box-content">
           <span class="info-box-text">Консультаций</span>
           <span class="info-box-number">41,410</span>
           <div class="progress">
             <div class="progress-bar" style="width: 70%"></div>
           </div>
           <span class="progress-description">
             42% в текущем месяце
           </span>
         </div>
       </div>
     </div>

     <div class="col-md-6 col-sm-6 col-xs-12">
       <div class="info-box bg-yellow">
         <span class="info-box-icon"><i class="fa fa-ambulance"></i></span>
         <div class="info-box-content">
           <span class="info-box-text">Выездов бригад</span>
           <span class="info-box-number">41,410</span>
           <div class="progress">
             <div class="progress-bar" style="width: 70%"></div>
           </div>
           <span class="progress-description">
            58% в текущем месяце
           </span>
         </div>
       </div>
     </div>
   </div>

   <!-- Пример блока с графиком -->
   <div class="row">
     <div class="col-xs-12">
       <div class="box box-primary">
         <div class="box-header with-border">
           <h3 class="box-title">График вызовов по месяцам</h3>
         </div>
         <div class="box-body">
           <canvas id="recordsChart" width="200" height="100"></canvas>
         </div>
       </div>
     </div>
   </div>
 </div>

 <div class="col-md-6">
   <div class="row">
     <div class="col-xs-12">
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
                     <button type="submit" name="search" id="search-btn" class="btn btn-flat btn-sm"><i class="fa fa-search"></i>
                     </button>
                   </span>
                 </div>
               </form>
             </div>
           </div>
           <!-- /.box-header -->
           <div class="box-body">
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
               </tbody>
             </table>
           </div>
           <!-- /.box-body -->
         </div>
         <!-- /.box -->
       </div>
     </div>
   </div>
 </div>
</div>
      

      
';

 include('master.php');
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script>
  let ctx = document.getElementById('recordsChart').getContext('2d');
  let myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль'],
      datasets: [{
        label: 'Количество вызовов',
        data: [65, 59, 80, 81, 56, 55, 40],
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
            stepSize: 10
          }
        }]
      }
    }
  });

  $(document).ready(function(){
    $.ajax({
        type: "GET",
        url: "../api/crew/read.php", 
        dataType: 'json',
        success: function(data) {
            var response="";
            for(var crew in data){
                response += "<tr>"+
                "<td>"+data[crew].id_crew+"</td>"+
                "<td>"+data[crew].driver_name+"</td>"+ 
                "<td>"+data[crew].doctor_name+"</td>"+
                "<td>"+data[crew].orderly_name+"</td>"+
                "<td>"+((data[crew].paramedic_name) ?? "Отсутствует")+"</td>"+
                "</tr>";
            }
            $(response).appendTo($("#crews tbody")); 
        }
    }); 
 });
</script>