jQuery(document).ready(function ($) {
  const bar = $(".shfb-bar");
  const mode = SHFB_DATA.displayMode;

  if (mode === "once") {
    if (localStorage.getItem("shfb_bar_closed") === "yes") {
      bar.remove();
      return;
    }

    $(".shfb-close").on("click", function () {
      localStorage.setItem("shfb_bar_closed", "yes");
      bar.fadeOut();
    });
  } else {
    $(".shfb-close").on("click", function () {
      bar.fadeOut();
    });
  }
});
