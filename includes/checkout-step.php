<?php if (isset($_GET['step'])) :

    $userAuthClass = "sm:px-6 py-3 lg:w-1/3 sm:w-auto flex justify-center border-b-2 title-font font-medium items-center leading-none border-gray-200 hover:text-gray-900 tracking-wider";
    $checkoutClass = "sm:px-6 py-3 lg:w-1/3 sm:w-auto flex justify-center border-b-2 title-font font-medium items-center leading-none border-gray-200 hover:text-gray-900 tracking-wider";
    $successClass = "sm:px-6 py-3 lg:w-1/3 sm:w-auto flex justify-center border-b-2 title-font font-medium items-center leading-none border-gray-200 hover:text-gray-900 tracking-wider";

    if ($page === "login.php" || $page === "register.php") {
        $userAuthClass = "sm:px-6 py-3 lg:w-1/3 sm:w-auto flex justify-center border-b-2 title-font font-medium bg-gray-100 items-center leading-none border-primary-500 text-primary-500 tracking-wider rounded-t";
    }
    if ($page === "checkout.php") {
        $checkoutClass = "sm:px-6 py-3 lg:w-1/3 sm:w-auto flex justify-center border-b-2 title-font font-medium bg-gray-100 items-center leading-none border-primary-500 text-primary-500 tracking-wider rounded-t";
        $userAuthClass = "sm:px-6 py-3 lg:w-1/3 sm:w-auto flex justify-center border-b-2 title-font font-medium items-center leading-none bg-green-100 text-green-500 border-b-2 border-green-500 tracking-wider";
    }
    if ($page === "success.php") {
        $successClass = "sm:px-6 py-3 lg:w-1/3 sm:w-auto flex justify-center border-b-2 title-font font-medium bg-gray-100 items-center leading-none border-primary-500 text-primary-500 tracking-wider rounded-t";
        $userAuthClass = "sm:px-6 py-3 lg:w-1/3 sm:w-auto flex justify-center border-b-2 title-font font-medium items-center leading-none bg-green-100 text-green-500 border-b-2 border-green-500 tracking-wider";
        $checkoutClass = "sm:px-6 py-3 lg:w-1/3 sm:w-auto flex justify-center border-b-2 title-font font-medium items-center leading-none bg-green-100 text-green-500 border-b-2 border-green-500 tracking-wider";
    }

?>
    <div class="sm:flex hidden mx-auto flex-wrap <?= $page !== "checkout.php" ? 'mb-12' : '' ?>">
        <a class="<?= $userAuthClass ?>">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" />
            </svg>
            USER AUTH
        </a>
        <a class="<?= $checkoutClass ?>">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
            </svg>
            CHECKOUT
        </a>
        <a class="<?= $successClass ?>">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
            </svg>
            SUCCESS
        </a>
    </div>
<?php endif; ?>