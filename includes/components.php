<?php



$topBarLinks = array(
    array("label" => "Home", "href" => ""),
    array("label" => "Blog", "href" => "blog"),
    array("label" => "Delivery Areas", "href" => "delivery-areas"),
);

$topBarDetails = array();
if (getSettings("address")) $topBarDetails[] = array("icon" => "mgc_location_line", "text" => getSettings("address"));
if (getSettings("phone")) $topBarDetails[] = array("icon" => "mgc_phone_line", "text" => ltrim(formatPhoneNumber(getSettings("phone")), '0'), "href" => "tel:" . getSettings("phone"));

if (getSettings("whatsapp_number") == getSettings("phone")) {
    if (getSettings("email")) $topBarDetails[] = array("icon" => "mgc_mail_line", "text" => getSettings("email"), "href" => "mailto:" . getSettings("email"));
} else {
    if (getSettings("whatsapp_number")) $topBarDetails[] = array("icon" => "mgc_whatsapp_line", "text" => formatPhoneNumber(getSettings("whatsapp_number")), "href" => "https://wa.me/" . getSettings("whatsapp_number"), "target" => "_blank");
}

$menuLinks = array(
    array("label" => "Home", "href" => ""),
    array("label" => "Order Tracking", "href" => "track-order"),
);


// FUNCTIONS

function addToCartSection($html, $addToCartWrapperExtraClass, $id, $product_id, $cookie_id, $currentQty, $advancedVariant, $totalStocks, $variant_index, $variant){
	// button start
	$htmlContentBtn = '<div class="addToCartWrapper px-1/2' . $addToCartWrapperExtraClass . '" data-id="' . $id . '" id="addCart-'.$product_id.'"   data-variant="'.$variant.'">';

    if (getData("id", "customer_cart", "customer_id = '$cookie_id' AND product_id = '$id' AND other = '$variant'")) {
        $currentQty = getData("quantity", "customer_cart", "customer_id = '$cookie_id' AND product_id = '$id' AND other = ''");

        $htmlContentBtn .= '<div class="qtySwitcher">
        <button class="decreaseQtyBtn" data-id="' . $id . '" data-advancedVariant="' . $advancedVariant . '"><span class="mgc_minimize_line"></span></button>

        <span class="text-base font-medium text-center currentQty">' . $currentQty . '</span>

        <button class="increaseQtyBtn" data-id="' . $id . '" data-advancedVariant="' . $advancedVariant . '"><span class="mgc_add_line"></span></button>
    </div>';
    } else { 
		$totalStocks || !getData("id", "seller_products", "id = '$id' AND unlimited_stock = 0") ? $html .= '<button type="button" class="addToCartBtn theme7-addtocart flex gap-x-2 items-center justify-center w-full mt-1 py-1 bg-secondary text-white rounded hover:bg-primary transition-colors uppercase font-bold text-md" data-id="' . $id . '" data-variant="" data-advancedVariant="' . $advancedVariant . '"><span class="mgc_shopping_bag_3_line"></span> Add to Bag</button>' : $html .= '<button type="button" class="bg-gray-100 text-gray-500 rounded-[10px] h-11 flex items-center justify-center px-3 font-medium w-full transition cursor-not-allowed" disabled>Out of Stock</button>';  
	}		
	$htmlContentBtn .= '</div>';
	// button end;
	return $htmlContentBtn;
}


