/**** MarketPress Ajax JS *********/
jQuery(document).ready(function($) {
  //empty cart
  function mp_empty_cart() {
    if ($("a.mp_empty_cart").attr("onClick") != undefined) {
      return;
    }

    $("a.mp_empty_cart").click(function() {
      var answer = confirm(MP_Ajax.emptyCartMsg);
      if (answer) {
        $(this).html('<img src="'+MP_Ajax.imgUrl+'" />');
        $.post(MP_Ajax.ajaxUrl, {action: 'mp-update-cart', empty_cart: 1}, function(data) {
          $("div.mp_cart_widget_content").html(data);
        });
      }
      return false;
    });
  }
  //add item to cart
  function mp_cart_listeners() {
    $("input.mp_button_addcart").click(function() {
      var input = $(this);
      var formElm = $(input).parents('form.mp_buy_form');
      var tempHtml = formElm.html();
      var serializedForm = formElm.serialize();
      formElm.html('<img src="'+MP_Ajax.imgUrl+'" alt="'+MP_Ajax.addingMsg+'" />');
      $.post(MP_Ajax.ajaxUrl, serializedForm, function(data) {
        var result = data.split('||', 2);
        if (result[0] == 'error') {
          alert(result[1]);
          formElm.html(tempHtml);
          mp_cart_listeners();
        } else {
          formElm.html('<span class="mp_adding_to_cart">'+MP_Ajax.successMsg+'</span>');
          $("div.mp_cart_widget_content").html(result[1]);
          if (result[0] > 0) {
            formElm.fadeOut(5000, function(){
              formElm.html(tempHtml).fadeIn('fast');
              mp_cart_listeners();
            });
          } else {
            formElm.fadeOut(5000, function(){
              formElm.html('<span class="mp_no_stock">'+MP_Ajax.outMsg+'</span>').fadeIn('fast');
              mp_cart_listeners();
            });
          }
          mp_empty_cart(); //re-init empty script as the widget was reloaded
          window.location.reload() ;
        }
      });
      return false;
    });
  }
  //add listeners
  mp_empty_cart();
  mp_cart_listeners();
});