<?php
$content = '<div class="row">
<div class="col-xs-12">
<div class="box">
 <div class="box-header">
 <div class="row">
 <div class="col-xs-9">
     <h3 class="box-title">Список фельдшеров</h3>
 </div>
 <div class="col-xs-3">
     <form action="#" method="get" class="pull-right">
         <div class="input-group">
         <input type="text" name="search" id = "search" class="form-control input-sm" onkeyup="searchFunction(\'paramedics\')" placeholder="Поиск">
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
    <table id="paramedics" class="table table-bordered table-hover">
      <thead>
      <tr>
        <th>Имя</th>
        <th>Телефон</th>
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
        url: "../api/paramedic/read.php", // Изменено на paramedic/read.php
        dataType: 'json',
        success: function(data) {
            var response="";
            for(var user in data){
                response += "<tr>"+
                "<td>"+data[user].name+"</td>"+
                "<td>"+data[user].number+"</td>"+ 
                "<td><a href='update.php?id="+data[user].id_paramedic+"'>Изменить</a> | <a href='#' onClick=Remove('"+data[user].id_paramedic+"')>Удалить</a></td>"+ 
                "</tr>";
            }
            $(response).appendTo($("#paramedics tbody")); // Изменено на 'paramedics'
        }
    });
});
function Remove(id){
    var result = confirm("Вы уверены что хотите удалить парамедика?"); 
    if (result == true) { 
        $.ajax(
        {
            type: "POST",
            url: '../api/paramedic/delete.php', // Изменено на paramedic/delete.php
            dataType: 'json',
            data: {
                id: id
            },
            error: function (result) {
                alert(result.responseText);
            },
            success: function (result) {
                if (result['status'] == true) {
                    alert("Парамедик успешно удалён");
                    window.location.href = '/medibed/paramedic'; // Изменено на '/medibed/paramedic'
                }
                else {
                    alert(result['message']);
                }
            }
        });
    }
}
</script>
