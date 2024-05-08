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
                      <option value = "Консультация" >Консультация</option>
                      <option value = "Вызов бригады" selected>Вызов бригады</option>
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
                        <label for="phone">Номер телефона</label>
                        <input required type="tel" class="form-control" id="phone" placeholder="+79001114455" maxlength = 11>
                        </div>

                      </div>
                      <!-- /.box-body -->
                      <div class="box-footer">
                        <input type="submit" class="btn btn-primary" onclick="AddCrew(event)" value="Добавить вызов"></input>
                        <input type="button" class="btn btn-danger" onClick="window.location.href = `../Call` " value="Назад"></input>
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
      url: "../api/call/getCrews.php",
      dataType: 'json',
      success: function(data) {
        var options = "";
        options += "<option value=''>" + "Бригада не требуется" + "</option>";
        for (var i = 0; i < data.length; i++) {
          options += "<option value='" + data[i].id_crew + "'>" + data[i].id_crew + "</option>";
        }
        $("#crew").html(options);
        checkCrew("type","crew");
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



  });
  $("#type").change(function(){
      checkCrew("type","crew");
    });

    function AddCrew(event){
      event.preventDefault();

$.ajax({
    type: "POST",
    url: '../api/call/create.php',
    dataType: 'json',
    data: {
        type: $('#type').val(),
        id_crew: $("#crew").val(),
        id_patient: $("#patient").val(),
        adress: $("#adress").val(),
        phone: $("#phone").val()
    },
    error: function (jqXHR, textStatus, errorThrown) {
        console.error("Ошибка в функции AddCall():", textStatus, errorThrown);
        console.log("Полученные данные:", jqXHR.responseText);
        alert("Произошла ошибка при добавлении экипажа. Пожалуйста, попробуйте еще раз.");
    },
    success: function (result) {
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
    console.log("check")
    let selectedType = $(`#${type}`).val();
    console.log(selectedType);
    let selectedCrew = $(`#${crew}`);
    let consultationOption = document.createElement("option");
    let crewSelect = document.getElementById("crew");
    consultationOption.text = "Бригада не требуется";
    consultationOption.value = "";
    if (selectedType === "Консультация"){
      console.log(crewSelect.options[0].text)
       if (crewSelect.options[0].text !== "Бригада не требуется"){
             selectedCrew.prepend(consultationOption);  
       }
      selectedCrew.prop("disabled", true);
      selectedCrew[0].selectedIndex = 0;
    }
    else if (selectedType === "Вызов бригады"){
      let optionToRemove = crewSelect.options[0];
      crewSelect.remove(optionToRemove); 
      selectedCrew.prop("disabled", false);
    }
    
  }
</script>