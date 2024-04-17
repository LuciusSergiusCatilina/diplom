<?php
$content = '<div class="row">
<!-- left column -->
<div class="col-md-12">
 <!-- general form elements -->
 <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Добавить парамедика</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form role="form">
      <div class="box-body">
        <div class="form-group">
          <label for="exampleInputName1">Имя</label>
          <input required type="text" class="form-control" id="name" placeholder="Введите имя" >
        </div>
        <div class="form-group">
          <label for="exampleInputName1">Телефон</label>
          <input type="tel" class="form-control" id="number" placeholder="Введите номер телефона"> 
        </div>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <input type="button" class="btn btn-primary" onClick="AddParamedic()" value="Добавить"></input>
      </div>
    </form>
 </div>
 <!-- /.box -->
</div>
</div>';

include '../master.php';

?>
<script>
function AddParamedic(){
    $.ajax({
        type: "POST",
        url: '../api/paramedic/create.php', // Изменено на 'paramedic/create.php'
        dataType: 'json',
        data: {
            name: $("#name").val(),
            number: $("#number").val()
        },
        error: function (result) {
            alert(result['message']);
        },
        success: function (result) {
            if (result['status'] == true) {
                alert("Новый парамедик успешно добавлен!");
                window.location.href = '/medibed/paramedic'; // Изменено на '/medibed/paramedic'
            }
            else {
                alert(result['message']);
            }
        }
    });
}
</script>

