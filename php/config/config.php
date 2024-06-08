<?php
include 'sign_In_Controller.php';

if (isset($_SESSION['user'])) {
    $DB_HOST=$_ENV["DB_HOST"] ?? 'default_host';
    $DB_NAME=$_ENV["DB_NAME"] ?? 'default_db';
    $DB_USER=$_ENV["DB_USER"] ?? 'default_user';
    $DB_PASSWORD=$_ENV["DB_PASSWORD"] ?? 'default_password';

    $dsn = "mysql:host=$DB_HOST;dbname=$DB_NAME";
    $user = $_SESSION['user'];

    try {
        $options = [
            PDO::ATTR_TIMEOUT => 90,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ];

        $conn = new PDO($dsn, $DB_USER, $DB_PASSWORD, $options);

        $data = json_decode(file_get_contents('php://input'), true);

        $stmt = $conn->prepare("SELECT id FROM user WHERE user = :user");
        $stmt->execute(['user' => $user]);
        $result = $stmt->fetch();
        $user_id = $result['id'];

        if (isset($data['task'])) {
            $task = $data['task'];
            $isChecked = $data['isChecked'] ? 1 : 0;

            $stmt = $conn->prepare("SELECT task FROM tasks WHERE task = :task AND task_created_by = :user_id");
            $stmt->execute(['task' => $task, 'user_id' => $user_id]);

            if ($stmt->fetch()) {
                echo json_encode(['message' => 'Tarea duplicada']);
            } else {
                $stmt = $conn->prepare("INSERT INTO tasks (task, is_checked, task_created_by) VALUES (:task, :is_checked, :task_created_by)");
                $stmt->execute([
                    'task' => $task,
                    'is_checked' => $isChecked,
                    'task_created_by' => $user_id
                ]);

                echo json_encode(['message' => 'Datos insertados correctamente.']);
            }
        } else {
            $stmt = $conn->prepare("SELECT task, is_checked FROM tasks WHERE task_created_by = :user_id");
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
?>
