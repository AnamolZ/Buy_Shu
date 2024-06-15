<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../styles/contact.css">
<link rel="stylesheet" href="../styles/navbar.css">
<script src="../scripts/navbar.js"></script>
<link rel="stylesheet" href="../styles/footer_section.css">


<?php include '../navbar/navbar.php'; ?>

<div class="contact-container"> 
    <div class="contact-form-container">
        <h2>Let's Talk</h2>
        <p>We're here to help and answer any question you might have. We look forward to hearing from you 🙂</p>
        <form method="POST" id="form">
            <input type="hidden" name="access_key" value="b3645078-6320-48b0-ae14-4c630bcfc038">
            <div class="form-field">
                <input type="text" id="full-name" name="name" placeholder="Full Name" required>
            </div>
            <div class="form-field">
                <input type="email" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-field">
                <textarea id="message" name="message" placeholder="Your Message" required></textarea>
            </div>
            <div class="form-field">
                <button type="submit">Send Message</button>
            </div>
        </form>
        <div id="result"></div>
    </div>
    <img src="../images/map.png" ="800" height="600" style="border:0;"></img>
</div>

<?php include '../footer/footer_section.php'; ?>

<script src="../scripts/contact.js"></script>