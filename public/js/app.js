(function(){
    $.subscribe('form.submitted', function(){
        $(".flashMsg").fadeIn(500).delay(1000).fadeOut(500);
    });
})();
