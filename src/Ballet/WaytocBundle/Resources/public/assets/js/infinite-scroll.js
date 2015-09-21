is_processing = false;
last_page = false;
var page = 2;
function addMoreElements() {
    is_processing = true;
    $href = $(location).attr('href');

    var loader = $("#loader");
    var data = {page : page};


    $.ajax({
        type: "POST",
        url: $href,
        dataType: 'json',
        data: data,
        beforeSend: function() {
            loader.show();
        },
        complete: function(){
            loader.hide();
        },
        success: function(data) {
            var count = data.length;
            if(!count) {
                last_page = true;
                return;
            }
            page = page + 1;
            var $grid = $('#feed');
            $grid.after().append(data);
            $grid.imagesLoaded( function() {
                $grid.masonry('reloadItems').masonry({
                    transitionDuration: '1.0s',
                    isAnimatedFromBottom: true
                });
            });
            var spinner = $(".spinner").spinner({min: 16, max: 60}).val(26);


            //last_page = data.last_page;
            is_processing = false;
        },
        error: function(data) {
            console.log("failed");
            is_processing = false;
        }

    });
}

if($('#feed').length > 0) {
    $(window).scroll(function() {
        var wintop = $(window).scrollTop(), docheight = $(document).height(), winheight = $(window).height();
        var scrolltrigger = 0.80;
        if ((wintop / (docheight - winheight)) > scrolltrigger) {
            if (last_page === false && is_processing === false) {
                addMoreElements();
            }
        }
    });
}

