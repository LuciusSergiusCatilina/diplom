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
      <h3 class="box-title">Добавить парамедика</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form role="form" id = "formParamedic">
      <div class="box-body">
        <div class="form-group">
          <label for="exampleInputName1">Имя</label>
          <input required type="text" class="form-control" id="name" placeholder="Введите ФИО" name = "name" minlength="10">
        </div>
        <div class="form-group">
          <label for="exampleInputName1">Телефон</label>
          <input type="tel" class="form-control" id="number" placeholder="Введите номер телефона" name = "phone" minlength="12" maxlength="12"> 
        </div>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <input type="button" class="btn btn-primary" onClick="AddParamedic()" value="Добавить"></input>
        <input type="button" class="btn btn-danger" onClick="window.location.href = `../Paramedic` " value="Назад"></input>
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
        $("#formParamedic").validate({
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
function AddParamedic(){
    if ($("#formParamedic").valid()) {
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
                    window.location.href = '../Paramedic'; // Изменено на '/medibed/paramedic'
                } else {
                    alert(result['message']);
                }
            }
        });
    }
}
</script>

