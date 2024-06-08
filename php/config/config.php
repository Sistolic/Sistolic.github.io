<?php
   include 'sign_In_Controller.php';

   if (isset($_SESSION['user'])) {
      $DB_HOST=$_ENV["DB_HOST"];
      $DB_NAME=$_ENV["DB_NAME"];

      $dsn = "mysql:host='$DB_HOST';dbname='$DB_NAME'";
      $db_user = $_ENV["DB_USER"];
      $db_password = $_ENV["DB_PASSWORD"];

      $user = $_SESSION['user'];
    
      try {
         $conn = new PDO($dsn, $db_user, $db_password);
         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         
         $data = json_decode(file_get_contents('php://input'), true);

         $sql_id = $conn->query(" SELECT id FROM user WHERE user = '$user' ");
         $result = $sql_id->fetch();
         $user_id = $result['id'];

         if (isset($data['task'])) {
            $task = $data['task'];
       
            $isChecked = $data['isChecked'];
            $convert_int = int($isChecked);

            $check_duplicate = $conn->query(" SELECT task FROM tasks WHERE task = '$task' ");

            if ($datos = $check_duplicate->fetch()) {
               echo 'Tarea duplicada';
            } else {
               $stmt = $conn->query(" INSERT INTO tasks (task, is_checked, task_created_by) VALUES ('$task', '$convert_int', '$user_id') ");

               echo "Datos insertados correctamente.";
            }
         } else {
            $sql_check = $conn->query(" SELECT task, is_checked FROM tasks WHERE task_created_by = '$user_id' ");
            
            if ($tasks = $sql_check->fetchAll(PDO::FETCH_ASSOC)) {
               $sql_delete = $conn->query(" DELETE FROM tasks WHERE task_created_by = '$user_id' ");
               echo json_encode($tasks);
            } else {
               echo json_encode(array("empty" => true));
            }
         }
      } catch(PDOException $e) {
         echo "Error: " . $e->getMessage();
      }
   } else {
      echo 'No has iniciado sesión';
   }

   function int($bool) {
      if ($bool == true) {
         return 1;
      } else if ($bool == false) {
         return 0;
      }
   }