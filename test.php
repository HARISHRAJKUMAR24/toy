<?php

include __DIR__ . "/partials/header.php";

// FIXED: Corrected theme condition
if (!in_array($storeTheme, ["theme7", "theme8", "theme9"])) {
    redirect('banners');
}

$homepage_banner = getData("homepage_banner", "seller_banners", "seller_id = '$userId'");
$mobile_homepage_banner = getData("mobile_homepage_banner", "seller_banners", "seller_id = '$userId'");
$homepage_banner_link = getData("homepage_banner_link", "seller_banners", "seller_id = '$userId'");


$homepage_banner_2 = getData("homepage_banner_2", "seller_banners", "seller_id = '$userId'");
$mobile_homepage_banner_2 = getData("mobile_homepage_banner_2", "seller_banners", "seller_id = '$userId'");
$homepage_banner_link_2 = getData("homepage_banner_link_2", "seller_banners", "seller_id = '$userId'");

$homepage_banner_3 = getData("homepage_banner_3", "seller_banners", "seller_id = '$userId'");
$mobile_homepage_banner_3 = getData("mobile_homepage_banner_3", "seller_banners", "seller_id = '$userId'");
$homepage_banner_link_3 = getData("homepage_banner_link_3", "seller_banners", "seller_id = '$userId'");

$homepage_banner_4 = getData("homepage_banner_4", "seller_banners", "seller_id = '$userId'");
$mobile_homepage_banner_4 = getData("mobile_homepage_banner_4", "seller_banners", "seller_id = '$userId'");
$homepage_banner_link_4 = getData("homepage_banner_link_4", "seller_banners", "seller_id = '$userId'");

$homepage_banner_5 = getData("homepage_banner_5", "seller_banners", "seller_id = '$userId'");
$mobile_homepage_banner_5 = getData("mobile_homepage_banner_5", "seller_banners", "seller_id = '$userId'");
$homepage_banner_link_5 = getData("homepage_banner_link_5", "seller_banners", "seller_id = '$userId'");

$featured_image_1 = getData("featured_image_1", "seller_banners", "seller_id = '$userId'");
$featured_image_link_1 = getData("featured_image_link_1", "seller_banners", "seller_id = '$userId'");

$featured_image_2 = getData("featured_image_2", "seller_banners", "seller_id = '$userId'");
$featured_image_link_2 = getData("featured_image_link_2", "seller_banners", "seller_id = '$userId'");

$featured_image_3 = getData("featured_image_3", "seller_banners", "seller_id = '$userId'");
$featured_image_link_3 = getData("featured_image_link_3", "seller_banners", "seller_id = '$userId'");

$featured_image_4 = getData("featured_image_4", "seller_banners", "seller_id = '$userId'");
$featured_image_link_4 = getData("featured_image_link_4", "seller_banners", "seller_id = '$userId'");

$offer_image_1 = getData("offer_image_1", "seller_banners", "seller_id = '$userId'");
$offer_image_2 = getData("offer_image_2", "seller_banners", "seller_id = '$userId'");

$mobile_offer_image_1 = getData("mobile_offer_image_1", "seller_banners", "seller_id = '$userId'");
$mobile_offer_image_2 = getData("mobile_offer_image_2", "seller_banners", "seller_id = '$userId'");

$advance_category_main_heading = getData("advance_category_main_heading", "seller_banners", "seller_id = '$userId'");

for ($i = 1; $i <= 6; $i++) {
    ${"advance_category_image_$i"} = getData("advance_category_image_$i", "seller_banners", "seller_id = '$userId'");
    ${"advance_category_name_$i"} = getData("advance_category_name_$i", "seller_banners", "seller_id = '$userId'");
    ${"advance_category_link_$i"} = getData("advance_category_link_$i", "seller_banners", "seller_id = '$userId'");
}


if (isset($_GET['delete'])) {
    $delete = $_GET['delete'];
    $res = $db->prepare("UPDATE seller_banners SET $delete = ? WHERE seller_id = ?")->execute([NULL, $userId]);
    redirect("website-banners");
}



?>

<!-- select2 css -->
<link href="assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

<!-- toastr -->
<link rel="stylesheet" type="text/css" href="assets/libs/toastr/build/toastr.min.css">

