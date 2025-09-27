    <?php
    // Product Category gird Set & Upload Shwon In first
    $stmt = getCategories(); // pre-built function returning PDOStatement or false

    if ($stmt) {
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC); // fetch as array
        $categories = array_reverse($categories);        // newest first
        $categories = array_slice($categories, 0, 10);   // limit to 10
    } else {
        $categories = [];
    }
    ?>