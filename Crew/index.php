<?php
session_start();
$hasPermission = ($_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'Начальник подстанции');
$content = '
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-xs-9">
                        <h3 class="box-title">Список бригад</h3>
                    </div>
                    <div class="col-xs-3">
                        <form action="#" method="get" class="pull-right">
                            <div class="input-group">
                                <input type="text" name="search" id="search" class="form-control input-sm" onkeyup="searchFunction(`crews`)" placeholder="Поиск">
                                <span class="input-group-btn">
                                    <button type="submit" name="search" id="search-btn" class="btn btn-flat btn-sm"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive"> <!-- Обернули таблицу здесь -->
                    <table id="crews" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Номер бригады</th>
                                <th>Водитель</th>
                                <th>Доктор</th>
                                <th>Санитар</th>
                                <th>Фельдшер</th>
                                ' .  ($hasPermission ? "<th>Готовность</th>" : "") . '
                                ' .  ($hasPermission ? "<th>Действия</th>" : "") . '
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Здесь будут строки таблицы -->
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
<script src = "../dist/js/searchBar.js"></script>
';
include('../master.php');
?>
<!-- page script -->
<script>
    $(document).ready(function(){
        $.ajax({
            type: "GET",
            url: "../api/crew/read.php",
            dataType: 'json',
            success: function(data) {
                var response = "";
                for (var crew in data) {
                    response += "<tr>" +
                        "<td>" + data[crew].id_crew + "</td>" +
                        "<td>" + data[crew].driver_name + "</td>" +
                        "<td>" + data[crew].doctor_name + "</td>" +
                        "<td>" + data[crew].orderly_name + "</td>" +
                        "<td>" + (data[crew].paramedic_name ? data[crew].paramedic_name : "Отсутствует") + "</td>";
                  <?php if ($hasPermission): ?>
                    response += "<td class='text-center'><input type='checkbox' class='status-checkbox' data-brigade-id='" + data[crew].id_crew + "'" + (data[crew].is_available ? " checked" : "") + "></td>";
                    response += "<td><a href='update.php?id=" + data[crew].id_crew + "'>Изменить</a> | <a href='#' onClick='Remove(\"" + data[crew].id_crew + "\")'>Удалить</a></td>";
                  <?php endif; ?>
                    response += "</tr>";
                }
                $(response).appendTo($("#crews tbody"));
            }
        });
    });

    $(document).on('change', '.status-checkbox', function() {
        const brigadeId = $(this).data('brigade-id');
        const isAvailable = $(this).is(':checked') ? 1 : 0;

        $.ajax({
            type: 'POST',
            url: '../api/crew/update_status.php',
            data: JSON.stringify({
                id_crew: brigadeId,
                is_available: isAvailable
            }),
            contentType: 'application/json',
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    console.log('Status updated successfully');
                } else {
                    console.error('Failed to update status');
                }
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    });

    function Remove(id) {
        if (confirm("Вы уверены что хотите удалить экипаж?")) {
            $.ajax({
                type: "POST",
                url: '../api/crew/delete.php',
                dataType: 'json',
                data: JSON.stringify({ id: id }),
                contentType: 'application/json',
                success: function(result) {
                    if (result.status) {
                        alert("Экипаж успешно удалён");
                        window.location.href = '../Crew';
                    } else {
                        alert(result.message);
                    }
                },
                error: function(result) {
                    alert(result.responseText);
                }
            });
        }
    }
</script>
