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
                    <form role="form">
                      <div class="box-body">
                        <div class="form-group">
                          <label for="exampleInputName1">ФИО</label>
                          <input required type="text" class="form-control" id="name" placeholder="Введите ФИО" >
                        </div>
                        <div class="form-group">
                          <label for="exampleInputName1">Номер телефона</label>
                          <input type="tel" class="form-control" id="number" placeholder="Введите номер телефона"> 
                        </div>
                        <div class="form-group">
                          <label for="exampleInputName1">Специализация</label> 
                          <input type="text" class="form-control" id="specialization" placeholder="Введите специализацию">
                        </div>
                      </div>
                      <!-- /.box-body -->
                      <div class="box-footer">
                        <input type="button" class="btn btn-primary" onClick="AddDoctor()" value="Добавить"></input>
                      </div>
                    </form>
                 </div>
                 <!-- /.box -->
                </div>
              </div>';
 include('../master.php');
?>
<script>
 function AddDoctor(){

        $.ajax(
        {
            type: "POST",
            url: '../api/doctor/create.php',
            dataType: 'json',
            data: {
                name: $("#name").val(),
                number: $("#number").val(),
                specialization: $("#specialization").val() 
            },
            error: function (result) {
                alert(result['message']);
            },
            success: function (result) {
                if (result['status'] == true) {
                    alert("Новый врач успешно добавлен!");
                    window.location.href = '../Doctor';
                }
                else {
                    alert(result['message']);
                }
            }
        });
    }
</script>
