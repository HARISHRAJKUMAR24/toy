<?php include_once __DIR__ . "/includes/files_includes.php"; ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!--Php File Include For Head Links & Scripts-->
    <?php include_once __DIR__ . "/includes/head_links.php"; ?>
    <style>
        .content p {
            margin: 1rem 0;
        }

        .content ul,
        .content ol {
            margin: 1rem 0;
            padding-left: 1.5rem;
        }

        .content li {
            margin: 0.5rem 0;
        }
    </style>
</head>

<body class="font-sans bg-gray-50">

    <?php
    include_once __DIR__ . "/includes/header.php";

    if (isset($_GET['slug']) && getData("id", "seller_pages", "slug = '{$_GET['slug']}' AND seller_id = '$sellerId'")) {
        $slug = $_GET['slug'];
        $id = getData("id", "seller_pages", "slug = '{$_GET['slug']}' AND seller_id = '$sellerId'");
        $name = getData("name", "seller_pages", "slug = '{$_GET['slug']}' AND seller_id = '$sellerId'");
        $content = getData("content", "seller_pages", "slug = '{$_GET['slug']}' AND seller_id = '$sellerId'");
    } else {
        redirect($storeUrl);
    }
    ?>

    <!--Php File Include For Nav Bar-->
    <?php include_once __DIR__ . "/includes/navbar.php"; ?>

    <!-- Page Content Section -->
    <section class="min-h-screen py-12 px-4 sm:px-6 lg:px-8 bg-gray-50">
        <div class="max-w-4xl mx-auto">
            <!-- Page Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4"><?= $name ?></h1>
                <div class="w-20 h-1 bg-gradient-to-r from-pink-500 to-purple-600 mx-auto rounded-full"></div>
            </div>

            <!-- Content Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 sm:p-8 lg:p-10">
                    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed content">
                        <?= $content ?>
                    </div>
                </div>
            </div>

            <!-- Back Button -->
            <div class="text-center mt-8">
                <a href="<?= $storeUrl ?>"
                    class="inline-flex items-center px-6 py-3 bg-primary-500 text-white font-semibold rounded-lg hover:bg-hover transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Home
                </a>
            </div>
        </div>
    </section>

    <!--Footer File Includes that file has all JS Files includes links-->
    <?php include_once __DIR__ . "/includes/footer.php"; ?>

</body>

</html>