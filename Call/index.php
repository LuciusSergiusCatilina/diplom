<?php
 $content = '<div class="row">
 <div class="col-xs-12">
     <div class="box">
         <div class="box-header ">
             <div class="row">
                 <div class="col-xs-6">
                     <h3 class="box-title">Список вызовов</h3>
                 </div>
                 <div class="col-xs-6">
                     <form action="#" method="get" class="pull-right">
                         <div class="input-group">
                             <input type="text" name="search" id="search" class="form-control input-sm" onkeyup="searchFunction(\'calls\')" placeholder="Поиск">
                             <span class="input-group-btn">
                                 <button type="submit" name="search" id="search-btn" class="btn btn-flat btn-sm"><i class="fa fa-search"></i>
                                 </button>
                             </span>
                         </div>
                     </form>
                     
                 </div>
             </div>
             <!-- /.box-header -->
             <div class="row ">
             <div class="col-sm-2">
                 <label for="startDate">Начальная дата:</label>
                 <input type="datetime-local" id="startDate" name="startDate" class="form-control input-sm">
                 </div>
                 <div class="col-sm-2">
                 <label for="endDate" class="">Конечная дата:</label>
                 <input type="datetime-local" id="endDate" name="endDate" class="form-control input-sm">
                 </div>
             </div>
            </div>
             <div class="box-body">

                 <table id="calls" class="table table-bordered table-hover">
                     <thead>
                         <tr>
                             <th>Номер вызова</th>
                             <th>Диспетчер</th>
                             <th>Бригада</th>
                             <th>Адрес вызова</th>
                             <th>Номер вызывавшего</th>
                             <th>Пациент</th>
                             <th>Время вызова</th>
                             <th>Тип помощи</th>
                             <th id ="action">Действия <button onclick="printTable(\'calls\')"class="btn btn-flat btn-sm pull-right"> <i class="fa fa-file-text-o "> </i> </button></th>
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
';

 include('../master.php');
?>
<!-- page script -->
<script src = "../dist/js/searchBar.js"></script>
<script src = "../dist/js/datetimeSearch.js"></script>
<script src = "../dist/js/printPDF.js"></script>
<script>
 $(document).ready(function(){
  //console.log("ready");
    $.ajax({
        type: "GET",
        url: "../api/call/read.php", 
        dataType: 'json',
        success: function(data) {
          //console.log(data);

            let response="";
            for(var call in data){
                let date = new Date(data[call].time);
                let formatDateTime =  new Intl.DateTimeFormat("ru", {dateStyle:"long", timeStyle:"short"}).format(date);
                //console.log("fmd: ", formatDateTime);
                response += "<tr>"+
                "<td>"+data[call].id_call+"</td>"+
                "<td>"+data[call].user_name+"</td>"+ 
                "<td>"+(data[call].id_crew ?? "Бригада не вызвана")+"</td>"+
                "<td>"+data[call].adress+"</td>"+
                "<td>"+data[call].number+"</td>"+
                "<td>"+(data[call].patient_name ?? "Добавить позже")+"</td>"+
                "<td data-time = '" + date + "'>"+formatDateTime+"</td>"+
                "<td>"+data[call].type+"</td>"+
                "<td id = 'action'><a href='update.php?id="+data[call].id_call+"'>Изменить</a> | <a href='#' onClick=Remove('"+data[call].id_call+"')>Удалить</a></td>"+ 
                "</tr>";
            }
            $(response).appendTo($("#calls tbody")); 
        }

    }); 
 });
 function Remove(id){
    var result = confirm("Вы уверены что хотите удалить вызов?"); 
    if (result == true) { 
        $.ajax(
        {
            type: "POST",
            url: '../api/call/delete.php', // Изменено на URL для удаления экипажа
            dataType: 'json',
            data: {
                id: id
            },
            error: function (result) {
                alert(result.responseText);
            },
            success: function (result) {
                if (result['status'] == true) {
                    alert("Вызов успешно удалён");
                    window.location.href = '../Call'; // Изменено на URL страницы экипажей
                }
                else {
                    alert(result['message']);
                }
            }
        });
    }
 }
</script>
