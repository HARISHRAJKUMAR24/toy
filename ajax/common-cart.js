getProductCountAndPrice();
getCartData();

// Add to cart
$(document).on("click", ".addToCartBtn", function () {

    const element = $(this);
    const product_id = element.data("id");
    const variant = element.attr("data-variant")
        ? element.attr("data-variant")
        : "";
    console.log('variant variant ' + variant);
    const advanced_variant = element.attr("data-advancedVariant")
        ? element.attr("data-advancedVariant")
        : "";

    const redirectUrl = element.attr("data-redirectUrl")
        ? element.attr("data-redirectUrl")
        : "";
    console.log('variant ' + variant)
    $(".group[data-id='" + product_id + "']").waitMe({
        effect: "bounce",
        bg: "rgba(255,255,255,0.7)",
        color: "var(--primary-color)",
        maxSize: "",
        waitTime: -1,
        textPos: "vertical",
        fontSize: "",
        source: "",
        onClose: function () { },
    });

    $.ajax({
        url: "shop/ajax/add-to-cart.php",
        //url: "themes/theme7/ajax/add-to-cart.php",
        type: "POST",
        data: { product_id, variant, advanced_variant, redirectUrl },
        success: function (result) {
            console.log('addToCartBtn.. ' + variant + ' result: ' + result);
            const response = result && JSON.parse(result);

            $(".group[data-id='" + product_id + "']").waitMe("hide");

            if (response) {
                if (response.success) {
                    /* $(".addToCartWrapper[data-id='" + product_id + "']")
                       .html(`<div class="qtySwitcher">
                     <button class="decreaseQtyBtn" data-id="${product_id}">${decreaseQtyBtnHtml}</button>
             
                     <span class="text-base font-medium text-center currentQty">1</span>
             
                     <button class="increaseQtyBtn" data-id="${product_id}">${increaseQtyBtnHtml}</button>
                 </div>`); */


                    toastr.success(response.message);
                    getProductCountAndPrice();
                    getCartData();

                    response.redirectUrl
                        ? (window.location.href = response.redirectUrl)
                        : null;
                } else {
                    toastr.error(response.message);
                }
            }
        },
    });
});

// Increase quantity
$(document).on("click", ".increaseQtyBtn", function () {
    const element = $(this);
    const id = element.data("id");
    const variant = element.attr("data-variant")
        ? element.attr("data-variant")
        : "";
    const advancedVariant = element.attr("data-advancedVariant")
        ? element.attr("data-advancedVariant")
        : "";
    console.log(variant + 'increaseQtyBtn..' + id);
    $(".group[data-id='" + id + "']").waitMe({
        effect: "bounce",
        bg: "rgba(255,255,255,0.7)",
        color: "var(--primary-color)",
        maxSize: "",
        waitTime: -1,
        textPos: "vertical",
        fontSize: "",
        source: "",
        onClose: function () { },
    });

    $.ajax({
        url: "shop/ajax/manage-qty.php",
        type: "POST",
        data: { id, type: "increase", variant, advancedVariant },
        success: function (result) {
            const response = result && JSON.parse(result);

            if (response) {

                if (response.success) {

                    getProductCountAndPrice();

                    getCartData();

                    response.message && toastr.success(response.message);

                    let currentQty = $(".group[data-id='" + id + "']").find(
                        ".currentQty"
                    );
                    console.log('increaseQtyBtn..777 ' + currentQty + '  text ' + currentQty.parent().text());
                    currentQty.text(
                        parseInt(element.closest(".group").find(".currentQty").text()) + 1
                    );

                } else {

                    toastr.error(response.message);
                }
            }

            $(".group[data-id='" + id + "']").waitMe("hide");
        },
    });
});

// Decrease quantity
$(document).on("click", ".decreaseQtyBtn", function () {
    const element = $(this);
    const id = element.data("id");
    const currentQty = $(".group[data-id='" + id + "']").find(".currentQty");
    const variant = element.attr("data-variant")
        ? element.attr("data-variant")
        : "";
    const advancedVariant = element.attr("data-advancedVariant")
        ? element.attr("data-advancedVariant")
        : "";

    $(".group[data-id='" + id + "']").waitMe({
        effect: "bounce",
        bg: "rgba(255,255,255,0.7)",
        color: "var(--primary-color)",
        maxSize: "",
        waitTime: -1,
        textPos: "vertical",
        fontSize: "",
        source: "",
        onClose: function () { },
    });

    $.ajax({
        url: "shop/ajax/manage-qty.php",
        type: "POST",
        data: { id, type: "decrease", variant, advancedVariant },
        success: function (result) {
            $(".group[data-id='" + id + "']").waitMe("hide");

            const response = result && JSON.parse(result);

            if (response) {
                if (response.success) {
                    getProductCountAndPrice();
                    getCartData();

                    response.message && toastr.success(response.message);
                    currentQty.text(
                        parseInt(element.closest(".group").find(".currentQty").text()) - 1
                    );

                    if (
                        parseInt(element.closest(".group").find(".currentQty").text()) <= 0
                    ) {
                        $(".addToCartWrapper[data-id='" + id + "']").html(
                            `<button type="button" class="addToCartBtn" data-id="${id}">${addToCartBtnHtml}</button>`
                        );
                    }
                } else {
                    toastr.error(response.message);
                }
            }
        },
    });
});

// Remove quantity
$(document).on("click", ".removeQtyBtn", function () {
    const element = $(this);
    const id = element.data("id");
    const variant = element.attr("data-variant")
        ? element.attr("data-variant")
        : "";
    const advancedVariant = element.attr("data-advancedVariant")
        ? element.attr("data-advancedVariant")
        : "";

    $(".group[data-id='" + id + "']").waitMe({
        effect: "bounce",
        bg: "rgba(255,255,255,0.7)",
        color: "var(--primary-color)",
        maxSize: "",
        waitTime: -1,
        textPos: "vertical",
        fontSize: "",
        source: "",
        onClose: function () { },
    });

    $.ajax({
        url: "shop/ajax/manage-qty.php",
        type: "POST",
        data: { id, type: "remove", variant, advancedVariant },
        success: function (result) {


            const response = result && JSON.parse(result);

            if (response) {
                if (response.success) {
                    $(".group[data-id='" + id + "']").waitMe("hide");
                    element.css("display", "none");
                    $(".addToCartWrapper[data-id='" + id + "']").html(
                        `<button type="button" class="addToCartBtn" data-id="${id}">${addToCartBtnHtml}</button>`
                    );

                    getProductCountAndPrice();
                    getCartData();

                    response.message && toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                }
            }
        },
    });
});

// Display cart data
function getCartData() {
    $.ajax({
        // url: "shop/ajax/get-cart-data.php",
        url: "themes/theme7/ajax/get-cart-data.php",
        success: function (html) {
            $("#cartDataList").html(html);
        },
    });
}

// Display product count and price
function getProductCountAndPrice() {
    $.ajax({
        url: "shop/ajax/get-product-count-and-price.php",
        success: function (result) {
            const response = result && JSON.parse(result);
            console.log('getProductCountAndPrice ' + response.itemsCount,);
            $(".cartItemsCount").text(response.itemsCount);
            $(".cartItemsCountWithTxt").text(response.itemsCount + " Item");
            $(".cartPrice").text(response.price);
        },
    });
}
