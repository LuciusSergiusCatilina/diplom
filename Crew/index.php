<?php
 $content = '<div class="row">
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
                         <input type="text" name="search" id = "search" class="form-control input-sm" onkeyup="searchFunction(\'crews\')" placeholder="Поиск">
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
            </div>
            <script src = "../dist/js/searchBar.js"></script>';
 include('../master.php');
?>
<!-- page script -->
<script>
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
                "<td><a href='update.php?id="+data[crew].id_crew+"'>Изменить</a> | <a href='#' onClick=Remove('"+data[crew].id_crew+"')>Удалить</a></td>"+ 
                "</tr>";
            }
            $(response).appendTo($("#crews tbody")); 
        }
    }); 
 });
 function Remove(id){
    var result = confirm("Вы уверены что хотите удалить экипаж?"); 
    if (result == true) { 
        $.ajax(
        {
            type: "POST",
            url: '../api/crew/delete.php', // Изменено на URL для удаления экипажа
            dataType: 'json',
            data: {
                id: id
            },
            error: function (result) {
                alert(result.responseText);
            },
            success: function (result) {
                if (result['status'] == true) {
                    alert("Экипаж успешно удалён");
                    window.location.href = '../Crew'; // Изменено на URL страницы экипажей
                }
                else {
                    alert(result['message']);
                }
            }
        });
    }
 }
</script>
