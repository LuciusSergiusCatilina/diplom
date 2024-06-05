<?php
session_start();
if ($_SESSION['user_id'] != $_GET['id']) {
  header("location:../notenoughpermission.php");
  exit;
}
$id = $_GET['id'];
$content = '
  <style>
    .form-control {
      height: 34px; 
    }
    #profilePicturePreview {
      max-width: 200px;
      margin-top: 10px;
    }
  </style>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Редактировать профиль</h3>
            </div>
            <form id="profileForm" role="form" enctype="multipart/form-data" method="POST" action="api/User/update.php">
                <div class="box-body">
                    <div class="form-group">
                        <label for="name">Имя</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Введите ваше имя" required>
                    </div>
                    <div class="form-group">
                        <label for="profilePicture">Фото профиля</label>
                        <input type="file" id="profilePicture" name="profilePicture" accept="image/*" onchange="previewProfilePicture(event)">
                        <p class="help-block">Выберите новое фото профиля.</p>
                        <img id="profilePicturePreview" src="#" alt="*тут будет ваше фото*" style="display: none;">
                    </div>
                    <input type="hidden" name="id" value=" '.$id.'">
                    <input type="hidden" id="existingPhoto" name="existingPhoto">
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                    <button type="button" class="btn btn-danger" onClick="window.location.href = `../dashboard.php`">Назад</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="successModalLabel">Успешно!</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Профиль успешно обновлен!
            </div>
        </div>
    </div>
</div>
';
include 'master.php';
?>
<script>
    $(document).ready(function(){
        $.ajax({
            type: "GET",
            url: "../api/User/read_single.php?id=<?php echo $_GET['id']; ?>",
            dataType: 'json',
            success: function(data) {
                $('#name').val(data.name);
                if (data.photo) {
                    $('#profilePicturePreview').attr('src', data.photo).show();
                    $('#existingPhoto').val(data.photo);
                }
            },
            error: function (result) {
                console.log(result);
            },
        });
    });

    function previewProfilePicture(event) {
        var input = event.target;
        var reader = new FileReader();
        reader.onload = function(){
            var profilePicturePreview = document.getElementById('profilePicturePreview');
            profilePicturePreview.src = reader.result;
            profilePicturePreview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
</script>
