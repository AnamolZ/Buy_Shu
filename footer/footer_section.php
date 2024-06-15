<link rel="stylesheet" href="./styles/footer_section.css">

<div class="footer-container">
    <div class="footer">
        <div class="care">
            <p>Customer Care</p>
            <ul>
                <li><a href="#">Help Center</a></li>
                <li><a href="#">How to Buy</a></li>
                <li><a href="#">Return & Refunds</a></li>
                <li><a href="weburl:../contact/contact.php">Contact Us</a></li>
            </ul>
        </div>
        <div class="team">
            <p>Team Zero</p>
            <ul>
                <li><a href="weburl:../about/about.php">About Pantry Paradise</a></li>
                <li><a href="#">Careers</a></li>
                <li><a href="#">Blog</a></li>
                <li><a href="#">Terms & Conditions</a></li>
            </ul>
        </div>
        <div class="follow_us">
            <p>Follow Us</p>
            <ul>
                <li><a href="#">Facebook</a></li>
                <li><a href="#">Twitter</a></li>
                <li><a href="#">Instagram</a></li>
                <li><a href="#">YouTube</a></li>
            </ul>
        </div>
        <div class="Rights">
            <ul>
                <li>&copy; 2024 Pantry Paradise Company. All Rights Reserved.</li>
            </ul>
        </div>
    </div>
</div>



<script>
    function handleFooterClick(event) {
        event.preventDefault();

        const href = event.target.getAttribute('href');

        if (href.startsWith('weburl:')) {
            const url = href.replace('weburl:', '');
            window.location.href = url;
        }
    }

    document.querySelector('.footer-container').addEventListener('click', handleFooterClick);
</script>
