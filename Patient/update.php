<?php
$content = '<div class="row">
<!-- left column -->
<div class="col-md-12">
 <!-- general form elements -->
 <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Изменить данные пациента</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form role="form">
      <div class="box-body">
        <div class="form-group">
          <label for="exampleInputName1">ФИО</label>
          <input type="text" class="form-control" id="name" placeholder="Введите ФИО">
        </div>
        <div class="form-group">
          <label for="exampleInputName1">Номер телефона</label>
          <input type="text" class="form-control" id="number" placeholder="Введите номер"> 
        </div>
        <div class="form-group">
          <label for="exampleInputName1">Адрес</label> 
          <input type="text" class="form-control" id="adress" placeholder="Введите адрес">
        </div>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <input type="button" class="btn btn-primary" onClick="UpdatePatient()" value="Изменить"></input>
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
        url: "../api/patient/read_single.php?id=<?php echo $_GET['id']; ?>",
        dataType: 'json',
        success: function(data) {
            $('#name').val(data['name']);
            $('#number').val(data['number']);
            $('#adress').val(data['adress']);
        },
        error: function (result) {
            console.log(result);
        },
    });
});

function UpdatePatient(){
    $.ajax({
        type: "POST",
        url: '../api/patient/update.php',
        dataType: 'json',
        data: {
            id: <?php echo $_GET['id']; ?>,
            name: $("#name").val(),
            number: $("#number").val(),
            adress: $("#adress").val()
        },
        error: function (result) {
            alert(result['message']);
        },
        success: function (result) {
            if (result['status'] == true) {
                alert("Данные изменены!");
                window.location.href = '../Patient';
            }
            else {
                alert(result['message']);
            }
        }
    });
}
</script>
