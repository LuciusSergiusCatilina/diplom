<?php
session_start();
if (!isset($_SESSION['user_id'])) {
die("Авторизуйтесь!"); //заменить на страницу об авторизации
//или сообщение + таймаут и редирект на авторизацию
}
$HRPermission = ($_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'Начальник отдела кадров');
$CMOPermission = ($_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'Начальник подстанции');
$DispatcherPermission = ($_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'Диспетчер');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Подстанция</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../dist/css/skins/skin-blue.min.css">
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <header class="main-header">
    <a href="/dashboard.php" class="logo">
      <span class="logo-mini"><b>П</b>одстанция</span>
      <span class="logo-lg">Подстанция</span>
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Навигация</span>
      </a>
      <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">


              <!-- User Account Menu -->
              <li class="dropdown user user-menu">
                  <!-- Menu Toggle Button -->
                  <a href="" class="dropdown-toggle" data-toggle="dropdown">
                      <!-- The user image in the navbar-->
                      <img src="../dist/img/avatar5.png" class="user-image" alt="User Image">
                      <!-- hidden-xs hides the username on small devices so only the image appears. -->
                      <span class="hidden-xs"><?= $_SESSION['user_name']; ?></span>
                  </a>
                  <ul class="dropdown-menu">
                      <!-- The user image in the menu -->
                      <li class="user-header">
                          <img src="../dist/img/avatar5.png" class="img-circle" alt="User Image">
                          <p>
                              <?= $_SESSION['user_name']; ?> - <?= $_SESSION['user_role']; ?>
                          </p>
                      </li>

                      <!-- Menu Footer-->
                      <li class="user-footer">
                          <div class="m-a">
                              <a href="api/User/logout.php" class="btn btn-danger btn-flat">Выйти</a>
                          </div>
                      </li>
                  </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="../dist/img/avatar5.png" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?= $_SESSION['user_name']; ?></p>
                <!-- Status -->
                <a href=""></i><?= $_SESSION['user_role']; ?></a>
            </div>
        </div>
      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Меню</li>
        <!-- Optionally, you can add icons to the links -->
        <li class="treeview">
          <a href="#"><i class="fa fa-medkit"></i> <span>Врачи</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
              <?php if ($HRPermission): ?>
                  <li><a href="../Doctor/create.php">Добавить доктора</a></li>
              <?php endif; ?>
            <li><a href="../Doctor">Список докторов</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#"><i class="fa fa-wheelchair-alt"></i> <span>Пациенты</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
              <?php if ($CMOPermission || $DispatcherPermission): ?>
            <li><a href="../Patient/create.php">Добавить пациента</a></li>
              <?php endif; ?>
            <li><a href="../Patient">Список пациентов</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#"><i class="fa fa-ambulance"></i> <span>Водители</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
              <?php if ($HRPermission): ?>
            <li><a href="../Driver/create.php">Добавить водителя</a></li>
              <?php endif; ?>
            <li><a href="../Driver">Список водителей</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#"><i class="fa fa-plus-square"></i> <span>Фельдшеры</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
              <?php if ($HRPermission): ?>
            <li><a href="../Paramedic/create.php">Добавить фельдшера</a></li>
              <?php endif; ?>
            <li><a href="../Paramedic">Список фельдшеров</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#"><i class="fa fa-user-md"></i> <span>Санитары</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
              <?php if ($HRPermission): ?>
            <li><a href="../Orderly/create.php">Добавить санитара</a></li>
              <?php endif; ?>
            <li><a href="../Orderly">Список санитаров</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#"><i class="fa fa-users"></i> <span>Бригады</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
              <?php if ($CMOPermission): ?>
            <li><a href="../Crew/create.php">Добавить бригаду</a></li>
              <?php endif; ?>
            <li><a href="../Crew">Список бригад</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#"><i class="fa fa-folder"></i> <span>Вызовы</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
              <?php if ($CMOPermission || $DispatcherPermission): ?>
            <li><a href="../Call/create.php">Добавить вызов</a></li>
              <?php endif; ?>
            <li><a href="../Call">Список вызовов</a></li>
          </ul>
        </li>
      </ul>
      
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Панель учёта
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Подстанция</a></li>
        <li class="active">Панель учёта</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content container-fluid">
      <?php echo $content; ?>
    </section>
    <!-- /.content -->
  </div>

  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="../bower_components/jquery/dist/jquery.min.js"></script>

<!-- Bootstrap 3.3.7 -->
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- DataTables -->
<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<!-- moment.js -->
<script src="../bower_components/moment/moment.js"></script>
<script src="../bower_components/moment/locale/ru.js"></script>

<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>


<script src="../bower_components/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="../bower_components/jquery-validation/dist/additional-methods.min.js"></script>


</body>
</html>
>