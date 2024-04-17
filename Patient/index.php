<?php
$content = '<div class="row">
<div class="col-xs-12">
<div class="box">
 <div class="box-header">
    <h3 class="box-title">Список пациентов</h3>
 </div>
 <!-- /.box-header -->
 <div class="box-body">
    <table id="patients" class="table table-bordered table-hover">
      <thead>
      <tr>
        <th>ФИО</th>
        <th>Номер телефона</th>
        <th>Адрес</th>
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
<script>
 $(document).ready(function(){
    $.ajax({
        type: "GET",
        url: "../api/patient/read.php", // Изменено на patient/read.php
        dataType: 'json',
        success: function(data) {
            var response="";
            for(var user in data){
                response += "<tr>"+
                "<td>"+data[user].name+"</td>"+
                "<td>"+data[user].number+"</td>"+ 
                "<td>"+data[user].adress+"</td>"+ // Изменено на 'adress'
                "<td><a href='update.php?id="+data[user].id_patient+"'>Изменить</a> | <a href='#' onClick=Remove('"+data[user].id_patient+"')>Удалить</a></td>"+ 
                "</tr>";
            }
            $(response).appendTo($("#patients tbody")); // Изменено на 'patients'
        }
    });
});
function Remove(id){
    var result = confirm("Вы уверены что хотите удалить пациента?"); 
    if (result == true) { 
        $.ajax(
        {
            type: "POST",
            url: '../api/patient/delete.php', // Изменено на patient/delete.php
            dataType: 'json',
            data: {
                id: id
            },
            error: function (result) {
                alert(result.responseText);
            },
            success: function (result) {
                if (result['status'] == true) {
                    alert("Пациент успешно удалён");
                    window.location.href = '/medibed/patient'; // Изменено на '/medibed/patient'
                }
                else {
                    alert(result['message']);
                }
            }
        });
    }
}
</script>
