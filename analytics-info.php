<?php
    include './database.php';

    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
    $sort_column = isset($_GET['sort']) ? $_GET['sort'] : 'user_id';
    $sort_order = isset($_GET['order']) ? $_GET['order'] : 'asc';
    
    $allowed_columns = ['user_id', 'ip_address', 'user_agent', 'os', 'browser', 'location', 'processor_details'];
    if (!in_array($sort_column, $allowed_columns)) {
        $sort_column = 'user_id';
    }
    
    if ($sort_order != 'asc' && $sort_order != 'desc') {
        $sort_order = 'asc';
    }
    
    $sql = "SELECT DISTINCT user_id, ip_address, user_agent, os, browser, location, processor_details FROM audit_logs";
    
    if (!empty($search)) {
        if ($filter == 'all') {
            $sql .= " WHERE user_id LIKE '%$search%' 
                    OR ip_address LIKE '%$search%' 
                    OR user_agent LIKE '%$search%' 
                    OR os LIKE '%$search%' 
                    OR browser LIKE '%$search%' 
                    OR location LIKE '%$search%' 
                    OR processor_details LIKE '%$search%'";
        } else {
            $sql .= " WHERE $filter LIKE '%$search%'";
        }
    }
    
    $sql .= " ORDER BY $sort_column $sort_order";
    
    $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics Info — CodeVanta</title>
    <link rel="stylesheet" href="./src/assets/styles/global.css" />
    <link rel="stylesheet" href="./src/assets/styles/analytics-info.css" />
</head>
<body>
    <main class="analytics__container">
        <div class="admin-header">
            <h3 class="white">WELCOME BACK, <span>ADMIN!</span></h3>
                    <a href="logout.php">
                <button class="button button-orange-outline">Logout</button>
            </a>
        </div>
        
        <div class="button-container ml-b">
            <a href="admin_dashboard.php?page=user-info"><button class="button-admin">Users</button></a>
            <a href="admin_dashboard.php?page=career-info"><button class="button-admin">Careers</button></a>
            <a href="admin_dashboard.php?page=audit_log-info"><button class="button-admin">Audit Log</button></a>
            <a href="analytics-info.php"><button class="button-admin">Analytics</button></a>
            <a href="admin_dashboard.php?page=inquiries-info"><button class="button-admin">Inquiries</button></a>
        </div>
        
        <section>
            <h2>Analytics Info</h2>
            
            <div class="search-container">
                <form action="" method="GET" style="display: flex; width: 100%; gap: 10px;">
                    <div>
                        <select name="filter">
                            <option value="all" <?php echo ($filter == 'all') ? 'selected' : ''; ?>>All Fields</option>
                            <option value="user_id" <?php echo ($filter == 'user_id') ? 'selected' : ''; ?>>User ID</option>
                            <option value="ip_address" <?php echo ($filter == 'ip_address') ? 'selected' : ''; ?>>IP Address</option>
                            <option value="user_agent" <?php echo ($filter == 'user_agent') ? 'selected' : ''; ?>>User Agent</option>
                            <option value="os" <?php echo ($filter == 'os') ? 'selected' : ''; ?>>OS</option>
                            <option value="browser" <?php echo ($filter == 'browser') ? 'selected' : ''; ?>>Browser</option>
                            <option value="location" <?php echo ($filter == 'location') ? 'selected' : ''; ?>>Location</option>
                            <option value="processor_details" <?php echo ($filter == 'processor_details') ? 'selected' : ''; ?>>Processor Details</option>
                        </select>
                    </div>
                    <div>
                        <input type="text" name="search" placeholder="Search..." value="<?php echo htmlspecialchars($search); ?>">
                        <button type="submit">Search</button>
                    </div>
                </form>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th><a href="audit_log-info.php?sort=user_id&order=<?php echo ($sort_column == 'user_id' && $sort_order == 'asc') ? 'desc' : 'asc'; ?>&search=<?php echo urlencode($search); ?>&filter=<?php echo $filter; ?>">User ID</a></th>
                        <th><a href="audit_log-info.php?sort=ip_address&order=<?php echo ($sort_column == 'ip_address' && $sort_order == 'asc') ? 'desc' : 'asc'; ?>&search=<?php echo urlencode($search); ?>&filter=<?php echo $filter; ?>">IP Address<?php if($sort_column == 'ip_address'): ?><span class="sort-indicator"><?php echo ($sort_order == 'asc') ? '▲' : '▼'; ?></span><?php endif; ?></a></th>
                        <th><a href="audit_log-info.php?sort=user_agent&order=<?php echo ($sort_column == 'user_agent' && $sort_order == 'asc') ? 'desc' : 'asc'; ?>&search=<?php echo urlencode($search); ?>&filter=<?php echo $filter; ?>">User Agent<?php if($sort_column == 'user_agent'): ?><span class="sort-indicator"><?php echo ($sort_order == 'asc') ? '▲' : '▼'; ?></span><?php endif; ?></a></th>
                        <th><a href="audit_log-info.php?sort=os&order=<?php echo ($sort_column == 'os' && $sort_order == 'asc') ? 'desc' : 'asc'; ?>&search=<?php echo urlencode($search); ?>&filter=<?php echo $filter; ?>">OS<?php if($sort_column == 'os'): ?><span class="sort-indicator"><?php echo ($sort_order == 'asc') ? '▲' : '▼'; ?></span><?php endif; ?></a></th>
                        <th><a href="audit_log-info.php?sort=browser&order=<?php echo ($sort_column == 'browser' && $sort_order == 'asc') ? 'desc' : 'asc'; ?>&search=<?php echo urlencode($search); ?>&filter=<?php echo $filter; ?>">Browser<?php if($sort_column == 'browser'): ?><span class="sort-indicator"><?php echo ($sort_order == 'asc') ? '▲' : '▼'; ?></span><?php endif; ?></a></th>
                        <th><a href="audit_log-info.php?sort=location&order=<?php echo ($sort_column == 'location' && $sort_order == 'asc') ? 'desc' : 'asc'; ?>&search=<?php echo urlencode($search); ?>&filter=<?php echo $filter; ?>">Location<?php if($sort_column == 'location'): ?><span class="sort-indicator"><?php echo ($sort_order == 'asc') ? '▲' : '▼'; ?></span><?php endif; ?></a></th>
                        <th><a href="audit_log-info.php?sort=processor_details&order=<?php echo ($sort_column == 'processor_details' && $sort_order == 'asc') ? 'desc' : 'asc'; ?>&search=<?php echo urlencode($search); ?>&filter=<?php echo $filter; ?>">Processor Details<?php if($sort_column == 'processor_details'): ?><span class="sort-indicator"><?php echo ($sort_order == 'asc') ? '▲' : '▼'; ?></span><?php endif; ?></a></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row["user_id"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["ip_address"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["user_agent"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["os"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["browser"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["location"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["processor_details"]) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No records found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            
            <?php if(!empty($search) || $filter != 'all' || $sort_column != 'user_id' || $sort_order != 'asc'): ?>
                <p style="margin-top: 15px;">
                    <?php if(!empty($search)): ?>
                        Searching for: <strong><?php echo htmlspecialchars($search); ?></strong> 
                        in <?php echo ($filter == 'all') ? 'all fields' : '<strong>' . str_replace('_', ' ', ucfirst($filter)) . '</strong>'; ?>
                        <br>
                    <?php endif; ?>
                    Sorted by: <strong><?php echo str_replace('_', ' ', ucfirst($sort_column)); ?></strong> 
                    (<?php echo ($sort_order == 'asc') ? 'ascending' : 'descending'; ?>)
                </p>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>