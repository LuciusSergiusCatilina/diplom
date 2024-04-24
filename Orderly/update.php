<?php
$content = '<div class="row">
<!-- left column -->
<div class="col-md-12">
 <!-- general form elements -->
 <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Изменить данные санитара</h3>
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
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <input type="button" class="btn btn-primary" onClick="UpdateOrderly()" value="Изменить"></input>
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
        url: "../api/orderly/read_single.php?id=<?php echo $_GET['id']; ?>",
        dataType: 'json',
        success: function(data) {
            $('#name').val(data['name']);
            $('#number').val(data['number']);
        },
        error: function (result) {
            console.log(result);
        },
    });
});

function UpdateOrderly(){
    $.ajax({
        type: "POST",
        url: '../api/orderly/update.php',
        dataType: 'json',
        data: {
            id: <?php echo $_GET['id']; ?>,
            name: $("#name").val(),
            number: $("#number").val()
        },
        error: function (result) {
            alert(result['message']);
        },
        success: function (result) {
            if (result['status'] == true) {
                alert("Данные изменены!");
                window.location.href = '../Orderly';
            }
            else {
                alert(result['message']);
            }
        }
    });
}

</script>
