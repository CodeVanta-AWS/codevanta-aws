<?php
    include './database.php';

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $user_id = $_SESSION['user_id'];

    function log_action($conn, $user_id, $action) {
        if (empty($user_id)) {
            error_log("log_action: User ID is NULL or empty");
            return;
        }
    
        $timestamp = date("Y-m-d H:i:s");
        $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
    
        $os = getOS($user_agent);
        $browser = getBrowser($user_agent);
        $processor_details = getProcessorDetails($user_agent);
        $location = getLocationFromIP($ip_address);
    
        $action = $conn->real_escape_string($action);
        $ip_address = $conn->real_escape_string($ip_address);
        $user_agent = $conn->real_escape_string($user_agent);
        $os = $conn->real_escape_string($os);
        $browser = $conn->real_escape_string($browser);
        $processor_details = $conn->real_escape_string($processor_details);
        $location = $conn->real_escape_string($location);
    
        $sql = "INSERT INTO audit_logs (user_id, action, timestamp, ip_address, user_agent, os, browser, processor_details, location) 
                VALUES ('$user_id', '$action', '$timestamp', '$ip_address', '$user_agent', '$os', '$browser', '$processor_details', '$location')";
    
        if (!$conn->query($sql)) {
            error_log("log_action: Failed to insert log - " . $conn->error);
        }
    }

    function getOS($user_agent) {
        $os_array = [
            '/windows nt 10/i'    => 'Windows 10',
            '/windows nt 6.3/i'   => 'Windows 8.1',
            '/windows nt 6.2/i'   => 'Windows 8',
            '/windows nt 6.1/i'   => 'Windows 7',
            '/macintosh|mac os x/i' => 'Mac OS X',
            '/linux/i'            => 'Linux',
            '/android/i'          => 'Android',
            '/iphone/i'           => 'iPhone',
            '/ipad/i'             => 'iPad',
        ];
        
        foreach ($os_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                return $value;
            }
        }
        return 'Unknown OS';
    }

    function getBrowser($user_agent) {
        $browser_array = [
            '/chrome/i'    => 'Chrome',
            '/firefox/i'   => 'Firefox',
            '/safari/i'    => 'Safari',
            '/edge/i'      => 'Edge',
            '/opera/i'     => 'Opera',
            '/msie/i'      => 'Internet Explorer',
        ];
        
        foreach ($browser_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                return $value;
            }
        }
        return 'Unknown Browser';
    }

    function getProcessorDetails($user_agent) {
        if (strpos($user_agent, 'AMD64') !== false) {
            return 'AMD64';
        } elseif (strpos($user_agent, 'x86_64') !== false || strpos($user_agent, 'Intel') !== false) {
            return 'Intel 64-bit';
        }
        return 'Unknown Processor';
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_career'])) {
        $career_name = $_POST['career_name'];
        $description = $_POST['description'];
        
        $sql = "INSERT INTO careers (career_name, description) VALUES ('$career_name', '$description')";
        if ($conn->query($sql)) {
            log_action($conn, $user_id, "Added a career: $career_name");
        }
    }

    function getLocationFromIP($ip_address) {
        $api_url = "https://ipinfo.io/{$ip_address}/json";
    
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $api_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 5); // Timeout after 5 seconds
    
        $response = curl_exec($curl);
        curl_close($curl);
    
        if ($response) {
            $data = json_decode($response, true);
            if (isset($data['city']) && isset($data['region']) && isset($data['country'])) {
                return $data['city'] . ', ' . $data['region'] . ', ' . $data['country'];
            }
        }
        
        return 'Unknown Location';
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

    $career_page = isset($_GET['career_page']) && is_numeric($_GET['career_page']) && $_GET['career_page'] > 0 ? (int)$_GET['career_page'] : 1;
    $results_per_page = 10;
    $start_from = ($career_page - 1) * $results_per_page;

    $sql = "SELECT * FROM careers LIMIT $start_from, $results_per_page";
    $result = $conn->query($sql);
    if (!$result) {
        die("Main query failed: " . $conn->error);
    }

    $total_query = "SELECT COUNT(*) AS total FROM careers";
    $total_result = $conn->query($total_query);
    $total_row = $total_result->fetch_assoc();
    $total_pages = ceil($total_row["total"] / $results_per_page);


    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Career Info — CodeVanta</title>
    <link rel="stylesheet" href="./src/assets/styles/global.css" />
    <link rel="stylesheet" href="./src/assets/styles/career-info.css" />
    <link rel="stylesheet" href="./src/assets/styles/pagination.css" />
</head>
<body>
    <main>
        <h2>Career Opportunities</h2>
        <button onclick="document.getElementById('addModal').style.display='block'" class="button-admin mm-t">Add Career</button>
            

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
                    echo "<button class='button-admin' onclick=\"openModal('" . $row['id'] . "', '" . $row['career_name'] . "', '" . $row['description'] . "')\">Edit</button>";
                    echo "<button class='button-admin' onclick=\"openDeleteModal('" . $row['id'] . "')\">Delete</button>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No careers found</td></tr>";
            }
            ?>
        </table>

        <?php if ($total_pages > 1): ?>
            <div class="pagination">
                <?php
                    for ($i = 1; $i <= $total_pages; $i++) {
                        $active = $i == $career_page ? "class='active'" : "";
                        echo "<a href='admin_dashboard.php?page=career-info&career_page=$i' $active>$i</a> ";
                    }
                ?>
            </div>
        <?php endif; ?>

    </main>

    <div id="addModal" class="modal">
        <form method="POST">
            <input type="text" name="career_name" placeholder="Career Name" required>
            <textarea name="description" placeholder="Description" required></textarea>
            <button type="submit" name="add_career" class='button-admin'>Add Career</button>
            <button type="button" onclick="document.getElementById('addModal').style.display='none'" class='button-admin'>Close</button>
        </form>
    </div>

    <div id="modal" class="modal">
        <form method="POST">
            <input type="hidden" id="edit_id" name="id">
            <input type="text" id="edit_name" name="career_name" required>
            <textarea id="edit_description" name="description" required></textarea>
            <button type="submit" name="edit_career" class='button-admin'>Save Changes</button>
            <button type="button" onclick="closeModal()" class='button-admin'>Close</button>
        </form>
    </div>

    <div id="deleteModal" class="modal">
        <p class="ms-b">Are you sure you want to delete this career?</p>
        <form id="deleteForm" method="POST">
            <input type="hidden" id="delete_id" name="id">
            <input type="hidden" name="delete_career" value="1">
            <button type="submit" class="button-admin">Yes, Delete</button>
            <button type="button" onclick="closeDeleteModal()" class="button-admin">Cancel</button>
        </form>
    </div>
    <script src="../codevanta-aws/src/assets/scripts/career-info.js"></script>
    
</body>
</html>
