<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form id="myForm">
  <label for="name">Имя:</label>
  <input type="text" id="name" name="name" required>

  <label for="email">Email:</label>
  <input type="email" id="email" name="email" required>

  <label for="password">Пароль:</label>
  <input type="password" id="password" name="password" required>

  <button type="submit">Отправить</button>
</form>

</body>
</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>
  $(document).ready(function() {
    $('#myForm').validate({
      rules: {
        name: {
          required: true,
          minlength: 2 // Минимальная длина имени
        },
        email: {
          required: true,
          email: true // Проверка на корректность email
        },
        password: {
          required: true,
          minlength: 6 // Минимальная длина пароля
        }
      },
      messages: {
        name: {
          required: "Пожалуйста, введите ваше имя",
          minlength: "Имя должно содержать не менее 2 символов"
        },
        email: {
          required: "Пожалуйста, введите ваш email",
          email: "Пожалуйста, введите корректный email"
        },
        password: {
          required: "Пожалуйста, введите ваш пароль",
          minlength: "Пароль должен содержать не менее 6 символов"
        }
      },
      submitHandler: function(form) {
        // Форма прошла валидацию, можно отправлять данные
        form.submit();
      }
    });
  });
</script>
