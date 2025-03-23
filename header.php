<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header — CodeVanta</title>
    <link rel="stylesheet" href="src/assets/styles/global.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>

    <header>
        <nav class="nav1">
            <ul>
                <li><a href="#">HOME</a></li>
                <li><a href="about.php">ABOUT</a></li>
                <li><a href="careers.php">CAREERS</a></li>
                <li><a href="contact.php">CONTACT</a></li>
            </ul>
        </nav>
        <nav class="nav2">
            <div class="menu">
                <i class="fa-solid fa-bars"></i>
                <p>MENU</p>
            </div>

        </nav>    
    
    </header>
    <div class="side-menu" id="sideMenu">
        <div class="close-btn" id="closeMenu">&times;</div>
            <ul>
                <li><a href="#">HOME</a></li>
                <li><a href="about.php">ABOUT</a></li>
                <li><a href="careers.php">CAREERS</a></li>
                <li><a href="contact.php">CONTACT</a></li>
                <li><a href="logout.php">LOGOUT</a></li>
            </ul>
    </div>

    <script>
        const menuBtn = document.querySelector('.menu');
        const sideMenu = document.getElementById('sideMenu');
        const closeMenu = document.getElementById('closeMenu');

        menuBtn.addEventListener('click', () => {
            sideMenu.classList.add('active');
        });

        closeMenu.addEventListener('click', () => {
            sideMenu.classList.remove('active');
        });
    </script>
    
</body>
</html>


