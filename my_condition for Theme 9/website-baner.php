<!--This Code Paste in SellerPanel/websitebanner.php-->
<!--Theme-9 Condtion for Hide Mobile button and In Feature Shoe 3 Upload Image only -->
<?php if ($storeTheme == "theme9") : ?>
    <style>
        /* Hide the entire Mobile section */
        [data-tabname="Mobile"] {
            display: none !important;
        }

        /* Show only the first 3 featured images rows */
        [data-tabname="Featured Images"] .row:nth-child(n+4) {
            display: none !important;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Hide the Mobile tab button at the top
            const tabButtons = document.querySelectorAll('#wrapper > div:first-child button');
            tabButtons.forEach(button => {
                if (button.textContent.trim() === "Mobile") {
                    button.style.display = "none";
                }
            });
        });
    </script>
<?php endif; ?>