<?php
session_start();
if (($_SESSION['user_role'] !== 'admin') && ($_SESSION['user_role'] !== 'Начальник отдела кадров')) {
    header("location:../notenoughpermission.php");
}
$content = '<div class="row">
<!-- left column -->
<div class="col-md-12">
 <!-- general form elements -->
 <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Добавить водителя</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form role="form" id = "formDriver">
      <div class="box-body">
        <div class="form-group">
          <label for="exampleInputName1">Имя</label>
          <input required type="text" class="form-control" id="name" placeholder="Введите имя" name = "name" minlength="10">
        </div>
        <div class="form-group">
          <label for="exampleInputName1">Телефон</label>
          <input type="tel" class="form-control" id="phone" placeholder="Введите телефон" name = "phone" minlength="12" maxlength="12"> 
        </div>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <input type="button" class="btn btn-primary" onClick="AddDriver()" value="Добавить"></input>
        <input type="button" class="btn btn-danger" onClick="window.location.href = `../Driver` " value="Назад"></input>
      </div>
    </form>
 </div>
 <!-- /.box -->
</div>
</div>';

include '../master.php';
?>

<script>

$(document).ready(function(){
  $.validator.addMethod("russianPhoneNumber", function(value, element) {
      return this.optional(element) || /^((\+7|7|8)+([0-9]){10})$/.test(value);
    }, "Укажите телефон в формате +79991112244");

    $.validator.addMethod("russianLetters", function(value, element) {
      return this.optional(element) || /^[А-Яа-яЁё\s]+$/.test(value);
    }, "Пожалуйста, введите только русские буквы.");

    // Form validation
    $("#formDriver").validate({
      rules: {
        name: {
          required: true,
          minlength: 10,
          russianLetters: true
        },
        phone: {
          required: true,
          minlength: 11,
          russianPhoneNumber: true
        },
      },
      messages: {
        name: {
          required: "Пожалуйста, введите ФИО",
          minlength: "Слишком короткое ФИО",
          russianLetters: "Пожалуйста, введите только русские буквы"
        },
        phone: {
          required: "Пожалуйста, введите номер телефона",
          russianPhoneNumber: "Пожалуйста, введите телефон в формате +79991112244",
            minlength: "Пожалуйста, введите телефон в формате +79991112244",
            maxlength: "Пожалуйста, введите телефон в формате +79991112244"
        },
     
      }
    });

})

function AddDriver(){
    if ($("#formDriver").valid()) {
    $.ajax({
        type: "POST",
        url: '../api/driver/create.php', // Изменено на 'driver/create.php'
        dataType: 'json',
        data: {
            name: $("#name").val(),
            phone: $("#phone").val() // Изменено на 'phone'
        },
        error: function (result) {
            alert(result['message']);
        },
        success: function (result) {
            if (result['status'] == true) {
                alert("Новый водитель успешно добавлен!");
                window.location.href = '../Driver'; // Изменено на '/medibed/driver'
            }
            else {
                alert(result['message']);
            }
        }
    });
  }
}
</script>

