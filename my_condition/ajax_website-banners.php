<? // Advanced Product Categories
$advance_category_main_heading = $_POST['advance_category_main_heading'] ?? getData("advance_category_main_heading", "seller_banners", "seller_id = '$userId'");

for ($i = 1; $i <= 6; $i++) {
    ${"advance_category_name_$i"} = $_POST["advance_category_name_$i"] ?? getData("advance_category_name_$i", "seller_banners", "seller_id = '$userId'");
    ${"advance_category_link_$i"} = $_POST["advance_category_link_$i"] ?? getData("advance_category_link_$i", "seller_banners", "seller_id = '$userId'");

    if (!empty($_FILES["advance_category_image_$i"]["name"])) {
        $ext = pathinfo($_FILES["advance_category_image_$i"]["name"], PATHINFO_EXTENSION);
        $allowed_extensions = ["jpg", "jpeg", "png", "gif", "bmp", "svg", "webp"];

        if (in_array($ext, $allowed_extensions)) {
            ${"advance_category_image_$i"} = upload($_FILES["advance_category_image_$i"]);
        } else {
            echo json_encode(["message" => "$ext - This image extension is not supported.", "success" => false]);
            exit;
        }
    } else {
        ${"advance_category_image_$i"} = getData("advance_category_image_$i", "seller_banners", "seller_id = '$userId'");
    }
}


if (getData("id", "seller_banners", "seller_id = '$userId'")) {
    $sql = "UPDATE seller_banners SET
    homepage_banner = :homepage_banner, homepage_banner_link = :homepage_banner_link,
    homepage_banner_2 = :homepage_banner_2, homepage_banner_link_2 = :homepage_banner_link_2,
    homepage_banner_3 = :homepage_banner_3, homepage_banner_link_3 = :homepage_banner_link_3,
    homepage_banner_4 = :homepage_banner_4, homepage_banner_link_4 = :homepage_banner_link_4,
    homepage_banner_5 = :homepage_banner_5, homepage_banner_link_5 = :homepage_banner_link_5,
    featured_image_1 = :featured_image_1, featured_image_link_1 = :featured_image_link_1,
    featured_image_2 = :featured_image_2, featured_image_link_2 = :featured_image_link_2,
    featured_image_3 = :featured_image_3, featured_image_link_3 = :featured_image_link_3,
    featured_image_4 = :featured_image_4, featured_image_link_4 = :featured_image_link_4,
    mobile_homepage_banner = :mobile_homepage_banner,
    mobile_homepage_banner_2 = :mobile_homepage_banner_2,
    mobile_homepage_banner_3 = :mobile_homepage_banner_3,
    mobile_homepage_banner_4 = :mobile_homepage_banner_4,
    offer_image_1 = :offer_image_1,
    offer_image_2 = :offer_image_2,
    mobile_offer_image_1 = :mobile_offer_image_1,
    mobile_offer_image_2 = :mobile_offer_image_2,
    advance_category_main_heading = :advance_category_main_heading,
    advance_category_name_1 = :advance_category_name_1,
    advance_category_link_1 = :advance_category_link_1,
    advance_category_image_1 = :advance_category_image_1,
    advance_category_name_2 = :advance_category_name_2,
    advance_category_link_2 = :advance_category_link_2,
    advance_category_image_2 = :advance_category_image_2,
    advance_category_name_3 = :advance_category_name_3,
    advance_category_link_3 = :advance_category_link_3,
    advance_category_image_3 = :advance_category_image_3,
    advance_category_name_4 = :advance_category_name_4,
    advance_category_link_4 = :advance_category_link_4,
    advance_category_image_4 = :advance_category_image_4,
    advance_category_name_5 = :advance_category_name_5,
    advance_category_link_5 = :advance_category_link_5,
    advance_category_image_5 = :advance_category_image_5,
    advance_category_name_6 = :advance_category_name_6,
    advance_category_link_6 = :advance_category_link_6,
    advance_category_image_6 = :advance_category_image_6
    WHERE seller_id = :seller_id";
} else {
    $sql = "INSERT INTO seller_banners SET seller_id = :seller_id, homepage_banner = :homepage_banner, homepage_banner_link = :homepage_banner_link,
    homepage_banner_2 = :homepage_banner_2, homepage_banner_link_2 = :homepage_banner_link_2,
    homepage_banner_3 = :homepage_banner_3, homepage_banner_link_3 = :homepage_banner_link_3,
    homepage_banner_4 = :homepage_banner_4, homepage_banner_link_4 = :homepage_banner_link_4,
    homepage_banner_5 = :homepage_banner_5, homepage_banner_link_5 = :homepage_banner_link_5,
    featured_image_1 = :featured_image_1, featured_image_link_1 = :featured_image_link_1,
    featured_image_2 = :featured_image_2, featured_image_link_2 = :featured_image_link_2,
    featured_image_3 = :featured_image_3, featured_image_link_3 = :featured_image_link_3,
    featured_image_4 = :featured_image_4, featured_image_link_4 = :featured_image_link_4,
    mobile_homepage_banner = :mobile_homepage_banner,
    mobile_homepage_banner_2 = :mobile_homepage_banner_2,
    mobile_homepage_banner_3 = :mobile_homepage_banner_3,
    mobile_homepage_banner_4 = :mobile_homepage_banner_4,
    offer_image_1 = :offer_image_1,
    offer_image_2 = :offer_image_2,
    mobile_offer_image_1 = :mobile_offer_image_1,
    mobile_offer_image_2 = :mobile_offer_image_2
    advance_category_main_heading = :advance_category_main_heading,
    advance_category_name_1 = :advance_category_name_1,
    advance_category_link_1 = :advance_category_link_1,
    advance_category_image_1 = :advance_category_image_1,
    advance_category_name_2 = :advance_category_name_2,
    advance_category_link_2 = :advance_category_link_2,
    advance_category_image_2 = :advance_category_image_2,
    advance_category_name_3 = :advance_category_name_3,
    advance_category_link_3 = :advance_category_link_3,
    advance_category_image_3 = :advance_category_image_3,
    advance_category_name_4 = :advance_category_name_4,
    advance_category_link_4 = :advance_category_link_4,
    advance_category_image_4 = :advance_category_image_4,
    advance_category_name_5 = :advance_category_name_5,
    advance_category_link_5 = :advance_category_link_5,
    advance_category_image_5 = :advance_category_image_5,
    advance_category_name_6 = :advance_category_name_6,
    advance_category_link_6 = :advance_category_link_6,
    advance_category_image_6 = :advance_category_image_6";
}






