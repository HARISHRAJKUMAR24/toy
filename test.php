<?php

// Including autoload
require_once __DIR__ . "/../config/autoload.php";

// Read values
$homepage_banner_link = isset($_POST['homepage_banner_link']) ? $_POST['homepage_banner_link'] : getData("homepage_banner_link", "seller_banners", "(seller_id = '$userId' AND store_id = '$storeId')");
if (!empty($_FILES['homepage_banner']['name'])) {
    $ext = pathinfo($_FILES['homepage_banner']['name'], PATHINFO_EXTENSION);

    $allowed_extensions = array("jpg", "jpeg", "png", "gif", "bmp", "svg", "webp");

    if (in_array($ext, $allowed_extensions)) {
        $homepage_banner = upload($_FILES['homepage_banner']);
    } else {
        echo json_encode(array("message" => "$ext - This image extension is not supported.", "success" => false));
        exit;
    }
} else {
    $homepage_banner = getData("homepage_banner", "seller_banners", "(seller_id = '$userId' AND store_id = '$storeId')");
}

$homepage_banner_link_2 = isset($_POST['homepage_banner_link_2']) ? $_POST['homepage_banner_link_2'] : getData("homepage_banner_link_2", "seller_banners", "(seller_id = '$userId' AND store_id = '$storeId')");
if (!empty($_FILES['homepage_banner_2']['name'])) {
    $ext = pathinfo($_FILES['homepage_banner_2']['name'], PATHINFO_EXTENSION);

    $allowed_extensions = array("jpg", "jpeg", "png", "gif", "bmp", "svg", "webp");

    if (in_array($ext, $allowed_extensions)) {
        $homepage_banner_2 = upload($_FILES['homepage_banner_2']);
    } else {
        echo json_encode(array("message" => "$ext - This image extension is not supported.", "success" => false));
        exit;
    }
} else {
    $homepage_banner_2 = getData("homepage_banner_2", "seller_banners", "(seller_id = '$userId' AND store_id = '$storeId')");
}

$homepage_banner_link_3 = isset($_POST['homepage_banner_link_3']) ? $_POST['homepage_banner_link_3'] : getData("homepage_banner_link_3", "seller_banners", "(seller_id = '$userId' AND store_id = '$storeId')");
if (!empty($_FILES['homepage_banner_3']['name'])) {
    $ext = pathinfo($_FILES['homepage_banner_3']['name'], PATHINFO_EXTENSION);

    $allowed_extensions = array("jpg", "jpeg", "png", "gif", "bmp", "svg", "webp");

    if (in_array($ext, $allowed_extensions)) {
        $homepage_banner_3 = upload($_FILES['homepage_banner_3']);
    } else {
        echo json_encode(array("message" => "$ext - This image extension is not supported.", "success" => false));
        exit;
    }
} else {
    $homepage_banner_3 = getData("homepage_banner_3", "seller_banners", "(seller_id = '$userId' AND store_id = '$storeId')");
}

$homepage_banner_link_4 = isset($_POST['homepage_banner_link_4']) ? $_POST['homepage_banner_link_4'] : getData("homepage_banner_link_4", "seller_banners", "(seller_id = '$userId' AND store_id = '$storeId')");
if (!empty($_FILES['homepage_banner_4']['name'])) {
    $ext = pathinfo($_FILES['homepage_banner_4']['name'], PATHINFO_EXTENSION);

    $allowed_extensions = array("jpg", "jpeg", "png", "gif", "bmp", "svg", "webp");

    if (in_array($ext, $allowed_extensions)) {
        $homepage_banner_4 = upload($_FILES['homepage_banner_4']);
    } else {
        echo json_encode(array("message" => "$ext - This image extension is not supported.", "success" => false));
        exit;
    }
} else {
    $homepage_banner_4 = getData("homepage_banner_4", "seller_banners", "(seller_id = '$userId' AND store_id = '$storeId')");
}

