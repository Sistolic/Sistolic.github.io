<?php
    include 'sign_In_Controller.php'

    $DB_HOST=$_ENV["DB_HOST"];
    $DB_NAME=$_ENV["DB_NAME"];
    $DB_USER=$_ENV["DB_USER"];
    $DB_PASSWORD=$_ENV["DB_PASSWORD"];

    $dsn = "mysql:host=$DB_HOST;dbname=$DB_NAME";
    
    $user = $_SESSION['user'];

    try {
        $conn = new PDO($dsn, $DB_USER, $DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT task FROM tasks WHERE task_created_by = :user_id");
        $stmt->execute(['user_id' => $user_id]);

        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($tasks) {
            echo json_encode($tasks);
        } else {
            echo json_encode(['empty' => true]);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }