<?php
session_start();
if (($_SESSION['user_role'] !== 'admin') && ($_SESSION['user_role'] !== 'Начальник подстанции') && ($_SESSION['user_role'] !== 'Диспетчер')) {
    header("location:../notenoughpermission.php");
}
$content = '<div class="row">
<!-- left column -->
<div class="col-md-12">
 <!-- general form elements -->
 <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Добавить пациента</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form role="form" id = "formPatient">
      <div class="box-body">
        <div class="form-group">
          <label for="exampleInputName1">ФИО</label>
          <input required type="text" class="form-control" id="name" placeholder="Введите ФИО" name ="name">
        </div>
        <div class="form-group">
          <label for="exampleInputName1">Номер телефона</label>
          <input type="tel" class="form-control" id="number" placeholder="Введите номер телефона" name = "phone" minlength="11" maxlength="12"> 
        </div>
        <div class="form-group">
          <label for="exampleInputName1">Адрес</label> 
          <input type="text" class="form-control" id="adress" placeholder="Введите адрес" name = "adress">
        </div>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <input type="button" class="btn btn-primary" onClick="AddPatient()" value="Добавить"></input>
        <input type="button" class="btn btn-danger" onClick="window.location.href = `../Patient` " value="Назад"></input>
      </div>
    </form>
 </div>
 <!-- /.box -->
</div>
</div>';

include '../master.php';
?>
<script>
    $(document).ready(function() {
        // Custom validation methods
        $.validator.addMethod("russianPhoneNumber", function(value, element) {
            return this.optional(element) || /^((\+7|7|8)+([0-9]){10})$/.test(value);
        }, "Укажите телефон в формате +79991112244");

        $.validator.addMethod("russianLetters", function(value, element) {
            return this.optional(element) || /^[А-Яа-яЁё\s]+$/.test(value);
        }, "Пожалуйста, введите только русские буквы.");

        // Form validation
        $("#formPatient").validate({
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
                adress: {
                    required: true,
                    minlength: 5
                }
            },
            messages: {
                name: {
                    required: "Пожалуйста, введите ФИО",
                    minlength: "Слишком короткое ФИО",
                    russianLetters: "Пожалуйста, введите только русские буквы"
                },
                phone: {
                    required: "Пожалуйста, введите номер телефона",
                    minlength: "Пожалуйста, введите телефон в формате +79991112244",
                    russianPhoneNumber: "Пожалуйста, введите телефон в формате +79991112244"
                },
                adress: {
                    required: "Пожалуйста, введите адрес",
                    minlength: "Слишком короткий адрес"
                }
            }
        });
    });
function AddPatient(){
    if($("#formPatient").valid()) {
        $.ajax({
            type: "POST",
            url: '../api/patient/create.php',
            dataType: 'json',
            data: {
                name: $("#name").val(),
                number: $("#number").val(),
                adress: $("#adress").val()
            },
            error: function (result) {
                alert(result['message']);
            },
            success: function (result) {
                if (result['status'] == true) {
                    alert("Новый пациент успешно добавлен!");
                    window.location.href = '../Patient';
                } else {
                    alert(result['message']);
                }
            }
        });
    }
}

</script>
