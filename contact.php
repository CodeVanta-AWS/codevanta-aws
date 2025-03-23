<?php
    include 'auth_check.php'; 

    include './database.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $stmt = $conn->prepare("INSERT INTO inquiries (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $_POST['name'], $_POST['email'], $_POST['message']);
        echo $stmt->execute() ? "<p>Inquiry submitted!</p>" : "<p>Error: " . $stmt->error . "</p>";
        $stmt->close();
    }
?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="src/assets/styles/global.css">
    <link rel="stylesheet" href="src/assets/styles/contact.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
    <?php include("./header.php"); ?> 
    <main>
        <section class="hero hero-contact">
            <div>
                <h1 class="ms-b lg-80">Let’s Talk Tech, Ideas, and Possibilities</h1>
                <hr class="w-50">
                <p class="ms-t md-50">Have a project in mind or a question to ask? Whether it’s about collaboration, careers, or custom solutions — we’re here to listen and help. Reach out to CodeVanta and let’s start building something impactful together.</p>
            </div>
        </section>


        <div class="contact-bg">
            <div class="container">
                <section class="contact-about">
                    <h2><span class="small-header">(CONTACT)</span>We believe the best tech starts with a conversation.<span> Let’s talk about how CodeVanta can help bring your vision to life.</h2>
                </section>

                <section class="contact-container">
                    <div class="md-50">
                        <p class="lg-80">Whether you're a business looking for custom solutions, a developer interested in joining our team, or simply curious about what we do — we’d love to hear from you. <span>Our team is always open to new ideas, partnerships, and opportunities. Let’s build the future, one message at a time.</span></p>
                        <p class="mxl-t mxl-b lg-80">
                            We value meaningful connections — every message matters to us. Whether you're ready to collaborate or just exploring, we’re here to support, inspire, and respond. From quick inquiries to big ideas, the door is always open. Let’s turn your next move into something extraordinary, together.
                        </p>
                    </div>
                    <div class="md-50">
                        <form action="" method="POST">
                            <input type="text" name="name" required placeholder="NAME">
                            <input type="email" name="email" required placeholder="EMAIL">
                            <textarea name="message" required placeholder="MESSAGE" class=""></textarea>
                            <button type="submit" class="button-orange-outline ms-t lg-80">Submit</button>
                        </form>
                    </div>
                </section>

                <a href="logout.php">
                    <button>Logout</button>
                </a>
            </div>
            
        </div>
        
    </main>

    <?php include("./footer.php"); ?>
</body>
</html>