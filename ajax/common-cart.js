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

// Increase quantity - UPDATED: Single handler for both cart page and product cards
$(document).on("click", ".increaseQtyBtn", function () {
  const element = $(this);
  const id = element.data("id");
  const variant = element.attr("data-variant") || "";
  const advancedVariant = element.attr("data-advancedVariant") || "";

  // Check if this is in cart page
  const cartItem = element.closest('.cart-item');

  if (cartItem.length > 0) {
    // Cart page behavior - no waitMe, immediate update
    // Add loading state
    const buttons = element.closest('.addToCartWrapper').find('.increaseQtyBtn, .decreaseQtyBtn');
    buttons.prop("disabled", true).addClass("opacity-50 cursor-not-allowed");

    $.ajax({
      url: "shop/ajax/manage-qty.php",
      type: "POST",
      data: { id, type: "increase", variant, advancedVariant },
      success: function (result) {
        const response = result && JSON.parse(result);

        // Remove loading state
        buttons.prop("disabled", false).removeClass("opacity-50 cursor-not-allowed");

        if (response) {
          if (response.success) {
            getProductCountAndPrice();

            // Update quantity display
            let currentQty = element.closest(".addToCartWrapper").find(".currentQty");
            currentQty.text(parseInt(currentQty.text()) + 1);

            // Update cart summary
            updateCartSummary();

            // Show success message
            if (typeof showCustomToast === 'function') {
              showCustomToast("Quantity increased", 'success');
            } else {
              response.message && toastr.success(response.message);
            }
          } else {
            toastr.error(response.message);
          }
        }
      },
      error: function () {
        buttons.prop("disabled", false).removeClass("opacity-50 cursor-not-allowed");
        toastr.error("Network error. Please try again.");
      }
    });
  } else {
    // Product card behavior - original with waitMe
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

            let currentQty = $(".group[data-id='" + id + "']").find(".currentQty");
            currentQty.text(parseInt(element.closest(".group").find(".currentQty").text()) + 1);

          } else {
            toastr.error(response.message);
          }
        }

        $(".group[data-id='" + id + "']").waitMe("hide");
      },
    });
  }
});

// Decrease quantity - UPDATED: Single handler for both cart page and product cards
$(document).on("click", ".decreaseQtyBtn", function () {
  const element = $(this);
  const id = element.data("id");
  const variant = element.attr("data-variant") || "";
  const advancedVariant = element.attr("data-advancedVariant") || "";

  // Check if this is in cart page
  const cartItem = element.closest('.cart-item');

  if (cartItem.length > 0) {
    // Cart page behavior - no waitMe, immediate update
    // Add loading state
    const buttons = element.closest('.addToCartWrapper').find('.increaseQtyBtn, .decreaseQtyBtn');
    buttons.prop("disabled", true).addClass("opacity-50 cursor-not-allowed");

    $.ajax({
      url: "shop/ajax/manage-qty.php",
      type: "POST",
      data: { id, type: "decrease", variant, advancedVariant },
      success: function (result) {
        const response = result && JSON.parse(result);

        // Remove loading state
        buttons.prop("disabled", false).removeClass("opacity-50 cursor-not-allowed");

        if (response) {
          if (response.success) {
            getProductCountAndPrice();

            // Update quantity display
            let currentQty = element.closest(".addToCartWrapper").find(".currentQty");
            const newQty = parseInt(currentQty.text()) - 1;
            currentQty.text(newQty);

            // If quantity becomes 0, remove item
            if (newQty <= 0) {
              cartItem.addClass('remove-animation');
              setTimeout(() => {
                cartItem.remove();
                // Update summary and check empty state
                updateCartSummary();
                checkCartEmptyState();
              }, 300);
            } else {
              // Update cart summary for normal decrease
              updateCartSummary();
            }

            // Show success message
            if (typeof showCustomToast === 'function') {
              showCustomToast("Quantity decreased", 'success');
            } else {
              response.message && toastr.success(response.message);
            }
          } else {
            toastr.error(response.message);
          }
        }
      },
      error: function () {
        buttons.prop("disabled", false).removeClass("opacity-50 cursor-not-allowed");
        toastr.error("Network error. Please try again.");
      }
    });
  } else {
    // Product card behavior - original with waitMe
    const currentQty = $(".group[data-id='" + id + "']").find(".currentQty");

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
            currentQty.text(parseInt(element.closest(".group").find(".currentQty").text()) - 1);

            if (parseInt(element.closest(".group").find(".currentQty").text()) <= 0) {
              const addToCartBtnHtml = "Add to Cart";
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
  }
});

// Remove quantity - UPDATED for live cart updates
$(document).on("click", ".removeQtyBtn", function () {
  const element = $(this);
  const id = element.data("id");
  const variant = element.attr("data-variant") ? element.attr("data-variant") : "";
  const advancedVariant = element.attr("data-advancedVariant") ? element.attr("data-advancedVariant") : "";
  const productName = element.data("product-name") || "Item";

  // Check if this is a cart page item
  const cartItem = element.closest('.cart-item');

  if (cartItem.length > 0) {
    // Cart page - immediate removal with animation
    // Show loading state on button
    const originalHtml = element.html();
    element.html('<i class="fas fa-spinner fa-spin"></i>');
    element.prop("disabled", true);

    $.ajax({
      url: "shop/ajax/manage-qty.php",
      type: "POST",
      data: { id, type: "remove", variant, advancedVariant },
      success: function (result) {
        const response = result && JSON.parse(result);

        if (response) {
          if (response.success) {
            // Animate removal
            cartItem.addClass('remove-animation');

            // Remove from DOM after animation
            setTimeout(() => {
              cartItem.remove();

              // Update cart counts
              getProductCountAndPrice();
              getCartData();

              // Update cart summary without reload
              updateCartSummary();

              // Check if cart is empty and hide/show sections
              checkCartEmptyState();

              // Show success toast
              if (typeof showCustomToast === 'function') {
                showCustomToast(`${productName} removed from cart`, 'success');
              } else {
                toastr.success(response.message);
              }
            }, 300);
          } else {
            // Reset button state
            element.html(originalHtml);
            element.prop("disabled", false);
            toastr.error(response.message);
          }
        }
      },
      error: function () {
        element.html(originalHtml);
        element.prop("disabled", false);
        toastr.error('Network error occurred');
      }
    });
  } else {
    // Product card - original behavior
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

            // Define addToCartBtnHtml before using it
            const addToCartBtnHtml = "Add to Cart";

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
      }
    });
  }
});

