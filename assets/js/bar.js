jQuery(document).ready(function ($) {
  const bar = $(".shfb-bar");
  const mode = SHFB_DATA.displayMode;

  if (mode === "once") {
    if (localStorage.getItem("shfb_bar_closed") === "yes") {
      bar.remove();
      return;
    } else {
      // Show the bar for first-time visitors
      bar.addClass("shfb-visible");
    }

    $(".shfb-close").on("click", function () {
      localStorage.setItem("shfb_bar_closed", "yes");
      bar.fadeOut();
    });
  } else {
    // Always show the bar
    bar.addClass("shfb-visible");

    $(".shfb-close").on("click", function () {
      bar.fadeOut();
    });
  }
});
