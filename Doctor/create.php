<?php 
 $content = '<div class="row">
                <!-- left column -->
                <div class="col-md-12">
                 <!-- general form elements -->
                 <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title">Добавить врача</h3>
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
                        <input type="button" class="btn btn-primary" onClick="AddDoctor(event)" value="Добавить"></input>
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
  $(document).ready(function() {
    // Custom validation methods
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

  function AddDoctor(event) {
    if ($("#formDoctor").valid()) {
      $.ajax({
        type: "POST",
        url: '../api/doctor/create.php',
        dataType: 'json',
        data: {
          name: $("#name").val(),
          number: $("#number").val(),
          specialization: $("#specialization").val()
        },
        error: function(result) {
          alert(result['message']);
        },
        success: function(result) {
          if (result['status'] == true) {
            alert("Новый врач успешно добавлен!");
            window.location.href = '../Doctor';
          } else {
            alert(result['message']);
          }
        }
      });
    }
  }
</script>
