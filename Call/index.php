<?php
session_start();
$hasPermission = ($_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'Начальник подстанции' || $_SESSION['user_role'] === 'Диспетчер');
$content = '
<style>
    .pagination {
        justify-content: center;
    }
</style>
 <div class="col-xs-12">
 <div class="box">
     <div class="box-header">
         <div class="row">
             <div class="col-xs-6">
                 <h3 class="box-title">Список вызовов</h3>
             </div>
             <div class="col-xs-6">
                 <form action="#" method="get" class="pull-right">
                     <div class="input-group">
                         <input type="text" name="search" id="searchInput" class="form-control input-sm" placeholder="Поиск">
                         <span class="input-group-btn">
                             <button name="search" id="search-btn" class="btn btn-flat btn-sm"><i class="fa fa-search"></i></button>
                         </span>
                     </div>
                 </form>
             </div>
         </div>

         <div class="row">
             <div class="col-xs-6 col-sm-2">
                 <label for="startDate">Начальная дата:</label>
                 <input type="datetime-local" id="startDate" name="startDate" class="form-control input-sm">
             </div>
             <div class="col-xs-6 col-sm-2">
                 <label for="endDate" class="">Конечная дата:</label>
                 <input type="datetime-local" id="endDate" name="endDate" class="form-control input-sm">
             </div>
             <div class="col-xs-12 col-sm-2">
             <label for="endDate" class="">ㅤ</label>
                 <div class="input-group">
                     <span class="input-group-btn">
                         <button class="btn btn-default btn-sm" type="button" onclick="clearInput()">Очистить</button>
                     </span>
                 </div>
             </div>
         </div>
     </div>

     <div class="box-body">
         <div class="table-responsive">
             <table id="calls" class="table table-bordered table-hover">
                 <thead>
                     <tr>
                         <th>Номер вызова</th>
                         <th>Бригада</th>
                         <th>Адрес вызова</th>
                         <th>Номер вызывавшего</th>
                         <th>Пациент</th>
                         <th>Время вызова</th>
                         <th>Тип помощи</th>
                         ' .  ($hasPermission ? '<th >Действия <button id="actionPrint" title="Печать таблицы" class="btn btn-flat btn-sm pull-right"><i class="fa fa-file-text-o"></i></button></th>' : "") . '
                         
                     </tr>
                 </thead>
                 <tbody id="tableBody">
                     <!-- Тут будут данные таблицы -->
                 </tbody>
             </table>
             <ul class="pagination" id="pagination"></ul>

         </div>
     </div>
     <!-- /.box-body -->

     <div class="box-footer">
         <button id="add_button" class="btn btn-flat btn-sm pull-right"><a style="color: inherit" href="../Call/create.php">Добавить вызов</a></button>
     </div>
 </div>
</div>

<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Подтверждение удаления</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Вы уверены, что хотите удалить этот вызов?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Удалить</button>
            </div>
        </div>
    </div>
</div>


';

