<?php 
 $content = '<div class="row">
                <!-- left column -->
                <div class="col-md-12">
                 <!-- general form elements -->
                 <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title">Добавить экипаж</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" id = "formCrews">
                      <div class="box-body">
                      <div class="form-group">
                      <label for="exampleInputName1">Номер бригады</label>
                      <input required type="text" class="form-control" id="crew" name = "crew" placeholder="Введите номер экипажа" >
                        </div>
                        <div class="form-group">
                          <label for="driver">Водитель</label>
                          <select class="form-control" id="driver" name = "driver">
                            <!-- Здесь будут опции для выбора водителя -->
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="doctor">Доктор</label>
                          <select class="form-control" id="doctor" name = "doctor">
                            <!-- Здесь будут опции для выбора доктора -->
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="paramedic">Фельдшер</label>
                          <select class="form-control" id="paramedic" name = "paramedic">
                          
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="orderly">Санитар</label>
                          <select class="form-control" id="orderly" name = "orderly">

                          </select>
                        </div>
                      </div>
                      <!-- /.box-body -->
                      <div class="box-footer">
                        <input type="button" class="btn btn-primary" onClick="AddCrew(event)" value="Добавить экипаж"></input>
                        <input type="button" class="btn btn-danger" onClick="window.location.href = `../Crew` " value="Назад"></input>
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
        url: "../api/crew/getDrivers.php", 
        dataType: 'json',
        success: function(data) {
            var options = "";
            for(var i = 0; i < data.length; i++) {
                options += "<option value='" + data[i].id_drivers + "'>" + data[i].name + "</option>";
            }
            $("#driver").html(options);
        }
    });
    $.ajax({
        type: "GET",
        url: "../api/crew/getDoctors.php", 
        dataType: 'json',
        success: function(data) {
            var options = "";
            for(var i = 0; i < data.length; i++) {
                options += "<option value='" + data[i].id_doctor + "'>" + data[i].name + "</option>";
            }
            $("#doctor").html(options);
        }
    });
    $.ajax({
        type: "GET",
        url: "../api/crew/getOrderly.php", 
        dataType: 'json',
        success: function(data) {
            var options = "";
            for(var i = 0; i < data.length; i++) {
                options += "<option value='" + data[i].id_orderly + "'>" + data[i].name + "</option>";
            }
            $("#orderly").html(options);
        }
    });
    $.ajax({
        type: "GET",
        url: "../api/crew/getParamedics.php", 
        dataType: 'json',
        success: function(data) {
            var options = "";
            options += "<option value=''>" + "Нет фельдшера" + "</option>";
            for(var i = 0; i < data.length; i++) {
                options += "<option value='" + data[i].id_paramedic + "'>" + data[i].name + "</option>";
            }

            $("#paramedic").html(options);
        }
    });
    $("#formCrews").validate({
        rules: {
            crew: {
                required: true
            },
            driver: {
                required: true
            },
            doctor: {
                required: true
            },
            orderly: {
                required: true,
            }
        },
        messages: {
            crew: "Пожалуйста, выберите номер бригады",
            driver: "Пожалуйста, выберите водителя",
            doctor: "Пожалуйста, выберите врача",
            orderly: "Пожалуйста, выберите санитара",
        }
    });
});
function AddCrew(event){
    event.preventDefault();
    const isValid = $("#formCrews").valid();
    if (isValid){
    $.ajax({
        type: "POST",
        url: '../api/crew/create.php',
        dataType: 'json',
        data: {
            id_crew: $('#crew').val(),
            id_driver: $("#driver").val(),
            id_doctor: $("#doctor").val(),
            id_paramedic: $("#paramedic").val(),
            id_orderly: $("#orderly").val()
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("Ошибка в функции AddCrew():", textStatus, errorThrown);
            console.log("Полученные данные:", jqXHR.responseText);
            alert("Произошла ошибка при добавлении экипажа. Пожалуйста, попробуйте еще раз.");
        },
        success: function (result) {
            if (result['status'] == true) {
                alert("Экипаж успешно добавлен!");
                // Предполагается, что сервер возвращает URL для перенаправления
                if (result['redirectUrl']) {
                    window.location.href = result['redirectUrl'];
                } else {
                    // Если URL для перенаправления не предоставлен, используйте заранее определенный URL
                    window.location.href = '../Crew';
                }
            } else {
                alert(result['message']);
            }
        }
    });
}
}


</script>
