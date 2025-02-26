<?php require("layouts/headerFrontPage.php"); ?>
<style>
        /* html, body {
            height: 100%;
        }
        body {
            display: flex;
            flex-direction: column;
        }
        main {
            flex: 1;
        } */
        /* Contact Information Section Styles */
        .contact-info h2 {
            margin-top: 50px;
            font-size: 32px;
            color: #333;
            margin-bottom: 20px;
        }

        .contact-info ul {
            padding-left: 0;
        }

        .contact-info ul li {
            list-style-type: none;
            margin-bottom: 10px;
            color: #555;
        }

        .contact-info ul li strong {
            font-weight: 600;
            color: #222;
        }

        /* Message Us Box Styles */
        .message-us h2 {
            font-size: 32px;
            color: #333;
            margin-bottom: 20px;
        }

        .message-us form input[type="text"],
        .message-us form input[type="email"],
        .message-us form textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .message-us form button {
            padding: 10px 20px;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: #fff;
            cursor: pointer;
        }

        .message-us form button:hover {
            background-color: #0056b3;
        }
    </style>


<section id="contact" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6" >
                <div class="contact-info" style="padding-top: 50px;">
                    <h2>Contact Information</h2>
                    <ul class="list-unstyled">
                        <li><strong>Email:</strong> panabocityvet@gmail.com</li>
                        <li><strong>Contact #:</strong> Panabo City Vet, contact number</li>
                        <li><strong>Location:</strong> Purok 1, Brgy. Salvacion (In front of Salvacion Elementary School, Panabo City, Davao del Norte, 8105)</li>
                        <li><strong>Daily Schedule:</strong> 9:00 AM - 5:00 PM</li>
                        <li><strong>Maximum Daily Appointments:</strong> 30</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6" style="padding-top: 100px;">
                <div class="message-us">
                    <h2>Message Us</h2>
                    <form id="contact-form" method="post" action="contact.php" role="form">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Your Name" required>
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Your Email" required>
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" id="message" name="message" rows="5" placeholder="Your Message" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Footer start -->
<footer class="bg-dark text-white py-2 mt-auto">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <p>&copy; 2024 Animal Health Disease Monitoring Online Checkup Services</p>
            </div>
        </div>
    </div>
</footer>
<!-- Footer end -->

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="js/bootstrap.bundle.min.js"></script>

<script>
    // Function to handle form submission
    function submitForm(event) {
        event.preventDefault(); // Prevent the default form submission

        // Get form values
        var name = document.getElementById("name").value;
        var email = document.getElementById("email").value;
        var message = document.getElementById("message").value;

        // Perform basic validation
        if (name.trim() === '' || email.trim() === '' || message.trim() === '') {
            alert("Please fill in all fields.");
            return;
        }
        
        // For demonstration, we'll just log the form data to the console
        console.log("Name: " + name);
        console.log("Email: " + email);
        console.log("Message: " + message);

        // Optionally, you can display a success message to the user
        alert("Your message has been sent successfully!");

        // Reset the form
        document.getElementById("contact-form").reset();
    }

    // Add event listener to the form submit button
    document.getElementById("contact-form").addEventListener("submit", submitForm);
</script>
</body>
</html>
