<?php
 $content = '<div class="row">
 <div class="col-xs-12">
     <div class="box">
         <div class="box-header">
             <div class="row">
                 <div class="col-xs-9">
                     <h3 class="box-title">Список водителей</h3>
                 </div>
                 <div class="col-xs-3">
                     <form action="#" method="get" class="pull-right">
                         <div class="input-group">
                         <input type="text" name="search" id = "search" class="form-control input-sm" onkeyup="searchFunction(\'drivers\')" placeholder="Поиск">
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
             <table id="drivers" class="table table-bordered table-hover">
                 <thead>
                     <tr>
                         <th>ФИО</th>
                         <th>Номер телефона</th>
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
<script src = "../dist/js/searchBar.js"></script>

';

include('../master.php');

?>
<script>
  $(document).ready(function() {
    $.ajax({
      type: "GET",
      url: "../api/driver/read.php", // Изменено на driver/read.php
      dataType: 'json',
      success: function(data) {
        var response = "";
        for (var user in data) {
          response += "<tr>" +
            "<td>" + data[user].name + "</td>" +
            "<td>" + data[user].phone + "</td>" + // Изменено на 'phone'
            "<td><a href='update.php?id=" + data[user].id_drivers + "'>Изменить</a> | <a href='#' onClick=Remove('" + data[user].id_drivers + "')>Удалить</a></td>" +
            "</tr>";
        }
        $(response).appendTo($("#drivers tbody")); // Изменено на 'drivers'
      }
    });
  });

  function Remove(id) {
    var result = confirm("Вы уверены что хотите удалить водителя?");
    if (result == true) {
      $.ajax({
        type: "POST",
        url: '../api/driver/delete.php', // Изменено на driver/delete.php
        dataType: 'json',
        data: {
          id: id
        },
        error: function(result) {
          alert(result.responseText);
        },
        success: function(result) {
          if (result['status'] == true) {
            alert("Водитель успешно удалён");
            window.location.href = '/medibed/driver'; // Изменено на '/medibed/driver'
          } else {
            alert(result['message']);
          }
        }
      });
    }
  }
</script>