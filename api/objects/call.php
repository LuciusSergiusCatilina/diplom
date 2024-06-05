<?php
class Call
{
  // database connection and table name
  private $conn;
  private $table_name = 'calls'; // Изменено на имя таблицы в базе данных

  // object properties
  public $id_call; // Изменено на имя столбца в базе данных
  public $id_user; // Добавлено свойство для драйвера
  public $id_crew; // Добавлено свойство для врача
  public $id_patient; // Добавлено свойство для парамедика
  public $adress; // Добавлено свойство для медсестры
  public $time;
  public $number;
  public $type;

  // constructor with $db as database connection
  public function __construct($db)
  {
    $this->conn = $db;
  }

  function read()
  {
    $query = "SELECT c.id_call, c.id_user, c.id_crew,
    p.id_patient,
    u.name AS user_name, 
    p.name AS patient_name, 
    c.adress, c.time, c.number, 
    c.type FROM calls 
    c LEFT JOIN users 
    u ON c.id_user = u.id_user 
    LEFT JOIN patient p ON c.id_patient = p.id_patient 
    ORDER BY c.time DESC";

    $stmt = $this->conn->prepare($query);

    $stmt->execute();

    return $stmt;
  }

  function read_single($id_call)
  {
    $query = "SELECT c.id_call, c.id_user, c.id_crew, c.id_patient, 
    u.name AS user_name, 
    p.name AS patient_name, 
    c.adress, c.time, c.number, 
    c.type FROM calls 
    c LEFT JOIN users 
    u ON c.id_user = u.id_user 
    LEFT JOIN patient p ON c.id_patient = p.id_patient 
    WHERE c.id_call = ?";

    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(1, $id_call);

    $stmt->execute();

    return $stmt;
  }

  function create()
  {
    try {
      // начинаем транзакцию
      $this->conn->beginTransaction();

      // запрос для вставки записи
      $query = 'INSERT INTO ' . $this->table_name . '(`id_crew`, `id_patient`, `adress`, `number`, `type`) VALUES (?, ?, ?, ?, ?)';

      // подготавливаем запрос
      $stmt = $this->conn->prepare($query);

      // привязываем параметры к значениям объекта
      $stmt->bindParam(1, $this->id_crew);
      $stmt->bindParam(2, $this->id_patient);
      $stmt->bindParam(3, $this->adress);
      $stmt->bindParam(4, $this->number);
      $stmt->bindParam(5, $this->type);

      // выполнение запроса
      if ($stmt->execute()) {
        // обновляем статус бригады
        $update_query = 'UPDATE crews SET is_available = 0 WHERE id_crew = ?';
        $update_stmt = $this->conn->prepare($update_query);
        $update_stmt->bindParam(1, $this->id_crew);
        $update_stmt->execute();

        // фиксируем транзакцию
        $this->conn->commit();
        return true;
      }

      // откатываем транзакцию в случае неудачи
      $this->conn->rollBack();
      return false;
    } catch (Exception $e) {
      // откатываем транзакцию в случае ошибки
      $this->conn->rollBack();
      return false;
    }
  }

  function update()
  {
    try {
      // начинаем транзакцию
      $this->conn->beginTransaction();

      // запрос для обновления записи
      $query = 'UPDATE ' . $this->table_name . ' SET id_crew=?, id_patient=?, adress=?, number=?, type=? WHERE id_call=?';

      // подготавливаем запрос
      $stmt = $this->conn->prepare($query);

      // привязываем параметры к значениям объекта
      $stmt->bindParam(1, $this->id_crew);
      $stmt->bindParam(2, $this->id_patient);
      $stmt->bindParam(3, $this->adress);
      $stmt->bindParam(4, $this->number);
      $stmt->bindParam(5, $this->type);
      $stmt->bindParam(6, $this->id_call);

      // выполнение запроса
      if ($stmt->execute()) {
        // фиксируем транзакцию
        $this->conn->commit();
        return true;
      }

      // откатываем транзакцию в случае неудачи
      $this->conn->rollBack();
      return false;
    } catch (Exception $e) {
      // откатываем транзакцию в случае ошибки
      $this->conn->rollBack();
      echo "Error: " . $e->getMessage();
      return false;
    }
  }

  function delete()
  {
    try {
      // начинаем транзакцию
      $this->conn->beginTransaction();

      // запрос для удаления записи
      $query = 'DELETE FROM ' . $this->table_name . ' WHERE id_call=?';

      // подготавливаем запрос
      $stmt = $this->conn->prepare($query);

      // привязываем параметр к значению объекта
      $stmt->bindParam(1, $this->id_call);

      // выполнение запроса
      if ($stmt->execute()) {
        // фиксируем транзакцию
        $this->conn->commit();
        return true;
      }

      // откатываем транзакцию в случае неудачи
      $this->conn->rollBack();
      return false;
    } catch (Exception $e) {
      // откатываем транзакцию в случае ошибки
      $this->conn->rollBack();
      echo "Error: " . $e->getMessage();
      return false;
    }
  }

  function getUsers()
  {
    $query = "SELECT id_users, name FROM users";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  function getCrews()
  {
    $query = "SELECT id_crew FROM crews WHERE is_available = 1";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  function getPatients()
  {
    $query = "SELECT id_patient, name FROM patient";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  function getCount(){
    $query = "SELECT COUNT(*) FROM calls";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchColumn();         
  }

  function getCountConsultations(){
    $query = "SELECT COUNT(*) FROM calls WHERE type ='Консультация'";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchColumn();         
  }

  function getCountDepartures(){
    $query = "SELECT COUNT(*) FROM calls WHERE type ='Вызов бригады'";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchColumn();         
  }

  function getStats(){
    $countCalls = $this->getCount();
    $countConsultations = $this->getCountConsultations();
    return $countConsultations / $countCalls;
  }

  function getDates(){
    
    $query = "SELECT 
              YEAR(`time`) AS year,
              MONTHNAME(`time`) AS month_name,
              COUNT(*) AS calls_count
          FROM 
              calls
          GROUP BY 
              year, month_name
          ORDER BY 
              year ASC
          LIMIT 0, 50";

    $stmt = $this->conn->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

  }

}
