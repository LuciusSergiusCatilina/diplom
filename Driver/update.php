<?php
$content = '<div class="row">
<!-- left column -->
<div class="col-md-12">
 <!-- general form elements -->
 <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Изменить данные водителя</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form role="form">
      <div class="box-body">
        <div class="form-group">
          <label for="exampleInputName1">Имя</label>
          <input type="text" class="form-control" id="name" placeholder="Введите имя">
        </div>
        <div class="form-group">
          <label for="exampleInputName1">Телефон</label>
          <input type="text" class="form-control" id="phone" placeholder="Введите номер"> 
        </div>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <input type="button" class="btn btn-primary" onClick="UpdateDriver()" value="Изменить"></input>
      </div>
    </form>
 </div>
 <!-- /.box -->
</div>
</div>';
 include('../master.php');
  
?>
<script>
$(document).ready(function(){
    $.ajax({
        type: "GET",
        url: "../api/driver/read_single.php?id=<?php echo $_GET['id']; ?>",
        dataType: 'json',
        success: function(data) {
            $('#name').val(data['name']);
            $('#phone').val(data['phone']); // Изменено на 'phone'
        },
        error: function (result) {
            console.log(result);
        },
    });
});

function UpdateDriver(){
    $.ajax({
        type: "POST",
        url: '../api/driver/update.php', // Изменено на 'driver/update.php'
        dataType: 'json',
        data: {
            id: <?php echo $_GET['id']; ?>,
            name: $("#name").val(),
            phone: $("#phone").val() // Изменено на 'phone'
        },
        error: function (result) {
            alert(result['message']);
        },
        success: function (result) {
            if (result['status'] == true) {
                alert("Данные изменены!");
                window.location.href = '../Driver'; // Изменено на '/medibed/driver'
            }
            else {
                alert(result['message']);
            }
        }
    });
}
</script>
