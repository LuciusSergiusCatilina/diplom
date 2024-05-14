<?php
$content = '<div class="row">
<!-- left column -->
<div class="col-md-12">
 <!-- general form elements -->
 <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Изменить вызов</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form id = "formCalls" role="form">
      <div class="box-body">
      <div class="form-group">
      <label for="type">Тип помощи</label>
      <select class="form-control" id="type" name="type">
      <option value = "Консультация">Консультация</option>
      <option value = "Вызов бригады">Вызов бригады</option>
      </select>
    </div>
      <div class="form-group">
      <label for="crew">Номер бригады</label>
      <select class="form-control" id="crew" name ="crew">
      <!-- Здесь будут опции для выбора бригады -->
      </select>
        </div>
        <div class="form-group">
          <label for="patient">Пациент</label>
          <select class="form-control" id="patient" name="patient">
            <!-- Здесь будут опции для выбора пациента -->
          </select>
        </div>
        <div class="form-group">
        <label for="adress">Адрес</label>
        <input required type="text" class="form-control" id="adress" name ="adress" placeholder="Введите адрес" >
        </div>
        <div class="form-group">
        <label for="adress">Номер телефона</label>
        <input required type="tel" class="form-control" id="phone" name ="phone" placeholder="+79001114455" maxlength = 11>
        </div>

      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <input type="button" class="btn btn-primary" onClick="UpdateCall()" value="Изменить вызов"></input>
        <button type="button" class="btn btn-danger" onClick="window.location.href=\'../Call\'">Назад</button>
      </div>
    </form>
 </div>
 <!-- /.box -->
</div>
</div>

<!-- Модальное окно для отображения успешного обновления данных -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="successModalLabel">Успех!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Данные успешно обновлены!
      </div>
    </div>
  </div>
</div>';
include('../master.php');
?>
<script>
  
  $(document).ready(function() {
    $.ajax({
        type: "GET",
        url: "../api/call/getCrews.php",
        dataType: 'json',
        success: function(data) {
            var options = "<option value=''>Бригада не требуется</option>";
            for (var i = 0; i < data.length; i++) {
                options += "<option value='" + data[i].id_crew + "'>" + data[i].id_crew + "</option>";
            }
            $("#crew").html(options);
            checkCrew("type", "crew");
        }
    });

    $.ajax({
        type: "GET",
        url: "../api/call/getPatients.php",
        dataType: 'json',
        success: function(data) {
            var options = "<option value=''>Добавить позже</option>";
            for (var i = 0; i < data.length; i++) {
                options += "<option value='" + data[i].id_patient + "'>" + data[i].name + "</option>";
            }
            $("#patient").html(options);
        }
    });

    $.ajax({
        type: "GET",
        url: "../api/call/read_single.php?id=<?php echo $_GET['id']; ?>",
        dataType: 'json',
        success: function(data) {
            $('#crew').val(data['id_crew'])
            $('#type').val(data['type']);
            $('#patient').val(data['id_patient']);
            $('#adress').val(data['adress']);
            $('#phone').val(data['number']);
        },
        error: function(result) {
            console.log(result);
        },
    });

    $("#type").change(function() {
    checkCrew("type", "crew");
    });

});

$("#type").change(function() {
    checkCrew("type", "crew");
});

function UpdateCall() {
    event.preventDefault();

    var isValid = $("#formCalls").valid();

    if (isValid) {
        $.ajax({
            type: "POST",
            url: '../api/call/update.php',
            dataType: 'json',
            data: {
                id_call: <?php echo $_GET['id']; ?>,
                id_crew: $("#crew").val(),
                id_patient: $("#patient").val(),
                adress: $("#adress").val(),
                type: $("#type").val(),
                number: $("#phone").val()
            },
            error: function(result) {
                alert(result['message']);
            },
            success: function(result) {
                if (result['status'] == true) {
                    $("#successModal").modal("show");
                    setTimeout(function() {
                        window.location.href = '../Call';
                    }, 2500);
                } else {
                    alert(result['message']);
                }
            }
        });
    }
}

function checkCrew(type, crew) {
    let selectedType = $(`#${type}`).val();
    let selectedCrew = $(`#${crew}`);
    let consultationOption = $("<option>").text("Бригада не требуется").val("");
    if (selectedType === "Консультация") {
        if (selectedCrew.find("option:first-child").text() !== "Бригада не требуется") {
            selectedCrew.prepend(consultationOption);
        }
        selectedCrew.prop("disabled", true).val("");
    } else if (selectedType === "Вызов бригады") {
        selectedCrew.find("option:first-child").remove();
        selectedCrew.prop("disabled", false);
    }
}


$("#formCalls").validate({
    rules: {
        type: {
            required: true
        },
        crew: {
            required: true
        },
        adress: {
            required: true
        },
        phone: {
            required: true,
            russianPhoneNumber: true,
            // minlength: 12,
            // maxlength: 12
        }
    },
    messages: {
        type: "Пожалуйста, выберите тип помощи",
        crew: "Пожалуйста, выберите номер бригады",
        adress: "Пожалуйста, введите адрес",
        phone: {
            regex: "Пожалуйста, введите корректный номер телефона в формате +79001114455",
            required: "Пожалуйста, введите номер телефона"
            // minlength: "Номер телефона должен быть длиной 12 цифр",
            // maxlength: "Номер телефона должен быть длиной 11 цифр"
        }
    }
});

$.validator.addMethod("russianPhoneNumber", function(value, element) {
    return this.optional(element) || /^((\+7|7|8)+([0-9]){10})$/.test(value);
}, "Укажите телефон в формате +79991112244");

</script>
