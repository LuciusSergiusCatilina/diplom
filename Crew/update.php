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
                    <form role="form">
                      <div class="box-body">
                      <div class="form-group">
                      <label for="exampleInputName1">ID экипажа</label>
                      <input required type="text" class="form-control" id="crew" placeholder="Введите номер экипажа" >
                        </div>
                        <div class="form-group">
                          <label for="driver">Водитель</label>
                          <select class="form-control" id="driver">
                            <!-- Здесь будут опции для выбора водителя -->
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="doctor">Доктор</label>
                          <select class="form-control" id="doctor">
                            <!-- Здесь будут опции для выбора доктора -->
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="paramedic">Фельдшер</label>
                          <select class="form-control" id="paramedic">
                          
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="orderly">Санитар</label>
                          <select class="form-control" id="orderly">

                          </select>
                        </div>
                      </div>
                      <!-- /.box-body -->
                      <div class="box-footer">
                        <input type="button" class="btn btn-primary" onClick="UpdateCrew()" value="Изменить бригаду"></input>
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
            url: "../api/crew/read_single.php?id=<?php echo $_GET['id']; ?>",
            dataType: 'json',
            success: function(data) {
                //$('#crew').val(data['id_crew'])
                $('#driver').val(data['id_driver']);
                $('#doctor').val(data['id_doctor']);
                $('#paramedic').val(data['id_paramedic']);
                $('#orderly').val(data['id_orderly']);
            },
            error: function (result) {
                console.log(result);
            },
        });
    });
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
            options += "<option value=''>" + "Нет парамедика" + "</option>";
            for(var i = 0; i < data.length; i++) {
                options += "<option value='" + data[i].id_paramedic + "'>" + data[i].name + "</option>";
            }

            $("#paramedic").html(options);
        }
    });

    function UpdateCrew(){
        $.ajax(
        {
            type: "POST",
            url: '../api/crew/update.php',
            dataType: 'json',
            data: {
                id: <?php echo $_GET['id']; ?>,
                id_driver: $("#driver").val(),
                id_doctor: $("#doctor").val(),
                id_paramedic: $("#paramedic").val(),
                id_orderly: $("#orderly").val()
            },
            error: function (result) {
                alert(result['message']);
            },
            success: function (result) {
                if (result['status'] == true) {
                    alert("Данные экипажа обновлены!");
                    window.location.href = '../Crew';
                }
                else {
                    alert(result['message']);
                }
            }
        });
    }
</script>
