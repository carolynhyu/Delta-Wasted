// WASTED CORE JAVASCRIPT

// TABLE OF CONTENTS

// 1. NAVBAR COLLAPSE/Expand

// 2.

//NAVBAR COLLAPSE/EXPAND

// Collapse/Expand icon
$("#collapse-icon").addClass("fa-angle-double-left");

// Collapse click
$("[data-toggle=sidebar-collapse]").click(function() {
  SidebarCollapse();
});

function SidebarCollapse() {
  $(".menu-collapsed").toggleClass("d-none");
  $("#sidebar-container").toggleClass("sidebar-expanded sidebar-collapsed");
  $(".main-content")
    .parent()
    .toggleClass("col-md-10");
  $(".main-content")
    .parent()
    .toggleClass("col-md-12");
  $(".main-content")
    .parent()
    .toggleClass("offset-md-2");
  // Treating d-flex/d-none on separators with title
  var SeparatorTitle = $(".sidebar-separator-title");
  var HeaderText = $(".toggle");
  var AddIngred = $("#nav-add");
  if ($("#collapse-icon").hasClass("fa-angle-double-right")) {
    // SeparatorTitle.removeClass('d-flex');

    HeaderText.css("display", "inline-block");
    // $(".toggle").css("display", "inline-block");
    // $(".toggle").show();

    AddIngred.removeClass("sidebar-collapsed");
    $("#nav-add").css("width", "230px");
  } else {
    SeparatorTitle.addClass("d-flex");
    $(".list-group").css("background-color", "#a0d468");

    HeaderText.css("display", "none");
    // $(".toggle").hide();

    AddIngred.addClass("sidebar-collapsed");
    $("#nav-add").css("width", "auto");
  }

  // Collapse/Expand icon
  $("#collapse-icon").toggleClass("fa-angle-double-left fa-angle-double-right");
}

//ADD INGREDIENTS PAGE

$(".ingredient-inner").mouseover(function() {
  $(this).find(".ingredient-check");
  $(this)
    .find("img")
    .css("opacity", "1");
});

$(".ingredient-inner").mouseout(function() {
  $(this).find(".ingredient-check");
  $(this)
    .find("img")
    .css("opacity", ".6");
});

$(".ingredient-inner .ingredient-check").on("click", function() {
  if (!$(this).hasClass("selected")) {
    $(this).addClass("selected");
  } else {
    $(this).removeClass("selected");
  }
});

// COUNTER

$(document).ready(function() {
  $(".count").prop("disabled", true);
  $(document).on("click", ".plus", function() {
    $(".count").val(parseInt($(".count").val()) + 1);
  });
  $(document).on("click", ".minus", function() {
    $(".count").val(parseInt($(".count").val()) - 1);
    if ($(".count").val() == 0) {
      $(".count").val(1);
    }
  });
});

// MODAL

$(".button-after-inline-edit").on("click", function() {
  $.fancybox.close();
});
