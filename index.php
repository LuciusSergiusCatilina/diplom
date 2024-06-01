<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <!-- Подключение Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mt-5">
                <div class="card-header text-center">
                    <h2>Вход в панель управления</h2>
                </div>
                <div class="card-body">
                    <form id="loginForm">
                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="login">Логин</label>
                            <input type="text" id="login" name="login" class="form-control" required />
                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="password">Пароль</label>
                            <input type="password" id="password" name="password" class="form-control" required />
                        </div>

                        <!-- Submit button -->
                        <input type="button" onclick="Login()" class="btn btn-primary btn-block mb-4" value="Войти" />
                    </form>
                    <div id="error" class="text-danger mt-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Подключение Bootstrap JS и зависимостей -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/additional-methods.min.js"></script>

<script>
    function Login() {
        if ($("#loginForm").valid()) {
            $.ajax({
                type: "POST",
                url: 'api/User/login.php',
                dataType: 'json',
                data: {
                    login: $("#login").val(),
                    password: $("#password").val()
                },
                success: function(response) {
                    if (response.success) {
                        window.location.href = 'dashboard.php';
                    } else {
                        $("#error").text(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    $("#error").text("Произошла ошибка. Пожалуйста, попробуйте еще раз.");
                }
            });
        }
    }
</script>
</body>
</html>
