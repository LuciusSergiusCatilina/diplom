<?php
session_start();
if ($_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'Начальник отдела кадров') {
    header("location:../notenoughpermission.php");
}
 $content = '<div class="row">
                <!-- left column -->
                <div class="col-md-12">
                 <!-- general form elements -->
                 <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title">Изменить данные врача</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" id="formDoctor">
                      <div class="box-body">
                        <div class="form-group">
                          <label for="exampleInputName1">ФИО</label>
                          <input required type="text" class="form-control" id="name" placeholder="Введите ФИО" name="name">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputName1">Номер телефона</label>
                          <input type="tel" class="form-control" id="number" placeholder="Введите номер телефона" name="number" maxlength = 12> 
                        </div>
                        <div class="form-group">
                          <label for="exampleInputName1">Специализация</label> 
                          <input type="text" class="form-control" id="specialization" placeholder="Введите специализацию" name="specialization">
                        </div>
                      </div>
                      <!-- /.box-body -->
                      <div class="box-footer">
                        <input type="button" class="btn btn-primary" onClick="UpdateDoctor()" value="Изменить"></input>
                        <input type="button" class="btn btn-danger" onClick="window.location.href = `../Doctor` " value="Назад"></input>
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
            url: "../api/doctor/read_single.php?id=<?php echo $_GET['id']; ?>",
            dataType: 'json',
            success: function(data) {
                $('#name').val(data['name']);
                $('#number').val(data['number']); // Изменено с "phone" на "number"
                $('#specialization').val(data['specialization']); // Изменено с "specialist" на "specialization"
            },
            error: function (result) {
                console.log(result);
            },
        });

        $.validator.addMethod("russianPhoneNumber", function(value, element) {
      return this.optional(element) || /^((\+7|7|8)+([0-9]){10})$/.test(value);
    }, "Укажите телефон в формате +79991112244");

    $.validator.addMethod("russianLetters", function(value, element) {
      return this.optional(element) || /^[А-Яа-яЁё\s]+$/.test(value);
    }, "Пожалуйста, введите только русские буквы.");

    // Form validation
    $("#formDoctor").validate({
      rules: {
        name: {
          required: true,
          minlength: 10,
          russianLetters: true
        },
        number: {
          required: true,
          minlength: 11,
          russianPhoneNumber: true
        },
        specialization: {
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
        number: {
          required: "Пожалуйста, введите номер телефона",
          minlength: "Слишком короткий номер телефона",
          russianPhoneNumber: "Пожалуйста, введите телефон в формате +79991112244"
        },
        specialization: {
          required: "Пожалуйста, введите специальность",
          minlength: "Слишком короткое название специальности"
        }
      }
    });

    });
    function UpdateDoctor(){
      if ($("#formDoctor").valid()){
        $.ajax(
        {
            type: "POST",
            url: '../api/doctor/update.php',
            dataType: 'json',
            data: {
                id: <?php echo $_GET['id']; ?>,
                name: $("#name").val(),
                number: $("#number").val(), 
                specialization: $("#specialization").val() 
            },
            error: function (result) {
                alert(result['message']);
            },
            success: function (result) {
                if (result['status'] == true) {
                    alert("Данные изменены!");
                    window.location.href = '../Doctor';
                }
                else {
                    alert(result['message']);
                }
            }
        });
    }
  }
</script>
