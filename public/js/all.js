(function($){
    var o = $({});
    $.subscribe = function(){
        o.on.apply(o, arguments);
    };

    $.unsubscribe = function(){
        o.off.apply(o, arguments);
    };

    $.publish = function(){
        o.trigger.apply(o, arguments);
    };

}(jQuery));
(function(){

    var submitAjaxRequest = function(e){
        var form = $(this);
        var method = form.find('input[name = "_method"]').val() || 'POST';

        $.ajax({
          type: method,
          url: form.prop('action'),
          data: form.serialize(),
          success: function(){
              $.publish('form.submitted', form);
          }
        });
        e.preventDefault();
    };

    //submit all form mark with 'data-remote' via Ajax Request
    $('form[data-remote]').on('submit', submitAjaxRequest);

    //The data-click-submits-form attribute immediately submit the form on change
    $('*[data-click-submits-form]').on('change', function(){
        $(".flashMsg").fadeIn(500).delay(1000).fadeOut(500);
        $(this).closest('form').submit();
    });
})();
(function(){
    $.subscribe('form.submitted', function(){
        $(".flashMsg").fadeIn(500).delay(1000).fadeOut(500);
    });
})();
