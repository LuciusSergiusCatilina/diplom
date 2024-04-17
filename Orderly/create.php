<?php
$content = '<div class="row">
<!-- left column -->
<div class="col-md-12">
 <!-- general form elements -->
 <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Добавить санитара</h3>
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
        <input type="button" class="btn btn-primary" onClick="AddOrderly()" value="Добавить"></input>
      </div>
    </form>
 </div>
 <!-- /.box -->
</div>
</div>';

include '../master.php';

?>
<script>
function AddOrderly(){
    $.ajax({
        type: "POST",
        url: '../api/orderly/create.php', // Изменено на 'orderly/create.php'
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
                alert("Новый санитар успешно добавлен!");
                window.location.href = '/medibed/orderly'; // Изменено на '/medibed/orderly'
            }
            else {
                alert(result['message']);
            }
        }
    });
}
</script>
