<?php include '../user/functions.php' ?>
<?php include 'navbar2.php' ?>
<link rel="stylesheet" href="contact.css">
<div class="container">
    <div class="contact-parent">
        <div class="contact-child child1">
            <p>
                <i class="fas fa-map-marker-alt"></i> Address <br />
                <span> Gairigaun Tinkune 10
                    <br />
                    Kathmandu , Nepal
                </span>
            </p>
            <p>
                <i class="fas fa-phone-alt"></i> Let's Talk <br />
                <span> 01-4782208</span>
            </p>
            <p>
                <i class=" far fa-envelope"></i> Support <br />
                <span>contact@funolympics.com</span>
            </p>
        </div>
        <div class="contact-child child2">
            <div class="inside-contact">
                <h2>Contact Us</h2>
                <h3>
                    <span id="confirm">
                </h3>
                <p>Name *</p>
                <input id="txt_name" type="text" Required="required">
                <p>Email *</p>
                <input id="txt_email" type="text" Required="required">
                <p>Phone *</p>
                <input id="txt_phone" type="text" Required="required">
                <p>Subject *</p>
                <input id="txt_subject" type="text" Required="required">
                <p>Message *</p>
                <textarea id="txt_message" rows="4" cols="20" Required="required"></textarea>
                <input type="submit" id="btn_send" value="SEND">
            </div>
        </div>
    </div>
</div>