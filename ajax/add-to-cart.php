<?php

if (isset($_POST['product_id'])) {
    // Including autoload
    require_once __DIR__ . '/../../../config/autoload.php';

    $product_id = $_POST['product_id'];
    $variant = isset($_POST['variant']) ? $_POST['variant'] : '';
    $advanced_variant = isset($_POST['advanced_variant']) ? $_POST['advanced_variant'] : null;
    $redirectUrl = isset($_POST['redirectUrl']) ? $_POST['redirectUrl'] : null;
    $price = getData("price", "seller_products", "id = '$product_id'");
    $special_price = getData("special_price", "seller_products", "id = '$product_id'");
    $mrp_price = getData("mrp_price", "seller_products", "id = '$product_id'");

    if ($advanced_variant) {
        $price = getData("price", "seller_product_advanced_variants", "id = '$advanced_variant'");
        $mrp_price = getData("mrp_price", "seller_product_advanced_variants", "id = '$advanced_variant'");
    }

    if ($variant) {
        $price = getData("price", "seller_product_variants", "id = '$variant'");
        $mrp_price = getData("mrp_price", "seller_product_variants", "id = '$variant'");
    }

    $order_count_result = $db->query("SELECT COUNT(*) as order_count FROM seller_orders WHERE customer_id = '$customerId' AND (seller_id = '$sellerId' AND store_id = '$storeId')");

    $order_count = $order_count_result->fetch(PDO::FETCH_ASSOC)['order_count'];

    $regular_customer_minimum_orders = getData("regular_customers_orders_count", "limits");
    $is_regular_customer = ($order_count >= $regular_customer_minimum_orders);

    $is_regular_customer && $special_price ? $price = $special_price : '';

    $customerId = $cookie_id;

    if (getData("id", "customer_cart", "product_id = '$product_id' AND customer_id = '$customerId' AND other = '$variant' AND advanced_variant = '$advanced_variant'")) {
        $sql = "UPDATE customer_cart SET quantity = quantity+1 WHERE product_id = :product_id AND customer_id = :customer_id AND other = :other AND advanced_variant = :advanced_variant";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            "customer_id" => $customerId,
            "product_id" => $product_id,
            "other" => $variant,
            "advanced_variant" => $advanced_variant
        ]);
    } else {

        $sql = "INSERT INTO customer_cart SET seller_id = :seller_id, store_id = :store_id, customer_id = :customer_id, product_id = :product_id, price = :price, mrp_price = :mrp_price, quantity = :quantity, other = :other, advanced_variant = :advanced_variant";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            "seller_id" => $sellerId,
            "store_id" => $storeId,
            "customer_id" => $customerId,
            "product_id" => $product_id,
            "price" => $price,
            "mrp_price" => $mrp_price,
            "quantity" => 1,
            "other" => $variant,
            "advanced_variant" => $advanced_variant
        ]);

        if ($stmt) {
            echo json_encode(array("message" => "The product has been successfully added to cart.", "success" => true, "redirectUrl" => $redirectUrl));
        } else {
            echo json_encode(array("message" => "Error", "success" => false));
        }
    }
}