<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Banners</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?= APP_URL ?>">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a></li>
                                <li class="breadcrumb-item"><a href="settings">Settings</a></li>
                                <li class="breadcrumb-item active">Banners</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div id="wrapper">


                <div data-tabname="Desktop" class="bg-primary p-1">
                    <form id="form">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title border-bottom pb-3 mb-3">Website Banners</h4>

                                        <div>
                                            <?php if (in_array($storeTheme, ["grocery", "theme4", "theme6"])) : ?>
                                                <div class="row">
                                                    <div class="mb-3 col-md-2">
                                                        <label class="form-label">Homepage banner & link</label>
                                                        <small>Recommended size <?= ($storeTheme == "theme4" || $storeTheme == "theme6") ? '1213x585' : '1344x330' ?></small>
                                                    </div>

                                                    <div class="mb-3 col-md-5">
                                                        <input class="form-control" type="file" name="homepage_banner" id="homepage_banner">

                                                        <?php if (!empty($homepage_banner)) : ?>
                                                            <div class="position-relative mt-2">
                                                                <a href="banners?delete=homepage_banner" class="btn btn-sm btn-danger" style="position: absolute; top: 0;">
                                                                    <i class="ri-close-line"></i>
                                                                </a>

                                                                <img src="<?= UPLOADS_URL . $homepage_banner ?>" alt="" style="max-width: 100%; max-height: 330px;">
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>

                                                    <div class="mb-3 col-md-5">
                                                        <input class="form-control" type="url" name="homepage_banner_link" id="homepage_banner_link" placeholder="https://example.com/category/fresh-vegetables" value="<?= $homepage_banner_link ?>">
                                                    </div>
                                                </div>
                                            <?php endif ?>

                                            <?php if (in_array($storeTheme, ["theme3", "theme5", "theme7", "theme8", "theme9"])) : ?>
                                                <div class="row">
                                                    <div class="mb-3 col-md-2">
                                                        <label class="form-label">Homepage banner & link</label>
                                                        <small>Recommended size <?= (in_array($storeTheme, ["theme7", "theme8", "theme9"])) ? '1600x500'  : '825x480' ?></small>
                                                    </div>

                                                    <div class="mb-3 col-md-5">
                                                        <input class="form-control" type="file" name="homepage_banner" id="homepage_banner">

                                                        <?php if (!empty($homepage_banner)) : ?>
                                                            <div class="position-relative mt-2">
                                                                <a href="website-banners?delete=homepage_banner" class="btn btn-sm btn-danger" style="position: absolute; top: 0;">
                                                                    <i class="ri-close-line"></i>
                                                                </a>

                                                                <img src="<?= UPLOADS_URL . $homepage_banner ?>" alt="" style="max-width: 100%; max-height: 330px;">
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>

                                                    <div class="mb-3 col-md-5">
                                                        <input class="form-control" type="url" name="homepage_banner_link" id="homepage_banner_link" placeholder="https://example.com/category/fresh-vegetables" value="<?= $homepage_banner_link ?>">
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="mb-3 col-md-2">
                                                        <label class="form-label">Homepage banner & link 2</label>
                                                        <small>Recommended size <?= (in_array($storeTheme, ["theme7", "theme8", "theme9"])) ? '1600x500'  : '390x213' ?></small>
                                                    </div>

                                                    <div class="mb-3 col-md-5">
                                                        <input class="form-control" type="file" name="homepage_banner_2" id="homepage_banner_2">

                                                        <?php if (!empty($homepage_banner_2)) : ?>
                                                            <div class="position-relative mt-2">
                                                                <a href="website-banners?delete=homepage_banner_2" class="btn btn-sm btn-danger" style="position: absolute; top: 0;">
                                                                    <i class="ri-close-line"></i>
                                                                </a>

                                                                <img src="<?= UPLOADS_URL . $homepage_banner_2 ?>" alt="" style="max-width: 100%; max-height: 330px;">
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>

                                                    <div class="mb-3 col-md-5">
                                                        <input class="form-control" type="url" name="homepage_banner_link_2" id="homepage_banner_link_2" placeholder="https://example.com/category/fresh-vegetables" value="<?= $homepage_banner_link_2 ?>">
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="mb-3 col-md-2">
                                                        <label class="form-label">Homepage banner & link 3</label>
                                                        <small>Recommended size <?= (in_array($storeTheme, ["theme7", "theme8", "theme9"])) ? '1600x500'  : '390x213' ?></small>
                                                    </div>

                                                    <div class="mb-3 col-md-5">
                                                        <input class="form-control" type="file" name="homepage_banner_3" id="homepage_banner_3">

                                                        <?php if (!empty($homepage_banner_3)) : ?>
                                                            <div class="position-relative mt-2">
                                                                <a href="website-banners?delete=homepage_banner_3" class="btn btn-sm btn-danger" style="position: absolute; top: 0;">
                                                                    <i class="ri-close-line"></i>
                                                                </a>

                                                                <img src="<?= UPLOADS_URL . $homepage_banner_3 ?>" alt="" style="max-width: 100%; max-height: 330px;">
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>

                                                    <div class="mb-3 col-md-5">
                                                        <input class="form-control" type="url" name="homepage_banner_link_3" id="homepage_banner_link_3" placeholder="https://example.com/category/fresh-vegetables" value="<?= $homepage_banner_link_3 ?>">
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="mb-3 col-md-2">
                                                        <label class="form-label">Homepage banner & link 4</label>
                                                        <small>Recommended size <?= (in_array($storeTheme, ["theme7", "theme8", "theme9"])) ? '1600x500'  : '614x282' ?></small>
                                                    </div>

                                                    <div class="mb-3 col-md-5">
                                                        <input class="form-control" type="file" name="homepage_banner_4" id="homepage_banner_4">

                                                        <?php if (!empty($homepage_banner_4)) : ?>
                                                            <div class="position-relative mt-2">
                                                                <a href="website-banners?delete=homepage_banner_4" class="btn btn-sm btn-danger" style="position: absolute; top: 0;">
                                                                    <i class="ri-close-line"></i>
                                                                </a>

                                                                <img src="<?= UPLOADS_URL . $homepage_banner_4 ?>" alt="" style="max-width: 100%; max-height: 330px;">
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>

                                                    <div class="mb-3 col-md-5">
                                                        <input class="form-control" type="url" name="homepage_banner_link_4" id="homepage_banner_link_4" placeholder="https://example.com/category/fresh-vegetables" value="<?= $homepage_banner_link_4 ?>">
                                                    </div>
                                                </div>

                                                <?php if (!in_array($storeTheme, ["theme7", "theme8", "theme9"])) : ?>
                                                    <div class="row">
                                                        <div class="mb-3 col-md-2">
                                                            <label class="form-label">Homepage banner & link 5</label>
                                                            <small>Recommended size 614x282</small>
                                                        </div>

                                                        <div class="mb-3 col-md-5">
                                                            <input class="form-control" type="file" name="homepage_banner_5" id="homepage_banner_5">

                                                            <?php if (!empty($homepage_banner_5)) : ?>
                                                                <div class="position-relative mt-2">
                                                                    <a href="website-banners?delete=homepage_banner_5" class="btn btn-sm btn-danger" style="position: absolute; top: 0;">
                                                                        <i class="ri-close-line"></i>
                                                                    </a>

                                                                    <img src="<?= UPLOADS_URL . $homepage_banner_5 ?>" alt="" style="max-width: 100%; max-height: 330px;">
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>

                                                        <div class="mb-3 col-md-5">
                                                            <input class="form-control" type="url" name="homepage_banner_link_5" id="homepage_banner_link_5" placeholder="https://example.com/category/fresh-vegetables" value="<?= $homepage_banner_link_4 ?>">
                                                        </div>
                                                    </div>
                                                <?php endif ?>
                                            <?php endif ?>
                                        </div>

                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->




                        <!-- Offer Banners -->
                        <?php if (in_array($storeTheme, ["theme7", "theme8", "theme9"])) : ?>
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title border-bottom pb-3 mb-3">Offer Banners</h4>
                                            <div class="row">
                                                <div class="mb-3 col-md-2">
                                                    <label class="form-label">Offer banner 1</label>
                                                    <small>Recommended size 1600x230</small>
                                                </div>

                                                <div class="mb-3 col-md-5">
                                                    <input class="form-control" type="file" name="offer_image_1" id="offer_image_1">

                                                    <?php if (!empty($offer_image_1)) : ?>
                                                        <div class="position-relative mt-2">
                                                            <a href="website-banners?delete=offer_image_1" class="btn btn-sm btn-danger" style="position: absolute; top: 0;">
                                                                <i class="ri-close-line"></i>
                                                            </a>

                                                            <img src="<?= UPLOADS_URL . $offer_image_1 ?>" alt="" style="max-width: 100%; max-height: 330px;">
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="mb-3 col-md-2">
                                                    <label class="form-label">Offer banner 2</label>
                                                    <small>Recommended size 1600x230</small>
                                                </div>

                                                <div class="mb-3 col-md-5">
                                                    <input class="form-control" type="file" name="offer_image_2" id="offer_image_2">

                                                    <?php if (!empty($offer_image_2)) : ?>
                                                        <div class="position-relative mt-2">
                                                            <a href="website-banners?delete=offer_image_2" class="btn btn-sm btn-danger" style="position: absolute; top: 0;">
                                                                <i class="ri-close-line"></i>
                                                            </a>

                                                            <img src="<?= UPLOADS_URL . $offer_image_2 ?>" alt="" style="max-width: 100%; max-height: 330px;">
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>



                        <div class="main-content footer d-flex justify-content-end align-items-center" style="position: fixed; bottom: 0; left: 0; z-index: 99;">
                            <button type="submit" name="save" class="btn btn-primary waves-effect waves-light">
                                Save
                            </button>
                        </div>
                    </form>
                </div>




                <?php if (in_array($storeTheme, ["theme7", "theme8", "theme9"])) : ?>
                    <div data-tabname="Mobile" class="bg-primary p-1">
                        <form id="mobile">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title border-bottom pb-3 mb-3">Mobile Home Page Banners</h4>

                                            <div class="row">
                                                <div class="mb-3 col-md-2">
                                                    <label class="form-label">Mobile Homepage banner</label>
                                                    <small>Recommended size 500x350</small>
                                                </div>

                                                <div class="mb-3 col-md-5">
                                                    <input class="form-control" type="file" name="mobile_homepage_banner" id="mobile_homepage_banner">

                                                    <?php if (!empty($mobile_homepage_banner)) : ?>
                                                        <div class="position-relative mt-2">
                                                            <a href="website-banners?delete=mobile_homepage_banner" class="btn btn-sm btn-danger" style="position: absolute; top: 0;">
                                                                <i class="ri-close-line"></i>
                                                            </a>

                                                            <img src="<?= UPLOADS_URL . $mobile_homepage_banner ?>" alt="" style="max-width: 100%; max-height: 330px;">
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="mb-3 col-md-2">
                                                    <label class="form-label">Mobile Homepage banner 2</label>
                                                    <small>Recommended size 500x350</small>
                                                </div>

                                                <div class="mb-3 col-md-5">
                                                    <input class="form-control" type="file" name="mobile_homepage_banner_2" id="mobile_homepage_banner_2">

                                                    <?php if (!empty($mobile_homepage_banner_2)) : ?>
                                                        <div class="position-relative mt-2">
                                                            <a href="website-banners?delete=mobile_homepage_banner_2" class="btn btn-sm btn-danger" style="position: absolute; top: 0;">
                                                                <i class="ri-close-line"></i>
                                                            </a>

                                                            <img src="<?= UPLOADS_URL . $mobile_homepage_banner_2 ?>" alt="" style="max-width: 100%; max-height: 330px;">
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="mb-3 col-md-2">
                                                    <label class="form-label">Mobile Homepage banner 3</label>
                                                    <small>Recommended size 500x350</small>
                                                </div>

                                                <div class="mb-3 col-md-5">
                                                    <input class="form-control" type="file" name="mobile_homepage_banner_3" id="mobile_homepage_banner_3">

                                                    <?php if (!empty($mobile_homepage_banner_3)) : ?>
                                                        <div class="position-relative mt-2">
                                                            <a href="website-banners?delete=mobile_homepage_banner_3" class="btn btn-sm btn-danger" style="position: absolute; top: 0;">
                                                                <i class="ri-close-line"></i>
                                                            </a>

                                                            <img src="<?= UPLOADS_URL . $mobile_homepage_banner_3 ?>" alt="" style="max-width: 100%; max-height: 330px;">
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="mb-3 col-md-2">
                                                    <label class="form-label">Mobile Homepage banner 4</label>
                                                    <small>Recommended size 500x350</small>
                                                </div>

                                                <div class="mb-3 col-md-5">
                                                    <input class="form-control" type="file" name="mobile_homepage_banner_4" id="mobile_homepage_banner_4">

                                                    <?php if (!empty($mobile_homepage_banner_4)) : ?>
                                                        <div class="position-relative mt-2">
                                                            <a href="website-banners?delete=mobile_homepage_banner_4" class="btn btn-sm btn-danger" style="position: absolute; top: 0;">
                                                                <i class="ri-close-line"></i>
                                                            </a>

                                                            <img src="<?= UPLOADS_URL . $mobile_homepage_banner_4 ?>" alt="" style="max-width: 100%; max-height: 330px;">
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>





                            <!--Mobile Offer Banners -->

                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title border-bottom pb-3 mb-3">Mobile Offer Banners</h4>
                                            <div class="row">
                                                <div class="mb-3 col-md-2">
                                                    <label class="form-label">Mobile Offer banner 1</label>
                                                    <small>Recommended size 375x145</small>
                                                </div>

                                                <div class="mb-3 col-md-5">
                                                    <input class="form-control" type="file" name="mobile_offer_image_1" id="mobile_offer_image_1">

                                                    <?php if (!empty($mobile_offer_image_1)) : ?>
                                                        <div class="position-relative mt-2">
                                                            <a href="website-banners?delete=mobile_offer_image_1" class="btn btn-sm btn-danger" style="position: absolute; top: 0;">
                                                                <i class="ri-close-line"></i>
                                                            </a>

                                                            <img src="<?= UPLOADS_URL . $mobile_offer_image_1 ?>" alt="" style="max-width: 100%; max-height: 330px;">
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="mb-3 col-md-2">
                                                    <label class="form-label">Mobile Offer banner 2</label>
                                                    <small>Recommended size 375x145</small>
                                                </div>

                                                <div class="mb-3 col-md-5">
                                                    <input class="form-control" type="file" name="mobile_offer_image_2" id="mobile_offer_image_2">

                                                    <?php if (!empty($mobile_offer_image_2)) : ?>
                                                        <div class="position-relative mt-2">
                                                            <a href="website-banners?delete=mobile_offer_image_2" class="btn btn-sm btn-danger" style="position: absolute; top: 0;">
                                                                <i class="ri-close-line"></i>
                                                            </a>

                                                            <img src="<?= UPLOADS_URL . $mobile_offer_image_2 ?>" alt="" style="max-width: 100%; max-height: 330px;">
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="main-content footer d-flex justify-content-end align-items-center" style="position: fixed; bottom: 0; left: 0; z-index: 99;">
                                <button type="submit" name="save" class="btn btn-primary waves-effect waves-light">
                                    Save
                                </button>
                            </div>
                        </form>
                    </div>


                    <!--Featured Images -->
                    <div data-tabname="Featured Images" class="bg-primary p-1">
                        <!-- Featured Images -->
                        <form id="featured">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title border-bottom pb-3 mb-3">Featured Images</h4>
                                            <div>

                                                <div class="row">
                                                    <div class="mb-3 col-md-2">
                                                        <label class="form-label">Featured Image 1</label>
                                                        <small>Recommended size : 250x250</small>
                                                    </div>

                                                    <div class="mb-3 col-md-5">
                                                        <input class="form-control" type="file" name="featured_image_1" id="featured_image_1">

                                                        <?php if (!empty($featured_image_1)) : ?>
                                                            <div class="position-relative mt-2">
                                                                <a href="website-banners?delete=featured_image_1" class="btn btn-sm btn-danger" style="position: absolute; top: 0;">
                                                                    <i class="ri-close-line"></i>
                                                                </a>

                                                                <img src="<?= UPLOADS_URL . $featured_image_1 ?>" alt="" style="max-width: 100%; max-height: 330px;">
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>

                                                    <div class="mb-3 col-md-5">
                                                        <input class="form-control" type="url" name="featured_image_link_1" id="featured_image_link_1" placeholder="https://example.com/category/fresh-vegetables" value="<?= $featured_image_link_1 ?>">
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="mb-3 col-md-2">
                                                        <label class="form-label">Featured Image 2</label>
                                                        <small>Recommended size : 250x250</small>
                                                    </div>

                                                    <div class="mb-3 col-md-5">
                                                        <input class="form-control" type="file" name="featured_image_2" id="featured_image_2">

                                                        <?php if (!empty($featured_image_2)) : ?>
                                                            <div class="position-relative mt-2">
                                                                <a href="website-banners?delete=featured_image_2" class="btn btn-sm btn-danger" style="position: absolute; top: 0;">
                                                                    <i class="ri-close-line"></i>
                                                                </a>

                                                                <img src="<?= UPLOADS_URL . $featured_image_2 ?>" alt="" style="max-width: 100%; max-height: 330px;">
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>

                                                    <div class="mb-3 col-md-5">
                                                        <input class="form-control" type="url" name="featured_image_link_2" id="featured_image_link_2" placeholder="https://example.com/category/fresh-vegetables" value="<?= $featured_image_link_2 ?>">
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="mb-3 col-md-2">
                                                        <label class="form-label">Featured Image 3</label>
                                                        <small>Recommended size : 250x250</small>
                                                    </div>

                                                    <div class="mb-3 col-md-5">
                                                        <input class="form-control" type="file" name="featured_image_3" id="featured_image_1">

                                                        <?php if (!empty($featured_image_3)) : ?>
                                                            <div class="position-relative mt-2">
                                                                <a href="website-banners?delete=featured_image_3" class="btn btn-sm btn-danger" style="position: absolute; top: 0;">
                                                                    <i class="ri-close-line"></i>
                                                                </a>

                                                                <img src="<?= UPLOADS_URL . $featured_image_3 ?>" alt="" style="max-width: 100%; max-height: 330px;">
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>

                                                    <div class="mb-3 col-md-5">
                                                        <input class="form-control" type="url" name="featured_image_link_3" id="featured_image_link_3" placeholder="https://example.com/category/fresh-vegetables" value="<?= $featured_image_link_3 ?>">
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="mb-3 col-md-2">
                                                        <label class="form-label">Featured Image 4</label>
                                                        <small>Recommended size : 250x250</small>
                                                    </div>

                                                    <div class="mb-3 col-md-5">
                                                        <input class="form-control" type="file" name="featured_image_4" id="featured_image_4">

                                                        <?php if (!empty($featured_image_4)) : ?>
                                                            <div class="position-relative mt-2">
                                                                <a href="website-banners?delete=featured_image_4" class="btn btn-sm btn-danger" style="position: absolute; top: 0;">
                                                                    <i class="ri-close-line"></i>
                                                                </a>

                                                                <img src="<?= UPLOADS_URL . $featured_image_4 ?>" alt="" style="max-width: 100%; max-height: 330px;">
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>

                                                    <div class="mb-3 col-md-5">
                                                        <input class="form-control" type="url" name="featured_image_link_4" id="featured_image_link_4" placeholder="https://example.com/category/fresh-vegetables" value="<?= $featured_image_link_4 ?>">
                                                    </div>
                                                </div>


                                            </div>

                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div>
                            <!-- end row -->




                            <div class="main-content footer d-flex justify-content-end align-items-center" style="position: fixed; bottom: 0; left: 0; z-index: 99;">
                                <button type="submit" name="save" class="btn btn-primary waves-effect waves-light">
                                    Save
                                </button>
                            </div>
                        </form>
                    </div>

                <?php endif ?>

                <!-- Advance Product Category Start -->
                <?php if ($storeTheme == "theme9") : ?>
                    <div data-tabname="Advanced Categories" class="bg-primary p-1">
                        <form id="advanceCategories">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title border-bottom pb-3 mb-3">Advanced Product Categories</h4>

                                            <div class="mb-4">
                                                <label class="form-label">Main Heading</label>
                                                <input type="text" class="form-control" name="advance_category_main_heading" id="advance_category_main_heading"
                                                    placeholder="Example: Shop by Category"
                                                    value="<?= $advance_category_main_heading ?>">
                                            </div>

                                            <?php for ($i = 1; $i <= 6; $i++) : ?>
                                                <div class="row mb-4">
                                                    <div class="mb-3 col-md-2">
                                                        <label class="form-label">Category Image <?= $i ?></label>
                                                        <small>Recommended size : 300x300</small>
                                                    </div>

                                                    <div class="mb-3 col-md-4">
                                                        <input class="form-control" type="file" name="advance_category_image_<?= $i ?>" id="advance_category_image_<?= $i ?>">

                                                        <?php if (!empty(${"advance_category_image_$i"})) : ?>
                                                            <div class="position-relative mt-2">
                                                                <a href="website-banners?delete=advance_category_image_<?= $i ?>" class="btn btn-sm btn-danger" style="position: absolute; top: 0;">
                                                                    <i class="ri-close-line"></i>
                                                                </a>
                                                                <img src="<?= UPLOADS_URL . ${"advance_category_image_$i"} ?>" alt="" style="max-width: 100%; max-height: 300px;">
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>

                                                    <div class="mb-3 col-md-3">
                                                        <input class="form-control" type="text" name="advance_category_name_<?= $i ?>" id="advance_category_name_<?= $i ?>"
                                                            placeholder="Category name" value="<?= ${"advance_category_name_$i"} ?>"
                                                            oninvalid="this.setCustomValidity('Please enter category name')"
                                                            oninput="setCustomValidity('')">
                                                    </div>

                                                    <div class="mb-3 col-md-3">
                                                        <input class="form-control" type="url" name="advance_category_link_<?= $i ?>" id="advance_category_link_<?= $i ?>"
                                                            placeholder="https://example.com/category" value="<?= ${"advance_category_link_$i"} ?>"
                                                            oninvalid="this.setCustomValidity('Please enter a valid URL')"
                                                            oninput="setCustomValidity('')">
                                                    </div>
                                                </div>
                                            <?php endfor; ?>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="main-content footer d-flex justify-content-end align-items-center" style="position: fixed; bottom: 0; left: 0; z-index: 99;">
                                <button type="submit" name="save" class="btn btn-primary waves-effect waves-light">Save</button>
                            </div>
                        </form>
                    </div>
                <?php endif ?>

            </div>
            <!-- wrapper end -->

        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    <!-- jQuery -->
    <script src="assets/libs/jquery/jquery.min.js"></script>

    <!-- select 2 plugin -->
    <script src="assets/libs/select2/js/select2.min.js"></script>

    <!-- toastr plugin -->
    <script src="assets/libs/toastr/build/toastr.min.js"></script>

    <!-- Ajax -->
    <script src="javascripts/website-banners.js"></script>

    <?php if (in_array($storeTheme, ["theme7", "theme8", "theme9"])) : ?>
        <script>
            function asTabs(node) {
                var tabs = [];
                for (var i = 0; i < node.childNodes.length; i++) {
                    var child = node.childNodes[i];
                    if (child.nodeType == document.ELEMENT_NODE)
                        tabs.push(child);
                }
                var tabList = document.createElement("div");
                tabs.forEach(function(tab, i) {
                    var button = document.createElement("button");
                    button.textContent = tab.getAttribute("data-tabname");
                    button.addEventListener("click", function() {
                        selectTab(i);
                    });
                    button.classList.add("btn");
                    button.classList.add("btn-primary");
                    button.classList.add("m-2");
                    tabList.appendChild(button);
                });
                node.insertBefore(tabList, node.firstChild);

                function selectTab(n) {
                    tabs.forEach(function(tab, i) {
                        if (i == n)
                            tab.style.display = "block";
                        else
                            tab.style.display = "none";
                    });

                }
                selectTab(0);
            }
            asTabs(document.querySelector("#wrapper"));
            // ===============================
            // Save Advanced Product Categories
            // ===============================
            $('#advanceCategories').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                formData.append('action', 'updateAdvanceCategories');

                $.ajax({
                    url: 'ajax/website-banners.php', // same file used for other forms
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        toastr.success('Advanced categories updated successfully!');
                        console.log(response);
                    },
                    error: function(xhr) {
                        toastr.error('Something went wrong while saving.');
                        console.error(xhr.responseText);
                    }
                });
            });
        </script>
    <?php endif ?>

    <?php include __DIR__ . "/partials/footer.php"; ?>


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
</div>