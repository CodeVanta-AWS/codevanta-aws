<?php
    include '../../database.php';

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $user_id = $_SESSION['user_id'];

    function log_action($conn, $user_id, $action) {
        $timestamp = date("Y-m-d H:i:s");
        $action = $conn->real_escape_string($action);
        $sql = "INSERT INTO audit_logs (user_id, action, timestamp) VALUES ('$user_id', '$action', '$timestamp')";
        $conn->query($sql);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_career'])) {
        $career_name = $_POST['career_name'];
        $description = $_POST['description'];
        
        $sql = "INSERT INTO careers (career_name, description) VALUES ('$career_name', '$description')";
        if ($conn->query($sql)) {
            log_action($conn, $user_id, "Added a career: $career_name");
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_career'])) {
        $id = $_POST['id'];
        $career_name = $_POST['career_name'];
        $description = $_POST['description'];
    
        $prev_data = $conn->query("SELECT career_name, description FROM careers WHERE id=$id")->fetch_assoc();
        $prev_name = $prev_data['career_name'] ?? '';
        $prev_description = $prev_data['description'] ?? '';
    
        $updates = [];
    
        if ($career_name !== $prev_name) {
            $updates[] = "career from \"$prev_name\" to \"$career_name\"";
        }
        if ($description !== $prev_description) {
            $updates[] = "description from \"$prev_description\" to \"$description\"";
        }
    
        if (!empty($updates)) {
            $update_query = "UPDATE careers SET career_name='$career_name', description='$description' WHERE id=$id";
            if ($conn->query($update_query)) {
                log_action($conn, $user_id, "Updated " . implode(" and ", $updates));
            }
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_career'])) {
        $id = $_POST['id'];

        $career_query = $conn->query("SELECT career_name FROM careers WHERE id=$id");
        $career = $career_query->fetch_assoc();
        $career_name = $career['career_name'];

        $sql = "DELETE FROM careers WHERE id=$id";
        if ($conn->query($sql)) {
            log_action($conn, $user_id, "Deleted the career: $career_name");
        }
    }

    $sql = "SELECT * FROM careers";
    $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Careers — Code Vanta</title>
    <link rel="stylesheet" href="../assets/styles/career-info.css" />
</head>
<body>
    <main>
        <button onclick="document.getElementById('addModal').style.display='block'">Add Career</button>

        <h2>Career Opportunities</h2>
        <table border="1">  
            <tr>
                <th>ID</th>
                <th>Career Name</th>
                <th>Description</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['career_name'] . "</td>";
                    echo "<td>" . $row['description'] . "</td>";
                    echo "<td>" . $row['created_at'] . "</td>";
                    echo "<td>";
                    echo "<button onclick=\"openModal('" . $row['id'] . "', '" . $row['career_name'] . "', '" . $row['description'] . "')\">Edit</button>";
                    echo "<button onclick=\"openDeleteModal('" . $row['id'] . "')\">Delete</button>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No careers found</td></tr>";
            }
            ?>
        </table>
    </main>

    <!-- Add Career Modal -->
    <div id="addModal" class="modal">
        <form method="POST">
            <input type="text" name="career_name" placeholder="Career Name" required>
            <textarea name="description" placeholder="Description" required></textarea>
            <button type="submit" name="add_career">Add Career</button>
            <button type="button" onclick="document.getElementById('addModal').style.display='none'">Close</button>
        </form>
    </div>

    <!-- Edit Career Modal -->
    <div id="modal" class="modal">
        <form method="POST">
            <input type="hidden" id="edit_id" name="id">
            <input type="text" id="edit_name" name="career_name" required>
            <textarea id="edit_description" name="description" required></textarea>
            <button type="submit" name="edit_career">Save Changes</button>
            <button type="button" onclick="closeModal()">Close</button>
        </form>
    </div>

    <!-- Delete Career Modal -->
    <div id="deleteModal" class="modal">
        <p>Are you sure you want to delete this career?</p>
        <form id="deleteForm" method="POST">
            <input type="hidden" id="delete_id" name="id">
            <input type="hidden" name="delete_career" value="1">
            <button type="submit">Yes, Delete</button>
            <button type="button" onclick="closeDeleteModal()">Cancel</button>
        </form>
    </div>
    <script src="../assets/scripts/career-info.js"></script>
</body>
</html>