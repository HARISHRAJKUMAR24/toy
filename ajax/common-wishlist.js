// Load wishlist count on page load
getWishlistsCount();

$(document).on("click", ".handleWishlist", function () {
    const element = $(this);
    const icon = element.find("i");
    const product_id = element.data("id");
    const variant = element.attr("data-variant") || "";

    $.ajax({
        url: "shop/ajax/handle-wishlist.php",
        type: "POST",
        data: { product_id, variant },
        success: function (result) {
            getWishlistsCount();
            const response = result && JSON.parse(result);
            if (response && response.success) {
                response.message && toastr.success(response.message);

                // Toggle based on current button class
                if (element.hasClass("bg-gray-500")) {
                    // Inactive → Active
                    element.removeClass("bg-gray-500").addClass("bg-white");
                    icon.removeClass("text-white").addClass("text-rose-500");
                } else {
                    // Active → Inactive
                    element.removeClass("bg-white").addClass("bg-gray-500");
                    icon.removeClass("text-rose-500").addClass("text-white");
                }
            } else if (response) {
                toastr.error(response.message);
            }
        },
    });
});


// Display wishlist count
function getWishlistsCount() {
    $.ajax({
        url: "shop/ajax/get-wishlist-count.php",
        success: function (result) {
            const response = result && JSON.parse(result);
            $(".wishlistItemsCount").text(response.itemsCount);
            $(".wishlistItemsCountWithTxt").text(response.itemsCount + " prod");
        },
    });
}
