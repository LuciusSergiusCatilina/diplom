<?php
 $content = '<div class="row">
                <div class="col-xs-12">
                <div class="box">
                 <div class="box-header">
                    <h3 class="box-title">Список экипажей</h3>
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
            </div>';
 include('../master.php');
?>
<!-- page script -->
<script>
 $(document).ready(function(){
    $.ajax({
        type: "GET",
        url: "../api/crew/read.php", // Изменено на URL для чтения экипажей
        dataType: 'json',
        success: function(data) {
            var response="";
            for(var crew in data){
                response += "<tr>"+
                "<td>"+data[crew].id_crew+"</td>"+
                "<td>"+data[crew].driver_name+"</td>"+ // Предполагается, что имена членов экипажа возвращаются в ответе
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
                    window.location.href = '/medibed/crew'; // Изменено на URL страницы экипажей
                }
                else {
                    alert(result['message']);
                }
            }
        });
    }
 }
</script>
