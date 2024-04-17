<?php
 $content = '<div class="row">
                <div class="col-xs-12">
                <div class="box">
                 <div class="box-header">
                    <h3 class="box-title">Список докторов</h3>
                 </div>
                 <!-- /.box-header -->
                 <div class="box-body">
                    <table id="doctors" class="table table-bordered table-hover">
                      <thead>
                      <tr>
                        <th>ФИО</th>
                        <th>Номер телефона</th>
                        <th>Специализация</th>
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
        url: "../api/doctor/read.php",
        dataType: 'json',
        success: function(data) {
            var response="";
            for(var user in data){
                response += "<tr>"+
                "<td>"+data[user].name+"</td>"+
                "<td>"+data[user].number+"</td>"+ 
                "<td>"+data[user].specialization+"</td>"+ 
                "<td><a href='update.php?id="+data[user].id_doctor+"'>Изменить</a> | <a href='#' onClick=Remove('"+data[user].id_doctor+"')>Удалить</a></td>"+ 
                "</tr>";
            }
            $(response).appendTo($("#doctors tbody")); 
        }
    });
 });
 function Remove(id){
    var result = confirm("Вы уверены что хотите удалить врача?"); 
    if (result == true) { 
        $.ajax(
        {
            type: "POST",
            url: '../api/doctor/delete.php',
            dataType: 'json',
            data: {
                id: id
            },
            error: function (result) {
                alert(result.responseText);
            },
            success: function (result) {
                if (result['status'] == true) {
                    alert("Врач успешно удалён");
                    window.location.href = '/medibed/doctor';
                }
                else {
                    alert(result['message']);
                }
            }
        });
    }
 }
</script>
