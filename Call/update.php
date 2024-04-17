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
    <form role="form">
      <div class="box-body">
      <div class="form-group">
      <label for="type">Тип помощи</label>
      <select class="form-control" id="type">
      <option value = "Консультация">Консультация</option>
      <option value = "Вызов бригады">Вызов бригады</option>
      </select>
    </div>
      <div class="form-group">
      <label for="crew">Номер бригады</label>
      <select class="form-control" id="crew">
      <!-- Здесь будут опции для выбора бригады -->
      </select>
        </div>
        <div class="form-group">
          <label for="patient">Пациент</label>
          <select class="form-control" id="patient">
            <!-- Здесь будут опции для выбора пациента -->
          </select>
        </div>
        <div class="form-group">
        <label for="adress">Адрес</label>
        <input required type="text" class="form-control" id="adress" placeholder="Введите адрес" >
        </div>
        <div class="form-group">
        <label for="adress">Номер телефона</label>
        <input required type="tel" class="form-control" id="phone" placeholder="+79001114455" maxlength = 11>
        </div>

      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <input type="button" class="btn btn-primary" onClick="UpdateCall()" value="Изменить вызов"></input>
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

        // Теперь, когда данные о вызове успешно получены и заполнены в форме, выполняем запросы на получение данных об экипажах и пациентах
        
      },
      error: function(result) {
        console.log(result);
      },
    });

  });
  $.ajax({
    type: "GET",
    url: "../api/call/getCrews.php",
    dataType: 'json',
    success: function(data) {
      var options = "";
      options += "<option value=''>" + "Бригада не требуется" + "</option>";
      for (var i = 0; i < data.length; i++) {
        options += "<option value='" + data[i].id_crew + "'>" + data[i].id_crew + "</option>";
      }
      $("#crew").html(options);
    }
  });

  $.ajax({
    type: "GET",
    url: "../api/call/getPatients.php",
    dataType: 'json',
    success: function(data) {
      var options = "";
      options += "<option value=''>" + "Добавить позже" + "</option>";
      for (var i = 0; i < data.length; i++) {
        options += "<option value='" + data[i].id_patient + "'>" + data[i].name + "</option>";
      }
      $("#patient").html(options);
    }
  });
  

  function UpdateCall() {
    $.ajax({
      type: "POST",
      url: '../api/call/update.php',
      dataType: 'json',
      data: {
        id: <?php echo $_GET['id']; ?>,
        id_driver: $("#driver").val(),
        id_doctor: $("#doctor").val(),
        id_paramedic: $("#paramedic").val(),
        id_orderly: $("#orderly").val()
      },
      error: function(result) {
        alert(result['message']);
      },
      success: function(result) {
        if (result['status'] == true) {
          alert("Данные экипажа обновлены!");
          //console.log(data);
          window.location.href = '/medibed/crew';
        } else {
          alert(result['message']);
        }
      }
    });
  }
</script>