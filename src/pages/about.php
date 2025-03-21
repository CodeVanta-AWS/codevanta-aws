<?php
    include 'auth_check.php'; // Restricts access if not logged in
?>

<main>
    <?php include("../components/common/header.php"); ?>
    <section>about</section>
    <a href="logout.php">
        <button>Logout</button>
    </a>
    <?php include("../components/common/footer.php"); ?>
</main>