<?php
// ===============================
// THEME9 ADD TO CART (OVERRIDE)
// ===============================

if (isset($_POST['product_id'])) {
    // Load system files
    require_once __DIR__ . '/../../config/autoload.php';

    // -------------------------------
    // 🧩 STEP 1: INPUT VARIABLES
    // -------------------------------
    $product_id = $_POST['product_id'];
    $variant = isset($_POST['variant']) ? $_POST['variant'] : null; // Basic variant
    $advanced_variant = isset($_POST['advanced_variant']) ? $_POST['advanced_variant'] : null;
    $redirectUrl = isset($_POST['redirectUrl']) ? $_POST['redirectUrl'] : null;

    // Make sure cookie_id and sellerId are defined globally
    global $cookie_id, $sellerId, $db;

    // -------------------------------
    // 🧩 STEP 2: BASE PRODUCT PRICES
    // -------------------------------
    $price = getData("price", "seller_products", "id = '$product_id'");
    $mrp_price = getData("mrp_price", "seller_products", "id = '$product_id'");
    $special_price = getData("special_price", "seller_products", "id = '$product_id'");

    // -------------------------------
    // 🧩 STEP 3: ADVANCED VARIANT PRICE
    // -------------------------------
    if (!empty($advanced_variant)) {
        $adv_price = getData("price", "seller_product_advanced_variants", "id = '$advanced_variant'");
        $adv_mrp = getData("mrp_price", "seller_product_advanced_variants", "id = '$advanced_variant'");
        if (!is_null($adv_price)) $price = $adv_price;
        if (!is_null($adv_mrp)) $mrp_price = $adv_mrp;
    }

    // -------------------------------
    // 🧩 STEP 4: BASIC VARIANT PRICE (Skip if 'main')
    // -------------------------------
    if (!empty($variant) && $variant !== 'main') {
        $basic_price = getData("price", "seller_product_variants", "id = '$variant'");
        $basic_mrp = getData("mrp_price", "seller_product_variants", "id = '$variant'");
        if (!is_null($basic_price)) $price = $basic_price;
        if (!is_null($basic_mrp)) $mrp_price = $basic_mrp;
    }

    // -------------------------------
    // 🧩 STEP 5: REGULAR CUSTOMER LOGIC
    // -------------------------------
    $customerId = $cookie_id;
    $order_count_result = $db->query("SELECT COUNT(*) as order_count FROM seller_orders WHERE customer_id = '$customerId' AND seller_id = '$sellerId'");
    $order_count = $order_count_result->fetch(PDO::FETCH_ASSOC)['order_count'] ?? 0;

    $regular_customer_minimum_orders = getData("regular_customers_orders_count", "limits");
    $is_regular_customer = ($order_count >= $regular_customer_minimum_orders);

    // Use special price for regular customers
    if ($is_regular_customer && !empty($special_price)) {
        $price = $special_price;
    }

    // -------------------------------
    // 🧩 STEP 6: ADD OR UPDATE CART
    // -------------------------------
    $existingCart = getData(
        "id",
        "customer_cart",
        "product_id = '$product_id' 
         AND customer_id = '$customerId' 
         AND other = '$variant' 
         AND advanced_variant = '$advanced_variant'"
    );

    if ($existingCart) {
        // Update quantity if already exists
        $sql = "UPDATE customer_cart 
                SET quantity = quantity + 1 
                WHERE product_id = :product_id 
                AND customer_id = :customer_id 
                AND other = :other 
                AND advanced_variant = :advanced_variant";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            "customer_id" => $customerId,
            "product_id" => $product_id,
            "other" => $variant,
            "advanced_variant" => $advanced_variant
        ]);
    } else {
        // Insert new record
        $sql = "INSERT INTO customer_cart 
                SET seller_id = :seller_id,
                    customer_id = :customer_id,
                    product_id = :product_id,
                    price = :price,
                    mrp_price = :mrp_price,
                    quantity = :quantity,
                    other = :other,
                    advanced_variant = :advanced_variant";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            "seller_id" => $sellerId,
            "customer_id" => $customerId,
            "product_id" => $product_id,
            "price" => $price,
            "mrp_price" => $mrp_price,
            "quantity" => 1,
            "other" => $variant,
            "advanced_variant" => $advanced_variant
        ]);
    }

    // -------------------------------
    // 🧩 STEP 7: RESPONSE OUTPUT
    // -------------------------------
    if ($stmt) {
        echo json_encode([
            "message" => "The product has been successfully added to your cart.",
            "success" => true,
            "redirectUrl" => $redirectUrl
        ]);
    } else {
        echo json_encode([
            "message" => "Error adding product to cart.",
            "success" => false
        ]);
    }
}
