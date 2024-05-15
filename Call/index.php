<?php
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
                         <th>Диспетчер</th>
                         <th>Бригада</th>
                         <th>Адрес вызова</th>
                         <th>Номер вызывавшего</th>
                         <th>Пациент</th>
                         <th>Время вызова</th>
                         <th>Тип помощи</th>
                         <th >Действия <button id="actionPrint" title="Печать таблицы" class="btn btn-flat btn-sm pull-right"><i class="fa fa-file-text-o"></i></button></th>
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

';

include('../master.php');
?>
<script>
    

    let dataTable;

    $(document).ready(function(){

        $.ajax({
            type: "GET",
            url: "../api/call/read.php",
            dataType: 'json',
            success: function(data) {
                dataTable = data;
                fillTable(1);
            }
        });
        // Поиск по имени
        $('#searchInput').on('input', function(){
            fillTable(1);
        });
        $("#actionPrint").on('click', function (){
            var filteredData = filterData();
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
        var result = confirm("Вы уверены что хотите удалить вызов?");
        if (result == true) {
            $.ajax(
                {
                    type: "POST",
                    url: '../api/call/delete.php', // Изменено на URL для удаления экипажа
                    dataType: 'json',
                    data: {
                        id: id
                    },
                    error: function (result) {
                        alert(result.responseText);
                    },
                    success: function (result) {
                        if (result['status'] === true) {
                            alert("Вызов успешно удалён");
                            window.location.href = '../Call'; // Изменено на URL страницы экипажей
                        }
                        else {
                            alert(result['message']);
                        }
                    }
                });
        }
    }

    function clearInput() {
        document.getElementById("startDate").value = '';
        document.getElementById("endDate").value = '';
        fillTable(1);
        createPagination();
    }
    function fillTable(pageNumber) {
        var pageSize = 2; // Количество элементов на странице
        var startIndex = (pageNumber - 1) * pageSize;
        var endIndex = startIndex + pageSize;
        console.log(dataTable);
        var filteredData = filterData();

        // Проверяем количество записей после фильтрации
        if (filteredData.length <= pageSize) {
            $('#pagination').empty(); // Очищаем пагинацию
        }

        var paginatedData = filteredData.slice(startIndex, endIndex);
        renderTable(paginatedData);
    }

    function filterData() {
        var searchInput = $('#searchInput').val().toLowerCase();
        var startDateInput = document.getElementById("startDate").value;
        var endDateInput = document.getElementById("endDate").value;

        var filteredData = dataTable.filter(function(item) {
            for (var key in item) {
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
                var rowDate = new Date(item.time).getTime();
                var startDate = new Date(startDateInput).getTime();
                var endDate = new Date(endDateInput).getTime();
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
                '</td><td>' + item.user_name +
                '</td><td>' + brigade +
                '</td><td>' + item.adress +
                '</td><td>' + item.number +
                '</td><td>' + patient +
                "</td><td data-time = '" + date + "'>" + formatDateTime +
                '</td><td>' + item.type +
                '</td><td id="action"><a href="update.php?id=' + item.id_call + '">Изменить</a> | <a href="#" onClick="Remove(\'' + item.id_call + '\')">Удалить</a></td></tr>'
            );
        });
        createPagination();
    }

    // Функция для создания пагинации
    function createPagination() {
        var pageSize = 2; // Количество элементов на странице
        var pageCount = Math.ceil(filterData().length / pageSize);
        $('#pagination').empty();
        if (pageCount > 1) {
            for (var i = 1; i <= pageCount; i++) {
                $('#pagination').append('<li class="page-item"><a class="page-link" href="#">' + i + '</a></li>');
            }
            $('#pagination li').on('click', function(){
                var pageNumber = parseInt($(this).text());
                fillTable(pageNumber);
                $('#pagination li').removeClass('active');
                $(this).addClass('active');
            });
        }
    }

    function printTable(tableData) {
        console.log(tableData);
        var printableWindow = window.open('', '_blank', 'width=800,height=600');

        var tableContent;

        tableData.forEach(row => {
            tableContent += '<tr>';
            Object.values(row).forEach(value => {
                tableContent += `<td>${value}</td>`;
            });
            tableContent += '</tr>';
        });

        let startDateInput = document.getElementById("startDate").value;
        let endDateInput = document.getElementById("endDate").value;

        moment.locale('ru');
        var startDate = moment(startDateInput).format('Do MMMM YYYY, h:mm ');
        var endDate = moment(endDateInput).format('Do MMMM YYYY, h:mm ');

        var printableContent = `
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
${startDateInput && endDateInput ? `<h2>Записи в период с ${startDate ?? ""} до ${endDate ?? ""}</h2>` : ""}
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


