var page = 1; // Initial page number for infinite scroll
var isLoading = false; // Flag to prevent multiple AJAX calls

$(window).scroll(function () {
  if (
    $(window).scrollTop() + $(window).height() >=
    $(document).height() - 200
  ) {
    if (!$("footer").is(":visible") && !$(".loader").length) {
      $("#loaderBox").html(
        '<div class="mt-5 text-lg text-center loader text-primary-500"><img src="assets/img/loading.webp" alt="" id="loading" style="width: 80px; margin: 0 auto; display: block"></div>'
      );
    }

    loadMoreData();
  }
});

function loadMoreData() {
  if (isLoading) return;

  isLoading = true;

  setInterval(() => {
    $.ajax({
      url: "shop/ajax/get-category-wise-product.php",
      type: "POST",
      data: {
        page: page,
        category: $("#category").text(),
        min_price: $("#minPrice").text(),
        max_price: $("#maxPrice").text(),
      },
      success: function (response) {
        if (response != "") {
          $("#p_c_content").append(response);
          page++;
          isLoading = false;
        } else {
          // Remove loading spinner or message
          $(".loader").remove();

          $("footer").fadeIn();
          // No more data available
          isLoading = true;
        }
      },
    });
  }, 1000);
}

$(document).ready(function () {
  $("footer").hide();
  loadMoreData();
});
