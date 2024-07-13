jQuery(function ($) {
  'use strict';

  /*============================================
   Checkbox
   ==============================================*/
  var this_var = $(this);
  $('.payment-inner-box input:checkbox').change(function () {
    if (this_var.is(":checked")) {
      this_var.closest("a").addClass("active");
    } else {
      this_var.closest("a").removeClass("active");
    }
  });


  /*============================================
    Data table
    ==============================================*/
  var mytable = $('#myTable');
  if (mytable.length) {
    mytable.DataTable();
  }

  /*============================================
    Scrollbar
    ==============================================*/
  var scroll_table = $('.scroll-table');
  if (scroll_table.length) {
    scroll_table.mCustomScrollbar();
  }

  /*============================================
    Search
    ==============================================*/
  var togglebuilder = $('.search-btn-offset, .close-btn-sm');
  var search_wrapper = $(".search-wrapper-side");
  if (togglebuilder.length) {
    togglebuilder.on('click', function () {
      search_wrapper.toggleClass("offset-pull");
    });
  }
});


$("#selectAll").click(function () {
  $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
});

function hideModal(modal) {
  $(modal).removeClass("in");
  $(".modal-backdrop").remove();
  $('body').removeClass('modal-open');
  $('body').css('padding-right', '');
  $(modal).hide();
}