// Function to check and update cart empty state
function checkCartEmptyState() {
  const cartItemsContainer = $('#cartItemsContainer');
  const cartItems = cartItemsContainer.find('.cart-item');

  if (cartItems.length === 0) {
    // Hide the entire cart section instead of showing empty message
    cartItemsContainer.closest('.lg\\:col-span-2').hide();
    $('.lg\\:col-span-1').hide(); // Hide summary section too

    // Optional: Show a minimal message or redirect
    // You can add a small message here if needed, but not the big "empty cart" one
  }
}

// Function to update cart summary without page reload
function updateCartSummary() {
  $.ajax({
    url: "shop/ajax/get-cart-summary.php",
    type: "GET",
    success: function (result) {
      try {
        const response = JSON.parse(result);
        if (response.success) {
          // Update subtotal
          $('#subTotal').text(response.currency_symbol + response.subtotal.toFixed(2));

          // Update tax
          $('#gstTax').text(response.currency_symbol + response.tax.toFixed(2));

          // Update discount
          $('#discount').text(response.currency_symbol + response.discount.toFixed(2));

          // Update total
          $('#total').text(response.currency_symbol + response.total.toFixed(2));

          // Update checkout button visibility based on minimum order
          const minimumOrder = response.minimum_order || 0;
          const checkoutSection = $('.mt-4').first();

          if (minimumOrder > 0 && response.subtotal < minimumOrder) {
            checkoutSection.html(`
              <div class="py-2 sm:py-3 px-3 sm:px-4 rounded-lg sm:rounded-xl text-center bg-gradient-to-r from-pink-50 to-pink-100 border border-pink-200 shadow-sm">
                <p class="text-pink-700 font-semibold text-xs sm:text-sm">
                  Minimum order is
                  <span class="font-bold text-pink-600">
                    ${response.currency_symbol}${minimumOrder.toFixed(2)}
                  </span>
                </p>
                <p class="text-xs text-pink-500 mt-1 italic">
                  Great deals await when you checkout!
                </p>
              </div>
            `);
          } else {
            checkoutSection.html(`
              <button
                onclick="window.location.href='${response.store_url}checkout';"
                class="w-full py-2 sm:py-3 mt-2 sm:mt-3 rounded-lg sm:rounded-xl font-semibold text-white bg-gradient-to-r from-pink-400 to-pink-600 hover:from-pink-500 hover:to-pink-700 shadow-lg transition text-sm sm:text-base">
                Checkout Now
              </button>
            `);
          }
        }
      } catch (e) {
        console.error('Error updating cart summary:', e);
      }
    },
    error: function () {
      console.error('Failed to update cart summary');
    }
  });
}

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