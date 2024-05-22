<?php
$content = '<div class="row">
<!-- left column -->
<div class="col-md-12">
 <!-- general form elements -->
 <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Изменить данные санитара</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form role="form" id = "formOrderly">
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
        <input type="button" class="btn btn-primary" onClick="UpdateOrderly()" value="Изменить"></input>
        <input type="button" class="btn btn-danger" onClick="window.location.href = `../Orderly` " value="Назад"></input>
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

    $.validator.addMethod("russianPhoneNumber", function(value, element) {
        return this.optional(element) || /^((\+7|7|8)+([0-9]){10})$/.test(value);
    }, "Укажите телефон в формате +79991112244");

    $.validator.addMethod("russianLetters", function(value, element) {
        return this.optional(element) || /^[А-Яа-яЁё\s]+$/.test(value);
    }, "Пожалуйста, введите только русские буквы.");
    $("#formOrderly").validate({
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

    $.ajax({
        type: "GET",
        url: "../api/orderly/read_single.php?id=<?php echo $_GET['id']; ?>",
        dataType: 'json',
        success: function(data) {
            $('#name').val(data['name']);
            $('#number').val(data['number']);
        },
        error: function (result) {
            console.log(result);
        },
    });
});

function UpdateOrderly(){
    if ($("#formOrderly").valid()) {

        $.ajax({
            type: "POST",
            url: '../api/orderly/update.php',
            dataType: 'json',
            data: {
                id: <?php echo $_GET['id']; ?>,
                name: $("#name").val(),
                number: $("#number").val()
            },
            error: function (result) {
                alert(result['message']);
            },
            success: function (result) {
                if (result['status'] == true) {
                    alert("Данные изменены!");
                    window.location.href = '../Orderly';
                } else {
                    alert(result['message']);
                }
            }
        });
    }
}

</script>
