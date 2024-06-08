<?php
include 'sign_In_Controller.php';

function int($bool) {
    return $bool ? 1 : 0;
}

header('Content-Type: application/json');

if (isset($_SESSION['user'])) {
    $DB_HOST = $_ENV["DB_HOST"];
    $DB_NAME = $_ENV["DB_NAME"];
    $DB_USER = $_ENV["DB_USER"];
    $DB_PASSWORD = $_ENV["DB_PASSWORD"];

    $dsn = "mysql:host=$DB_HOST;dbname=$DB_NAME";
    $user = $_SESSION['user'];

    try {
        $conn = new PDO($dsn, $DB_USER, $DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $data = json_decode(file_get_contents('php://input'), true);

        $stmt = $conn->prepare("SELECT id FROM user WHERE user = :user");
        $stmt->execute(['user' => $user]);
        $result = $stmt->fetch();
        $user_id = $result['id'];

        if (isset($data['task'])) {
            $task = $data['task'];
            $isChecked = $data['isChecked'];
            $convert_int = int($isChecked);

            $stmt = $conn->prepare("SELECT task FROM tasks WHERE task = :task");
            $stmt->execute(['task' => $task]);

            if ($stmt->fetch()) {
                echo json_encode(['error' => 'Tarea duplicada']);
            } else {
                $stmt = $conn->prepare("INSERT INTO tasks (task, is_checked, task_created_by) VALUES (:task, :is_checked, :user_id)");
                $stmt->execute([
                    'task' => $task,
                    'is_checked' => $convert_int,
                    'user_id' => $user_id
                ]);

                echo json_encode(['success' => 'Datos insertados correctamente.']);
            }
        } else {
            $stmt = $conn->prepare("SELECT task FROM tasks WHERE task_created_by = :user_id");
            $stmt->execute(['user_id' => $user_id]);

            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($tasks) {
                echo json_encode($tasks);
            } else {
                echo json_encode(['empty' => true]);
            }
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'No has iniciado sesión']);
}
