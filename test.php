<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Таблица с пагинацией и поиском</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
    .pagination {
        justify-content: center;
    }
</style>
</head>
<body>

<div class="container mt-5">
    <h2>Таблица с пагинацией и поиском</h2>
    <input type="text" id="searchInput" class="form-control mb-3" placeholder="Поиск по имени">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Имя</th>
                <th>Фамилия</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            <!-- Здесь будут данные -->
        </tbody>
    </table>
    <ul class="pagination" id="pagination"></ul>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function(){
        // Больше данных
        var data = [
            { id: 1, firstName: "Иван", lastName: "Иванов" },
            { id: 2, firstName: "Петр", lastName: "Петров" },
            { id: 3, firstName: "Сидор", lastName: "Сидоров" },
            { id: 4, firstName: "Александр", lastName: "Александров" },
            { id: 5, firstName: "Дмитрий", lastName: "Дмитриев" },
            { id: 6, firstName: "Евгений", lastName: "Евгеньев" },
            { id: 7, firstName: "Николай", lastName: "Николаев" },
            { id: 8, firstName: "Андрей", lastName: "Андреев" },
            { id: 9, firstName: "Михаил", lastName: "Михайлов" },
            { id: 10, firstName: "Юрий", lastName: "Юрьев" },
            // Добавьте еще данных здесь
        ];

        // Функция для заполнения таблицы данными
        function fillTable(pageNumber) {
            var pageSize = 5; // Количество элементов на странице
            var startIndex = (pageNumber - 1) * pageSize;
            var endIndex = startIndex + pageSize;
            var filteredData = data.filter(function(item) {
                return item.firstName.toLowerCase().includes($('#searchInput').val().toLowerCase());
            });
            var paginatedData = filteredData.slice(startIndex, endIndex);
            $('#tableBody').empty();
            $.each(paginatedData, function(index, item){
                $('#tableBody').append('<tr><td>' + item.id + '</td><td>' + item.firstName + '</td><td>' + item.lastName + '</td></tr>');
            });
        }

        // Функция для создания пагинации
        function createPagination() {
            var pageSize = 5; // Количество элементов на странице
            var pageCount = Math.ceil(data.length / pageSize);
            $('#pagination').empty();
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

        // Поиск по имени
        $('#searchInput').on('input', function(){
            fillTable(1);
            createPagination();
        });

        // Инициализация
        fillTable(1);
        createPagination();
    });
</script>

</body>
</html>
