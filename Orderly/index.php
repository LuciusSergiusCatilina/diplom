<?php
$content = '<div class="row">
<div class="col-xs-12">
<div class="box">
 <div class="box-header">
 <div class="row">
 <div class="col-xs-9">
     <h3 class="box-title">Список санитаров</h3>
 </div>
 <div class="col-xs-3">
     <form action="#" method="get" class="pull-right">
         <div class="input-group">
         <input type="text" name="search" id = "search" class="form-control input-sm" onkeyup="searchFunction(\'orderlies\')" placeholder="Поиск">
             <span class="input-group-btn">
                 <button type="submit" name="search" id="search-btn" class="btn btn-flat btn-sm"><i class="fa fa-search"></i>
                 </button>
             </span>
         </div>
     </form>
 </div>
</div>
</div>
 <!-- /.box-header -->
 <div class="box-body">
    <table id="orderlies" class="table table-bordered table-hover">
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
        url: "../api/orderly/read.php", // Изменено на orderly/read.php
        dataType: 'json',
        success: function(data) {
            var response="";
            for(var user in data){
                response += "<tr>"+
                "<td>"+data[user].name+"</td>"+
                "<td>"+data[user].number+"</td>"+ 
                "<td><a href='update.php?id="+data[user].id_orderly+"'>Изменить</a> | <a href='#' onClick=Remove('"+data[user].id_orderly+"')>Удалить</a></td>"+ 
                "</tr>";
            }
            $(response).appendTo($("#orderlies tbody")); // Изменено на 'orderlies'
        }
    });
});
function Remove(id){
    var result = confirm("Вы уверены что хотите удалить санитара?"); 
    if (result == true) { 
        $.ajax(
        {
            type: "POST",
            url: '../api/orderly/delete.php', // Изменено на orderly/delete.php
            dataType: 'json',
            data: {
                id: id
            },
            error: function (result) {
                alert(result.responseText);
            },
            success: function (result) {
                if (result['status'] == true) {
                    alert("Санитар успешно удалён");
                    window.location.href = '/medibed/orderly'; // Изменено на '/medibed/orderly'
                }
                else {
                    alert(result['message']);
                }
            }
        });
    }
}
</script>
