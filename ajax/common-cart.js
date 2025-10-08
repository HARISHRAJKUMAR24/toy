getProductCountAndPrice();
getCartData();

// Add to cart
$(document).on("click", ".addToCartBtn", function () {
    const element = $(this);
    const product_id = element.data("id");
    const variant = element.attr("data-variant") || "";
    const advanced_variant = element.attr("data-advancedVariant") || "";
    const variation = element.attr("data-variation") || "";
    const redirectUrl = element.attr("data-redirectUrl") || "";

    $(".group[data-id='" + product_id + "']").waitMe({
        effect: "bounce",
        bg: "rgba(255,255,255,0.7)",
        color: "var(--primary-color)",
        maxSize: "",
        waitTime: -1,
        textPos: "vertical"
    });

    $.ajax({
        url: "themes/theme9/ajax/add-to-cart.php", // ✅ must use theme9 override
        type: "POST",
        data: { product_id, variant, advanced_variant, variation, redirectUrl },
        success: function (result) {
            $(".group[data-id='" + product_id + "']").waitMe("hide");

            let response;
            try { response = JSON.parse(result); } catch(e) { console.error(result); return; }

            if (response.success) {
                $(".addToCartWrapper[data-id='" + product_id + "']").html(`
                    <div class="qtySwitcher">
                        <button class="decreaseQtyBtn" data-id="${product_id}">${decreaseQtyBtnHtml}</button>
                        <span class="text-base font-medium text-center currentQty">1</span>
                        <button class="increaseQtyBtn" data-id="${product_id}">${increaseQtyBtnHtml}</button>
                    </div>
                `);
                toastr.success(response.message);
                getProductCountAndPrice();
                getCartData();
                if(response.redirectUrl) window.location.href = response.redirectUrl;
            } else {
                toastr.error(response.message);
            }
        },
    });
});
