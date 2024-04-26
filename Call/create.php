<?php
$content = '<div class="row">
                <!-- left column -->
                <div class="col-md-12">
                 <!-- general form elements -->
                 <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title">Добавить вызов</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form">
                      <div class="box-body">
                      <div class="form-group">
                      <label for="type">Тип помощи</label>
                      <select class="form-control" id="type">
                      <option selected value = "Консультация" >Консультация</option>
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
                        <input type="button" class="btn btn-primary" onClick="AddCrew()" value="Добавить вызов"></input>
                        <input type="button" class="btn btn-danger" onClick="window.history.back();" value="Назад"></input>
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
    checkCrew("type","crew");
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

    $("#type").change(function(){
      checkCrew("type","crew");
    });
  });

  function AddCrew() {
    $.ajax({
      type: "POST",
      url: '../api/call/create.php',
      dataType: 'json',
      data: {
        id_crew: $('#crew').val(),
        type: $("#type").val(),
        id_patient: $('#patient').val(),
        adress: $("#adress").val(),
        number: $("#phone").val()
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error("Ошибка в функции AddCall():", textStatus, errorThrown);
        console.log("Полученные данные:", jqXHR.responseText);
        alert("Произошла ошибка при добавлении вызова. Пожалуйста, попробуйте еще раз.");
      },
      success: function(result) {
        console.log({
        id_crew: $('#crew').val(),
        type: $("#type").val(),
        id_patient: $('#patient').val(),
        adress: $("#adress").val(),
        number: $("#phone").val() 
        });
        if (result['status'] == true) {
          alert("Вызов успешно добавлен!");
          // Предполагается, что сервер возвращает URL для перенаправления
          if (result['redirectUrl']) {
            window.location.href = result['redirectUrl'];
          } else {
            // Если URL для перенаправления не предоставлен, используйте заранее определенный URL
            window.location.href = '../Call';
          }
        } else {
          alert(result['message']);
        }
      }
    });
  }
  function checkCrew(type, crew){
    let selectedType = $(`#${type}`).val();
      console.log(selectedType);
    let selectedCrew = $(`#${crew}`);
    if (selectedType === "Консультация"){
      selectedCrew.prop("disabled", true);
      selectedCrew[0].selectedIndex = 0;
    }
    else if (selectedType === "Вызов бригады"){
      selectedCrew.prop("disabled", false);
      
    }
    
  }
</script>