<?php
$content = '<div class="row">
<!-- left column -->
<div class="col-md-12">
 <!-- general form elements -->
 <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Добавить пациента</h3>
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
          <label for="exampleInputName1">Адрес</label> 
          <input type="text" class="form-control" id="adress" placeholder="Введите адрес">
        </div>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <input type="button" class="btn btn-primary" onClick="AddPatient()" value="Добавить"></input>
      </div>
    </form>
 </div>
 <!-- /.box -->
</div>
</div>';

include '../master.php';
?>
<script>
function AddPatient(){
    $.ajax({
        type: "POST",
        url: '../api/patient/create.php',
        dataType: 'json',
        data: {
            name: $("#name").val(),
            number: $("#number").val(),
            adress: $("#adress").val()
        },
        error: function (result) {
            alert(result['message']);
        },
        success: function (result) {
            if (result['status'] == true) {
                alert("Новый пациент успешно добавлен!");
                window.location.href = '../Patient';
            }
            else {
                alert(result['message']);
            }
        }
    });
}

</script>