include('../master.php');
?>
<script>
    

    let dataTable;

    $(document).ready(function(){

        fetchAndUpdateTable()
        // Поиск по имени
        $('#searchInput').on('input', function(){
            fillTable(1);
        });
        $("#actionPrint").on('click', function (){
            let filteredData = filterData();
            printTable(filteredData);
        });
        $('#startDate').on('change', function(){
            fillTable(1);
        });
        $('#endDate').on('change', function(){
            fillTable(1);
        });
    });

    function Remove(id){
        $('#confirmDeleteModal').modal('show');

        $('#confirmDeleteButton').click(function(){
            $.ajax({
                type: "POST",
                url: '../api/call/delete.php',
                dataType: 'json',
                data: {
                    id: id
                },
                error: function (result) {
                    alert(result.responseText);
                },
                success: function (result) {
                    if (result['status'] === true) {
                        fetchAndUpdateTable();
                        $('#confirmDeleteModal').modal('hide');
                    }
                    else {
                        alert(result['message']);
                    }
                }
            });
        });
    }

    function fetchAndUpdateTable() {
        $.ajax({
            type: "GET",
            url: "../api/call/read.php",
            dataType: 'json',
            success: function(data) {
                dataTable = data;
                fillTable(1);
            }
        });
    }

    function clearInput() {
        document.getElementById("startDate").value = '';
        document.getElementById("endDate").value = '';
        fillTable(1);
        createPagination();
    }
    function fillTable(pageNumber) {
        let pageSize = 5; // Количество элементов на странице
        let startIndex = (pageNumber - 1) * pageSize;
        let endIndex = startIndex + pageSize;
        let filteredData = filterData();

        // Проверяем количество записей после фильтрации
        if (filteredData.length <= pageSize) {
            $('#pagination').empty(); // Очищаем пагинацию
        }

        let paginatedData = filteredData.slice(startIndex, endIndex);
        renderTable(paginatedData);
    }

    function filterData() {
        let searchInput = $('#searchInput').val().toLowerCase();
        let startDateInput = document.getElementById("startDate").value;
        let endDateInput = document.getElementById("endDate").value;

        let filteredData = dataTable.filter(function(item) {
            for (let key in item) {
                if (item.hasOwnProperty(key) && key !== 'time' && key !== "id_patient" && key !== "id_user") {
                    if (item[key] && item[key].toString().toLowerCase().includes(searchInput)) {
                        return true; // Найдено совпадение в текущем поле, возвращаем true
                    }
                }
            }
            return false; // Совпадений не найдено в текущем объекте, возвращаем false
        });

        // Фильтрация данных по выбранному периоду дат
        if (startDateInput && endDateInput) {
            filteredData = filteredData.filter(function (item) {
                let rowDate = new Date(item.time).getTime();
                let startDate = new Date(startDateInput).getTime();
                let endDate = new Date(endDateInput).getTime();
                return rowDate >= startDate && rowDate <= endDate;
            });
        }

        return filteredData;
    }

    function renderTable(data) {
        $('#tableBody').empty();
        $.each(data, function(index, item) {
            let date = new Date(item.time);
            let formatDateTime =  new Intl.DateTimeFormat("ru", {dateStyle:"long", timeStyle:"short"}).format(date);
            let brigade = item.id_crew ? item.id_crew : "Бригада не вызвана";
            let patient = item.patient_name ? item.patient_name : "Добавить позже";
            $('#tableBody').append(
                '<tr><td>' + item.id_call +
                '</td><td>' + brigade +
                '</td><td>' + item.adress +
                '</td><td>' + item.number +
                '</td><td>' + patient +
                "</td><td data-time = '" + date + "'>" + formatDateTime +
                '</td><td>' + item.type +
                <?php if ($hasPermission): ?>
                '</td><td id="action"><a href="update.php?id=' + item.id_call + '">Изменить</a> | <a href="#" onClick="Remove(\'' + item.id_call + '\')">Удалить</a></td></tr>'
                <?php endif; ?>
            );
        });
        createPagination();
    }

    // Функция для создания пагинации
    function createPagination() {
        let pageSize = 5; // Количество элементов на странице
        let pageCount = Math.ceil(filterData().length / pageSize);
        $('#pagination').empty();
        if (pageCount > 1) {
            for (let i = 1; i <= pageCount; i++) {
                $('#pagination').append('<li class="page-item"><a class="page-link" href="#">' + i + '</a></li>');
            }
            $('#pagination li').on('click', function(){
                let pageNumber = parseInt($(this).text());
                fillTable(pageNumber);
                $('#pagination li').removeClass('active');
                $(this).addClass('active');
            });
        }
    }

    function printTable(tableData) {
        console.log(tableData);
        let printableWindow = window.open('', '_blank', 'width=800,height=600');

        let tableContent = "";

        tableData.forEach(row => {
            let formatTime = moment(row.time).format('Do MMMM YYYY, h:mm ');
            tableContent += '<tr>';
            tableContent += `<td>${row.id_call}</td>`;
            tableContent += `<td>${row.user_name}</td>`;
            tableContent += `<td>${row.id_crew ?? "Бригада не вызвана"}</td>`;
            tableContent += `<td>${row.adress}</td>`;
            tableContent += `<td>${row.number}</td>`;
            tableContent += `<td>${row.patient_name ?? "Добавить позже"}</td>`;
            tableContent += `<td>${formatTime}</td>`;
            tableContent += `<td>${row.type}</td>`;
            tableContent += '</tr>';
        });

        let startDateInput = document.getElementById("startDate").value;
        let endDateInput = document.getElementById("endDate").value;

        moment.locale('ru');
        let startDate = moment(startDateInput).format('Do MMMM YYYY, h:mm ');
        let endDate = moment(endDateInput).format('Do MMMM YYYY, h:mm ');

        let searchInput = document.getElementById("searchInput").value;

        let printableContent = `
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Таблица вызовов</title>
    <style>
        body {
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: 1px solid #dddddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            border: 1px solid #dddddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            border-top: 2px solid #dddddd;
            border-bottom: 2px solid #dddddd;
        }

        td {
            border-bottom: 1px solid #dddddd;
        }

        tr:hover {
            background-color: #f2f2f2;
        }

        .table-header {
            background-color: #4CAF50;
            color: #fff;
            font-weight: bold;
            padding: 10px;
            border-radius: 10px 10px 0 0;
        }

        .table-footer {
            background-color: #4CAF50;
            color: #fff;
            font-weight: bold;
            padding: 10px;
            border-radius: 0 0 10px 10px;
        }
    </style>
</head>
<body>
${startDateInput || endDateInput ? `<h2>Записи в период с ${startDate ?? ""} до ${endDate ?? ""}</h2>` : ""}
${searchInput ? `<h3> Поиск по ${searchInput} </h3>` : ""}
<table>
    <thead>
        <tr>
            <th>Номер вызова</th>
            <th>Диспетчер</th>
            <th>Бригада</th>
            <th>Адрес вызова</th>
            <th>Номер вызывавшего</th>
            <th>Пациент</th>
            <th>Время вызова</th>
            <th>Тип помощи</th>
        </tr>
    </thead>
    <tbody>
    ${tableContent}
    </tbody>    
</table>
</body>
</html>
    `;
        printableWindow.document.write(printableContent);
        printableWindow.document.close();
        printableWindow.print();
    }

</script>