function getProductHtml($id, $divClass = " w-full max-w-xs bg-white shadow-md rounded-2xl overflow-hidden  m-2 md:m-4 flex flex-col ")
{
	$divClass .= " group ";
    global $storeCurrency;
    global $storeUrl;
    global $customerId;
    global $sellerId;
    global $storeId;
    global $db;
    global $cookie_id;
	

    $product_id = getData("product_id", "seller_products", "id = '$id'");
    $url = $storeUrl . "product/" . getData("slug", "seller_products", "id = '$id'");
    $badge = getData("badge", "seller_products", "id = '$id'");

    $price = getData("price", "seller_products", "id = '$id'");
    $specialPrice = getData("special_price", "seller_products", "id = '$id'");
    $mrp_price = getData("mrp_price", "seller_products", "id = '$id'");
	
	$unit = getData("unit", "seller_products", "id = '$id'");
	$unit_type = getData("unit_type", "seller_products", "id = '$id'");
	$variation = getData("variation", "seller_products", "id = '$id'");
	
	$addCartBtnHtml = '';
	
	
	
	if(empty($variation)){
		$variation = $unit.$unit_type;
	}
	
    // $order_count_result = $db->query("SELECT COUNT(*) as order_count FROM seller_orders WHERE customer_id = '$customerId' AND (seller_id = '$sellerId' AND store_id = '$storeId')");
    // $order_count = $order_count_result->fetch(PDO::FETCH_ASSOC)['order_count'];

    $regular_customer_minimum_orders = getData("regular_customers_orders_count", "limits");
    // $is_regular_customer = ($order_count >= $regular_customer_minimum_orders);
    // $is_regular_customer && $specialPrice ? $price = $specialPrice : '';

    if ($badge == "Save") {
        $badge .= " " . round(number_format((($mrp_price - $price) / $mrp_price) * 100, 1)) . "%";
    }

	
    $badgeDisplay = 'block';
    if (empty($badge)) {
        $badgeDisplay = 'none';
    }

    $stamp = "";
    if ($badge === "Premium Quality" || $badge === "1 Year Warranty" || $badge === "2 Year Warranty" || $badge === "3 Year Warranty") {
        $stamp = "<img src='" . APP_URL . "assets/img/" . str_replace(" ", "-", strtolower($badge)) . ".png' class='absolute lg:w-[80px] w-[60px] h-auto lg:top-0 top-0 lg:-right-0 right-0' />";
        $badgeDisplay = 'none';
    }

    $rating = getData("rating", "product_ratings", "product_id = '$id'");
    $stars = "";
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $rating) {
            $stars .= '<span class="mgc_star_fill before:!text-[#FDCC0D] text-xl sm:text-2xl"></span>'; // Full star
        } elseif ($i - 0.5 == $rating) {
            $stars .= '<span class="mgc_star_half_fill before:!text-[#FDCC0D] text-xl sm:text-2xl"></span>'; // Half star
        } else {
            $stars .= '<span class="mgc_star_line before:!text-[#FDCC0D] text-xl sm:text-2xl"></span>'; // Empty star
        }
    }

    $image = getData("image", "seller_products", "id = '$id'");
    $name = getData("name", "seller_products", "id = '$id'");
    $totalStocks = getData("total_stocks", "seller_products", "id = '$id'");
    $advancedVariant = "";

    if (getData("image", "seller_product_advanced_variants", "product_id = '$product_id'")) {
        $image = getData("image", "seller_product_advanced_variants", "product_id = '$product_id'");
    }

    if (getData("id", "seller_product_advanced_variants", "product_id = '$product_id'")) {
        $advancedVariant = getData("id", "seller_product_advanced_variants", "product_id = '$product_id'");
        $price = getData("price", "seller_product_advanced_variants", "product_id = '$product_id'");
        $mrp_price = getData("mrp_price", "seller_product_advanced_variants", "product_id = '$product_id'");
        $totalStocks = getData("stock", "seller_product_advanced_variants", "product_id = '$product_id'");
    }

    $wishlist = '<button class="sm:w-11 sm:h-11 w-9 h-9 bg-rose-50 sm:text-2xl text-xl rounded-full flex items-center justify-center transition ml-auto sm:static  lg:bottom-0 bottom-0 lg:right-0 right-0 handleWishlist" data-id=""><span class="mgc_heart_fill text-2xl before:!text-rose-500"><i class="fa fa-heart-o" style="font-size:24px"></i></span></button>';
    $wishlistWrapperClass = "";
    $addToCartWrapperExtraClass = "";
    if (isLoggedIn()) {
        //$wishlistWrapperClass = "flex sm:items-center flex-col sm:flex-row sm:gap-4 gap-1";
        $addToCartWrapperExtraClass = "sm:w-[calc(100%_-_60px)]";

        if (getData("id", "customer_wishlists", "customer_id = '$customerId' AND product_id = '$id' AND other = ''")) {
            $wishlist = '<button class="sm:w-11 sm:h-11 w-9 h-9 bg-rose-500 sm:text-2xl text-xl rounded-full flex items-center justify-center transition ml-auto sm:static  lg:bottom-0 bottom-0 lg:right-0 right-0 handleWishlist" data-id="' . $id . '"><span class="mgc_heart_fill text-2xl before:!text-white"><i class="fa fa-heart-o" style="font-size:24px"></i></span></button>';
        } else {
            $wishlist = '<button class="sm:w-11 sm:h-11 w-9 h-9 bg-rose-50 sm:text-2xl text-xl rounded-full flex items-center justify-center transition ml-auto sm:static  lg:bottom-0 bottom-0 lg:right-0 right-0 handleWishlist" data-id="' . $id . '"><span class="mgc_heart_fill text-2xl before:!text-rose-500"><i class="fa fa-heart-o" style="font-size:24px"></i></span></button>';
        }
    }

	//$productDivClass = (empty($productDivClass)) ? '' : $productDivClass; 
    $html = '<div class="'.$divClass.'" data-id="' . $id . '">

	<!--<span style="display: none" class="sm:py-2 sm:px-3 py-1 px-2 text-xs sm:text-base text-primary-500 bg-primary-50 rounded-[10px] absolute left-2 top-2"></span>-->
    <a href="' . $url . '" class="flex flex-col">
	  <div class="relative">
        <img src="' . UPLOADS_URL . $image . '" alt="' . $name . '" class="lg:h-[300px] sm:h-[230px] h-[150px] mx-auto w-full object-cover object-top rounded-2xl">
		<div style="display: ' . $badgeDisplay . '" class="absolute top-2 left-2 px-2 py-1 text-orange-500 border border-orange-500 rounded-sm bg-white text-xs">'.$badge.'</div>
		' . $stamp . '
     
      </div>    
	  <h4 class="mt-1 py-1 text-md text-wrap font-bold text-gray-800 px-2 text-left min-h-[80px]">' . limit_characters($name, 45) . '</h4>
    </a>
	
	<!--<div class="flex items-center mt-1 gap-1 px-1 py-1">
         <span class="text-white rounded-lg text-sm px-3 py-1 bg-green"><ion-icon name="star"></ion-icon> 4.8</span>
      </div>-->
	
	 <div class="flex items-center gap-2 px-2">
              <span class="selected-price-'.$product_id.' text-2xl font-bold text-gray-700" id="selected-price-'.$product_id.'" data-variantId="null">' . currencyToSymbol($storeCurrency) . number_format($price) . '</span>';
		if ($mrp_price) {
              $html .= '<span class="selected-mrp-price-'.$product_id.' text-md font-bold text-gray-500 line-through text-primary" id="selected-mrp-price-'.$product_id.'">' . currencyToSymbol($storeCurrency) . number_format($mrp_price) . '</span>';
		}
              //$html .= '<span class="text-sm text-black text-6xl text-extrabold p-1 ">(Save '.currencyToSymbol($storeCurrency) . (number_format($mrp_price)-number_format($price)).')</span>';
			  $html .= $wishlist;
            $html .= '</div>			
			
			
		<div class="' . $wishlistWrapperClass . ' mt-2 px-1">';
	
	//variant start
	$html .= '<div class="flex mt-1 pb-2 space-x-1 px-1">';
		//default variant
			$html .= '<button class="v_active variant-button variant-button-'.$product_id.' variant-option-button text-sm px-1 py-1 rounded border border-primary bg-white text-black rounded-lg" data-variant-index="0" data-variation="'.$variation.'" data-price="₹'.number_format($price).'" data-mrp="₹'.number_format($mrp_price).'"    data-pid="' . $product_id . '" data-vid="' . $product_id . '">'.$variation.'</button>';
	
		//$defaultVariant_addToCartBtn = addToCartSection($html, $addToCartWrapperExtraClass, $id, $product_id, $cookie_id, $currentQty, $advancedVariant, $totalStocks, 0, "");	
           
        if (getData("id", "seller_product_variants", "product_id = '$product_id' AND (stock > 0 OR unlimited_stock = 1)")) {
            
			$addToCartBtn_variant_arr = [];
			$data = readData("*", "seller_product_variants", "product_id = '$product_id'");
			$variant_index = 1;
			while ($row = $data->fetch()) {
				
				//$addToCartBtn_variant_arr[$variant_index] = addToCartSection($html, $addToCartWrapperExtraClass, $id, $product_id, $cookie_id, $currentQty, $advancedVariant, $totalStocks, $variant_index, $row['variation']);
				
				$html .= '<button class=" variant-button variant-button-'.$product_id.' variant-option-button text-sm px-1 py-1 rounded border border-primary bg-white text-black rounded-lg" data-variant-index="'.$variant_index.'" data-variation="'.$row['variation'].'" data-price="₹'.$row['price'].'" data-mrp="₹'.$row['mrp_price'].'"    data-pid="' . $product_id . '" data-vid="' . $row['id'] . '">'.$row['variation'].'</button>';		
				$variant_index++;
			}
		
			
			
			//$html .= "<select onchange='window.location.href=`" . $storeUrl . "product/" . getData("slug", "seller_products", "id = '$id'") . "/?variation=`+this.value' class='w-full font-medium text-[#290740] h-11 px-3 border border-[#999999] rounded-[10px] custom-select'><option value='' disabled hidden selected>Select</option>";

            //$data = readData("*", "seller_product_variants", "product_id = '$product_id'");
            //while ($row = $data->fetch()) {
            //    $html .= '<option value="' . $row['id'] . '">' . $row['variation'] . '</option>';
            //}

            //$html .= "</select>";
        } else {
            //$totalStocks || !getData("id", "seller_products", "id = '$id' AND unlimited_stock = 0") ? $html .= '<button type="button" class="addToCartBtn flex gap-x-2 items-center justify-center w-full mt-1 py-1 bg-secondary text-white rounded hover:bg-primary transition-colors uppercase font-bold text-md" data-id="' . $id . '" data-advancedVariant="' . $advancedVariant . '"><span class="mgc_shopping_bag_3_line"></span> Add to Bag</button>' : $html .= '<button type="button" class="bg-gray-100 text-gray-500 rounded-[10px] h-11 flex items-center justify-center px-3 font-medium w-full transition cursor-not-allowed" disabled>Out of Stock</button>';
        }
			$html .= "</div>";
	//variant end
	
	
	// button start
	$html .= '<div class="addToCartWrapper px-1/2' . $addToCartWrapperExtraClass . '" data-id="' . $id . '" id="addCart-'.$product_id.'">';

    /*if (getData("id", "customer_cart", "customer_id = '$cookie_id' AND product_id = '$id' AND other = '$variant'")) {
        $currentQty = getData("quantity", "customer_cart", "customer_id = '$cookie_id' AND product_id = '$id' AND other = '$variant'");

        $html .= '<div class="qtySwitcher">
        <button class="decreaseQtyBtn" data-id="' . $id . '" data-advancedVariant="' . $advancedVariant . '"><span class="mgc_minimize_line"></span></button>

        <span class="text-base font-medium text-center currentQty">' . $currentQty . '</span>

        <button class="increaseQtyBtn" data-id="' . $id . '" data-advancedVariant="' . $advancedVariant . '"><span class="mgc_add_line"></span></button>
    </div>';
    } else { */
		$totalStocks || !getData("id", "seller_products", "id = '$id' AND unlimited_stock = 0") ? $html .= '<button id="addToCartBtn-'.$product_id.'" type="button" class="addToCartBtn theme7-addtocart flex gap-x-2 items-center justify-center w-full mt-1 py-1 bg-secondary text-white rounded hover:bg-primary transition-colors uppercase font-bold text-md" data-id="' . $id . '" data-variant="" data-advancedVariant="' . $advancedVariant . '"><span class="mgc_shopping_bag_3_line"></span> Add to Bag</button>' : $html .= '<button type="button" class="bg-gray-100 text-gray-500 rounded-[10px] h-11 flex items-center justify-center px-3 font-medium w-full transition cursor-not-allowed" disabled>Out of Stock</button>';  
	//}		
	$html .= '</div>';
	// button end;
	
    $html .= '
    </div>
    </div>';
			

    /*$html .= '<div class="mt-4 pb-[150px] lg:pb-[140px]">
        
        <div class="mt-[15px] sm:items-center absolute bottom-3">
        <div class="flex sm:items-center justify-between gap-5 flex-col sm:flex-row">
            <div class="text-gray-500">'; */


    //$html .= '</div><div>' . $stars . '</div></div>';

    //$html .= '</div>';

    return $html;
}