$homepage_banner_link_5 = isset($_POST['homepage_banner_link_5']) ? $_POST['homepage_banner_link_5'] : getData("homepage_banner_link_5", "seller_banners", "(seller_id = '$userId' AND store_id = '$storeId')");
if (!empty($_FILES['homepage_banner_5']['name'])) {
    $ext = pathinfo($_FILES['homepage_banner_5']['name'], PATHINFO_EXTENSION);

    $allowed_extensions = array("jpg", "jpeg", "png", "gif", "bmp", "svg", "webp");

    if (in_array($ext, $allowed_extensions)) {
        $homepage_banner_5 = upload($_FILES['homepage_banner_5']);
    } else {
        echo json_encode(array("message" => "$ext - This image extension is not supported.", "success" => false));
        exit;
    }
} else {
    $homepage_banner_5 = getData("homepage_banner_5", "seller_banners", "(seller_id = '$userId' AND store_id = '$storeId')");
}



	$featured_image_link_1 = isset($_POST['featured_image_link_1']) ? $_POST['featured_image_link_1'] : getData("featured_image_link_1", "seller_banners", "(seller_id = '$userId' AND store_id = '$storeId')");
	$featured_image_link_2 = isset($_POST['featured_image_link_2']) ? $_POST['featured_image_link_2'] : getData("featured_image_link_2", "seller_banners", "(seller_id = '$userId' AND store_id = '$storeId')");
	$featured_image_link_3 = isset($_POST['featured_image_link_3']) ? $_POST['featured_image_link_3'] : getData("featured_image_link_3", "seller_banners", "(seller_id = '$userId' AND store_id = '$storeId')");
	$featured_image_link_4 = isset($_POST['featured_image_link_4']) ? $_POST['featured_image_link_4'] : getData("featured_image_link_4", "seller_banners", "(seller_id = '$userId' AND store_id = '$storeId')");


	if (!empty($_FILES['featured_image_1']['name'])) {
		$ext = pathinfo($_FILES['featured_image_1']['name'], PATHINFO_EXTENSION);

		$allowed_extensions = array("jpg", "jpeg", "png", "gif", "bmp", "svg", "webp");

		if (in_array($ext, $allowed_extensions)) {
			$featured_image_1 = upload($_FILES['featured_image_1']);
		} else {
			echo json_encode(array("message" => "$ext - This image extension is not supported.", "success" => false));
			exit;
		}
	}else{
		$featured_image_1 = getData('featured_image_1', "seller_banners", "(seller_id = '$userId' AND store_id = '$storeId')");
	}



	if (!empty($_FILES['featured_image_2']['name'])) {
		$ext = pathinfo($_FILES['featured_image_2']['name'], PATHINFO_EXTENSION);

		$allowed_extensions = array("jpg", "jpeg", "png", "gif", "bmp", "svg", "webp");

		if (in_array($ext, $allowed_extensions)) {
			$featured_image_2 = upload($_FILES['featured_image_2']);
		} else {
			echo json_encode(array("message" => "$ext - This image extension is not supported.", "success" => false));
			exit;
		}
	}else{
		$featured_image_2 = getData('featured_image_2', "seller_banners", "(seller_id = '$userId' AND store_id = '$storeId')");
	}



	if (!empty($_FILES['featured_image_3']['name'])) {
		$ext = pathinfo($_FILES['featured_image_3']['name'], PATHINFO_EXTENSION);

		$allowed_extensions = array("jpg", "jpeg", "png", "gif", "bmp", "svg", "webp");

		if (in_array($ext, $allowed_extensions)) {
			$featured_image_3 = upload($_FILES['featured_image_3']);
		} else {
			echo json_encode(array("message" => "$ext - This image extension is not supported.", "success" => false));
			exit;
		}
	}else{
		$featured_image_3 = getData('featured_image_3', "seller_banners", "(seller_id = '$userId' AND store_id = '$storeId')");
	}



	if (!empty($_FILES['featured_image_4']['name'])) {
		$ext = pathinfo($_FILES['featured_image_4']['name'], PATHINFO_EXTENSION);

		$allowed_extensions = array("jpg", "jpeg", "png", "gif", "bmp", "svg", "webp");

		if (in_array($ext, $allowed_extensions)) {
			$featured_image_4 = upload($_FILES['featured_image_4']);
		} else {
			echo json_encode(array("message" => "$ext - This image extension is not supported.", "success" => false));
			exit;
		}
	}else{
		$featured_image_4 = getData('featured_image_4', "seller_banners", "(seller_id = '$userId' AND store_id = '$storeId')");
	}





	//Mobile banners

	if (!empty($_FILES['mobile_homepage_banner']['name'])) {
		$ext = pathinfo($_FILES['mobile_homepage_banner']['name'], PATHINFO_EXTENSION);

		$allowed_extensions = array("jpg", "jpeg", "png", "gif", "bmp", "svg", "webp");

		if (in_array($ext, $allowed_extensions)) {
			$mobile_homepage_banner = upload($_FILES['mobile_homepage_banner']);
		} else {
			echo json_encode(array("message" => "$ext - This image extension is not supported.", "success" => false));
			exit;
		}
	}else{
		$mobile_homepage_banner = getData('mobile_homepage_banner', "seller_banners", "(seller_id = '$userId' AND store_id = '$storeId')");
	}

	if (!empty($_FILES['mobile_homepage_banner_2']['name'])) {
		$ext = pathinfo($_FILES['mobile_homepage_banner_2']['name'], PATHINFO_EXTENSION);

		$allowed_extensions = array("jpg", "jpeg", "png", "gif", "bmp", "svg", "webp");

		if (in_array($ext, $allowed_extensions)) {
			$mobile_homepage_banner_2 = upload($_FILES['mobile_homepage_banner_2']);
		} else {
			echo json_encode(array("message" => "$ext - This image extension is not supported.", "success" => false));
			exit;
		}
	}else{
		$mobile_homepage_banner_2 = getData('mobile_homepage_banner_2', "seller_banners", "(seller_id = '$userId' AND store_id = '$storeId')");
	}


	if (!empty($_FILES['mobile_homepage_banner_3']['name'])) {
		$ext = pathinfo($_FILES['mobile_homepage_banner_3']['name'], PATHINFO_EXTENSION);

		$allowed_extensions = array("jpg", "jpeg", "png", "gif", "bmp", "svg", "webp");

		if (in_array($ext, $allowed_extensions)) {
			$mobile_homepage_banner_3 = upload($_FILES['mobile_homepage_banner_3']);
		} else {
			echo json_encode(array("message" => "$ext - This image extension is not supported.", "success" => false));
			exit;
		}
	}else{
		$mobile_homepage_banner_3 = getData('mobile_homepage_banner_3', "seller_banners", "(seller_id = '$userId' AND store_id = '$storeId')");
	}


	if (!empty($_FILES['mobile_homepage_banner_4']['name'])) {
		$ext = pathinfo($_FILES['mobile_homepage_banner_4']['name'], PATHINFO_EXTENSION);

		$allowed_extensions = array("jpg", "jpeg", "png", "gif", "bmp", "svg", "webp");

		if (in_array($ext, $allowed_extensions)) {
			$mobile_homepage_banner_4 = upload($_FILES['mobile_homepage_banner_4']);
		} else {
			echo json_encode(array("message" => "$ext - This image extension is not supported.", "success" => false));
			exit;
		}
	}else{
		$mobile_homepage_banner_4 = getData('mobile_homepage_banner_4', "seller_banners", "(seller_id = '$userId' AND store_id = '$storeId')");
	}




	//Offer banners

	if (!empty($_FILES['offer_image_1']['name'])) {
		$ext = pathinfo($_FILES['offer_image_1']['name'], PATHINFO_EXTENSION);

		$allowed_extensions = array("jpg", "jpeg", "png", "gif", "bmp", "svg", "webp");

		if (in_array($ext, $allowed_extensions)) {
			$offer_image_1 = upload($_FILES['offer_image_1']);
		} else {
			echo json_encode(array("message" => "$ext - This image extension is not supported.", "success" => false));
			exit;
		}
	}else{
		$offer_image_1 = getData('offer_image_1', "seller_banners", "(seller_id = '$userId' AND store_id = '$storeId')");
	}

	if (!empty($_FILES['offer_image_2']['name'])) {
		$ext = pathinfo($_FILES['offer_image_2']['name'], PATHINFO_EXTENSION);

		$allowed_extensions = array("jpg", "jpeg", "png", "gif", "bmp", "svg", "webp");

		if (in_array($ext, $allowed_extensions)) {
			$offer_image_2 = upload($_FILES['offer_image_2']);
		} else {
			echo json_encode(array("message" => "$ext - This image extension is not supported.", "success" => false));
			exit;
		}
	}else{
		$offer_image_2 = getData('offer_image_2', "seller_banners", "(seller_id = '$userId' AND store_id = '$storeId')");
	}



	//Mobile Offer banners

	if (!empty($_FILES['mobile_offer_image_1']['name'])) {
		$ext = pathinfo($_FILES['mobile_offer_image_1']['name'], PATHINFO_EXTENSION);

		$allowed_extensions = array("jpg", "jpeg", "png", "gif", "bmp", "svg", "webp");

		if (in_array($ext, $allowed_extensions)) {
			$mobile_offer_image_1 = upload($_FILES['mobile_offer_image_1']);
		} else {
			echo json_encode(array("message" => "$ext - This image extension is not supported.", "success" => false));
			exit;
		}
	}else{
		$mobile_offer_image_1 = getData('mobile_offer_image_1', "seller_banners", "(seller_id = '$userId' AND store_id = '$storeId')");
	}

	if (!empty($_FILES['mobile_offer_image_2']['name'])) {
		$ext = pathinfo($_FILES['mobile_offer_image_2']['name'], PATHINFO_EXTENSION);

		$allowed_extensions = array("jpg", "jpeg", "png", "gif", "bmp", "svg", "webp");

		if (in_array($ext, $allowed_extensions)) {
			$mobile_offer_image_2 = upload($_FILES['mobile_offer_image_2']);
		} else {
			echo json_encode(array("message" => "$ext - This image extension is not supported.", "success" => false));
			exit;
		}
	}else{
		$mobile_offer_image_2 = getData('mobile_offer_image_2', "seller_banners", "(seller_id = '$userId' AND store_id = '$storeId')");
	}
	




if (getData("id", "seller_banners", "(seller_id = '$userId' AND store_id = '$storeId')")) {
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
	mobile_offer_image_2 = :mobile_offer_image_2
    WHERE seller_id = :seller_id AND store_id = :store_id";
} else {
    $sql = "INSERT INTO seller_banners SET seller_id = :seller_id, store_id = :store_id, homepage_banner = :homepage_banner, homepage_banner_link = :homepage_banner_link,
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
	mobile_offer_image_2 = :mobile_offer_image_2";
}






$stmt = $db->prepare($sql);
$stmt = $stmt->execute(["seller_id" => $userId, "store_id" => $storeId,
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
	"mobile_offer_image_2" => $mobile_offer_image_2
		]);

if ($stmt) {
    echo json_encode(array("message" => "Your banners has been successfully updated.", "success" => true));
} else {
    echo json_encode(array("message" => "Something went wrong. Please try again later.", "success" => false));
}