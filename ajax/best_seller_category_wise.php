<?php

// Including autoload
require_once __DIR__ . '/../../../config/autoload.php';

require_once __DIR__ . "/../includes/components.php";



$category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING) ?: '';
$limit = filter_input(INPUT_POST, 'limit', FILTER_VALIDATE_INT) ?: 1000;
$page = filter_input(INPUT_POST, 'page', FILTER_VALIDATE_INT) ?: 1;
$random = filter_input(INPUT_POST, 'random', FILTER_VALIDATE_BOOLEAN) ?: false;

$offset = ($page - 1) * $limit;
$start = ($page - 1) * $limit;

$min_price = isset($_POST['min_price']) ? $_POST['min_price'] : '';
$max_price = isset($_POST['max_price']) ? $_POST['max_price'] : '';
//$random = isset($_POST['random']) ? $_POST['random'] : true;
$q = isset($_POST['q']) ? $_POST['q'] : NULL;

$html = '';
//if ($category) {


 $products = getProductsByCategory(['limit' => ($limit + 1), 'category' => $category, 'random' => $random]); // Fetch one extra to check if more exists

  $hasMore = count($products) > $limit; // Determine if there are more products
  $products = array_slice($products, 0, $limit); // Limit the products to the requested number

//$products = getProductsByCategory(array("limit" => $limit, "category" => $category));

	$hasMore = count($products) > $limit; // Determine if there are more products
  $products = array_slice($products, 0, $limit); // Limit the products to the requested number

	
if(!empty($products)){
	//$totalPages = ceil($rowCount/$limit);
	foreach ($products as $key => $product) {
		$id = $product['id'];
		$product_id = $product['product_id'];   
		$html .= getProductHtml($id);    
	}
	
	if($hasMore){
		echo '<a href="javascript:void(0)" class=" p-2 text-center bg-primary text-white uppercase font-semibold text-xl block hover:bg-black">View all</a>';
		}
	}else{
		$html .= '<p class="text-bold text-md text-center">No products in this category</p>';
	}



//}else {
//  echo '<p>Invalid category data.</p>';
//}


echo $html;
?>

