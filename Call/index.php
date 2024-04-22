<?php
 $content = '<div class="row">
                <div class="col-xs-12">
                <div class="box">
                 <div class="box-header">
                 <div class="row">
                 <div class="col-xs-9">
                     <h3 class="box-title">Список вызовов</h3>
                 </div>
                 <div class="col-xs-3">
                     <form action="#" method="get" class="pull-right">
                         <div class="input-group">
                         <input type="text" name="search" id = "search" class="form-control input-sm" onkeyup="searchFunction(\'calls\')" placeholder="Поиск">
                             <span class="input-group-btn">
                                 <button type="submit" name="search" id="search-btn" class="btn btn-flat btn-sm"><i class="fa fa-search"></i>
                                 </button>
                             </span>
                         </div>
                     </form>
                        <label for="startDate">Начальная дата:</label>
                        <input type="datetime-local" id="startDate" name="startDate">
                        <label for="endDate">Конечная дата:</label>
                        <input type="datetime-local" id="endDate" name="endDate">
                        <button onclick="filterByDate()">Применить фильтр</button>
                 </div>
                </div>
                 <!-- /.box-header -->
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
                        <th>Действия</th>
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
            </div>';

 include('../master.php');
?>
<!-- page script -->
<script src = "../dist/js/searchBar.js"></script>
<script src = "../dist/js/datetimeSearch.js"></script>';
<script>
 $(document).ready(function(){
  console.log("ready");
    $.ajax({
        type: "GET",
        url: "../api/call/read.php", // Изменено на URL для чтения экипажей
        dataType: 'json',
        success: function(data) {
          console.log(data);

            let response="";
            for(var call in data){
                // let rawDate = new Date(data[call].time);
                // let formattedDate = rawDate.getFullYear() + "-" + 
                //     ('0' + (rawDate.getMonth() + 1)).slice(-2) + "-" + 
                //     ('0' + rawDate.getDate()).slice(-2) + "T" + 
                //     ('0' + rawDate.getHours()).slice(-2) + ":" + 
                //     ('0' + rawDate.getMinutes()).slice(-2);
                response += "<tr>"+
                "<td>"+data[call].id_call+"</td>"+
                "<td>"+data[call].user_name+"</td>"+ 
                "<td>"+(data[call].id_crew ?? "Бригада не вызвана")+"</td>"+
                "<td>"+data[call].adress+"</td>"+
                "<td>"+data[call].number+"</td>"+
                "<td>"+(data[call].patient_name ?? "Добавить позже")+"</td>"+
                "<td>"+data[call].time+"</td>"+
                "<td>"+data[call].type+"</td>"+
                "<td><a href='update.php?id="+data[call].id_call+"'>Изменить</a> | <a href='#' onClick=Remove('"+data[call].id_call+"')>Удалить</a></td>"+ 
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
                    window.location.href = '/medibed/call'; // Изменено на URL страницы экипажей
                }
                else {
                    alert(result['message']);
                }
            }
        });
    }
 }
</script>