$stmt = $db->prepare($sql);
$stmt = $stmt->execute([
    "seller_id" => $userId,
    "homepage_banner" => $homepage_banner,
    "homepage_banner_link" => $homepage_banner_link,
    "homepage_banner_2" => $homepage_banner_2,
    "homepage_banner_link_2" => $homepage_banner_link_2,
    "homepage_banner_3" => $homepage_banner_3,
    "homepage_banner_link_3" => $homepage_banner_link_3,
    "homepage_banner_4" => $homepage_banner_4,
    "homepage_banner_link_4" => $homepage_banner_link_4,
    "homepage_banner_5" => $homepage_banner_5,
    "homepage_banner_link_5" => $homepage_banner_link_5,
    "featured_image_1" => $featured_image_1,
    "featured_image_link_1" => $featured_image_link_1,
    "featured_image_2" => $featured_image_2,
    "featured_image_link_2" => $featured_image_link_2,
    "featured_image_3" => $featured_image_3,
    "featured_image_link_3" => $featured_image_link_3,
    "featured_image_4" => $featured_image_4,
    "featured_image_link_4" => $featured_image_link_4,
    "mobile_homepage_banner" => $mobile_homepage_banner,
    "mobile_homepage_banner_2" => $mobile_homepage_banner_2,
    "mobile_homepage_banner_3" => $mobile_homepage_banner_3,
    "mobile_homepage_banner_4" => $mobile_homepage_banner_4,
    "offer_image_1" => $offer_image_1,
    "offer_image_2" => $offer_image_2,
    "mobile_offer_image_1" => $mobile_offer_image_1,
    "mobile_offer_image_2" => $mobile_offer_image_2,
    "advance_category_main_heading" => $advance_category_main_heading,
    "advance_category_name_1" => $advance_category_name_1,
    "advance_category_link_1" => $advance_category_link_1,
    "advance_category_image_1" => $advance_category_image_1,
    "advance_category_name_2" => $advance_category_name_2,
    "advance_category_link_2" => $advance_category_link_2,
    "advance_category_image_2" => $advance_category_image_2,
    "advance_category_name_3" => $advance_category_name_3,
    "advance_category_link_3" => $advance_category_link_3,
    "advance_category_image_3" => $advance_category_image_3,
    "advance_category_name_4" => $advance_category_name_4,
    "advance_category_link_4" => $advance_category_link_4,
    "advance_category_image_4" => $advance_category_image_4,
    "advance_category_name_5" => $advance_category_name_5,
    "advance_category_link_5" => $advance_category_link_5,
    "advance_category_image_5" => $advance_category_image_5,
    "advance_category_name_6" => $advance_category_name_6,
    "advance_category_link_6" => $advance_category_link_6,
    "advance_category_image_6" => $advance_category_image_6

]);

    

//     ALTER TABLE `seller_banners`
// ADD COLUMN `advance_category_main_heading` VARCHAR(255) DEFAULT NULL AFTER `mobile_offer_image_2`,
// ADD COLUMN `advance_category_image_1` VARCHAR(255) DEFAULT NULL,
// ADD COLUMN `advance_category_image_2` VARCHAR(255) DEFAULT NULL,
// ADD COLUMN `advance_category_image_3` VARCHAR(255) DEFAULT NULL,
// ADD COLUMN `advance_category_image_4` VARCHAR(255) DEFAULT NULL,
// ADD COLUMN `advance_category_image_5` VARCHAR(255) DEFAULT NULL,
// ADD COLUMN `advance_category_image_6` VARCHAR(255) DEFAULT NULL,
// ADD COLUMN `advance_category_name_1` VARCHAR(255) DEFAULT NULL,
// ADD COLUMN `advance_category_name_2` VARCHAR(255) DEFAULT NULL,
// ADD COLUMN `advance_category_name_3` VARCHAR(255) DEFAULT NULL,
// ADD COLUMN `advance_category_name_4` VARCHAR(255) DEFAULT NULL,
// ADD COLUMN `advance_category_name_5` VARCHAR(255) DEFAULT NULL,
// ADD COLUMN `advance_category_name_6` VARCHAR(255) DEFAULT NULL,
// ADD COLUMN `advance_category_link_1` VARCHAR(255) DEFAULT NULL,
// ADD COLUMN `advance_category_link_2` VARCHAR(255) DEFAULT NULL,
// ADD COLUMN `advance_category_link_3` VARCHAR(255) DEFAULT NULL,
// ADD COLUMN `advance_category_link_4` VARCHAR(255) DEFAULT NULL,
// ADD COLUMN `advance_category_link_5` VARCHAR(255) DEFAULT NULL,
// ADD COLUMN `advance_category_link_6` VARCHAR(255) DEFAULT NULL;
