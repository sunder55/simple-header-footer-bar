jQuery(document).ready(function ($) {
  $(".shfb-close").on("click", function () {
    $(this).closest(".shfb-bar").fadeOut();
  });
});
