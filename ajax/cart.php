<div class="lg:w-[75%]">
    <div class="space-y-4">
        <?php
        foreach ($data as $key => $cart) :

            $variation = $cart['other'] ? getData("variation", "seller_product_variants", "id = '{$cart['other']}'") : getData("variation", "seller_products", "id = '{$cart['product_id']}'");

            $size = getData("size", "seller_product_advanced_variants", "id = '{$cart['advanced_variant']}'");
            $color = getData("color", "seller_product_advanced_variants", "id = '{$cart['advanced_variant']}'");
            $color = getData("color_name", "product_colors", "id = '$color'");
            if (!$variation && $size) {
                $variation = "Size: $size | Color: $color";
            }

            $image = getData("image", "seller_products", "id = '{$cart['product_id']}'") . '" alt="' . getData("name", "seller_products", "id = '{$cart['product_id']}'");

            if ($cart['other'] && getData("image", "seller_product_variants", "id = '{$cart['other']}'")) {
                $image = getData("image", "seller_product_variants", "id = '{$cart['other']}'");
            }
            if ($cart['advanced_variant'] && getData("image", "seller_product_advanced_variants", "id = '{$cart['advanced_variant']}'")) {
                $image = getData("image", "seller_product_advanced_variants", "id = '{$cart['advanced_variant']}'");
            }

            $subTotal += (int)$cart['price'] * (int)$cart['quantity'];

            $unit = (int)getData("unit", "seller_products", "id = '{$cart['product_id']}'");
            if ((int)getData("unit", "seller_product_variants", "id = '{$cart['other']}'")) {
                $unit = (int)getData("unit", "seller_product_variants", "id = '{$cart['other']}'");
            }

            $stock_unit = getData("stock_unit", "seller_products", "id = '{$cart['product_id']}'");
            $total_stocks = (int)$cart['quantity'] * $unit;

            if ($stock_unit == "kg") {
                $total_stocks = (int)$total_stocks / 1000;
            } else if ($stock_unit == "litre") {
                $total_stocks = (int)$total_stocks / 1000;
            } else if ($stock_unit == "meter") {
                $total_stocks = (int)$total_stocks * 0.3048;
            } else {
                $total_stocks = (int)$total_stocks;
            }

            if (!$stock_unit) $stock_unit = getData("unit_type", "seller_products", "id = '{$cart['product_id']}'");

        ?>
            <div class="bg-white p-4 rounded-md flex flex-col md:flex-row justify-between">
                <div class="flex items-center gap-5">
                    <img class="object-contain xs:w-[108px] xs:h-[108px] w-24 h-24 rounded-md" src="<?= UPLOADS_URL . $image ?>" alt="" />

                    <div>
                        <p class="font-medium xs:text-lg"><?= limit_characters(getData("name", "seller_products", "id = '{$cart['product_id']}'"), 30) ?></p>

                        <?php if ($variation) : ?>
                            <div class="mt-1 text-gray-500 text-sm"><?= $variation ?></div>
                        <?php endif ?>

                        <div class="flex items-center gap-2 mt-2">
                            <p class="text-[#666666] text-sm font-medium"><?= $total_stocks . ' ' . $stock_unit ?></p>
                            <p class="text-black text-xl font-medium"><?= currencyToSymbol($storeCurrency) . number_format($cart['price'] * $cart['quantity']) ?></p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between flex-col">

                    <div class="md:block hidden">
                        <?php if (isLoggedIn()) : ?>
                            <div class="space-y-2 transition flex">
                                <?php if (getData("id", "customer_wishlists", "customer_id = '$customerId' AND product_id = '{$cart['product_id']}' AND other = ''")) : ?>
                                    <button class="text-[22px] transition w-[44px] h-[44px] rounded-full bg-rose-500 text-white hover:bg-rose-500 hover:text-white disabled:bg-rose-500 disabled:text-white flex items-center justify-center ml-auto handleWishlist" data-id="<?= $cart['product_id'] ?>"><i class='bx bx-heart'></i></button>
                                <?php else : ?>
                                    <button class="text-[22px] transition bg-rose-100 text-rose-500 w-[44px] h-[44px] rounded-full hover:bg-rose-500 hover:text-white disabled:bg-rose-500 disabled:text-white flex items-center justify-center ml-auto handleWishlist" data-id="<?= $cart['product_id'] ?>"><i class='bx bx-heart'></i></button>
                                <?php endif ?>
                            </div>
                        <?php endif ?>
                    </div>

                    <div class="flex items-center justify-end gap-4 mt-2 md:mt-0">
                        <button type="button" class="bg-red-50 text-red-500 rounded-xl w-10 h-10 text-xl flex items-center justify-center removeQtyBtn" data-id="<?= $cart['product_id'] ?>" data-variant="<?= $cart['other'] ?>" data-advancedVariant="<?= $cart['advanced_variant'] ?>"><i class='bx bx-trash'></i></button>

                        <div class="border border-primary-100 rounded-xl p-[10px] flex items-center gap-[9px]">
                            <button type="button" class="text-2xl text-black flex items-center justify-center decreaseQtyBtn" data-id="<?= $cart['product_id'] ?>" data-variant="<?= $cart['other'] ?>" data-advancedVariant="<?= $cart['advanced_variant'] ?>"><i class='font-medium bx bx-minus'></i></button>

                            <span class="text-sm font-medium text-gray-500 currentQty"><?= $cart['quantity'] ?></span>

                            <button type="button" class="text-2xl text-black flex items-center justify-center increaseQtyBtn" data-id="<?= $cart['product_id'] ?>" data-variant="<?= $cart['other'] ?>" data-advancedVariant="<?= $cart['advanced_variant'] ?>"><i class='font-medium bx bx-plus'></i></button>
                        </div>
                    </div>

                </div>
            </div>
        <?php endforeach ?>
    </div>

    <a href="<?= $storeUrl ?>checkout" class="bg-primary-500 h-[66px] rounded-[20px] font-medium text-base text-white flex items-center justify-center mt-12">Proceed</a>
</div>