is_processing = false;
last_page = false;
function addMoreElements() {
    is_processing = true;
    $href = $(location).attr('href');
    $.ajax({
        type: "GET",
        url: $href,
        dataType: 'json',
        success: function(data) {
            var count = data.image.length;
            if(!count) {
                return;
            }
            var $grid = $('#feed');
            var appended;
            data.image.forEach(function (item) {
               $item = $('<div class="item col-xs-12"><div class="thumbnail"><div class="caption text-center">' + item.name + '</div></div></div>');
                $grid.append($item).masonry('appended',$item);
            });

            //if (data.html.length > 0) {
            //    $('#feed').append(data.html);
            //    page = page + 1;
            //    last_page = data.last_page;
            //} else {
            //    last_page = true;
            //}
            is_processing = false;
        },
        error: function(data) {
            is_processing = false;
        }
    });
}

$(window).scroll(function() {
    var wintop = $(window).scrollTop(), docheight = $(document).height(), winheight = $(window).height();
    var scrolltrigger = 0.80;
    if ((wintop / (docheight - winheight)) > scrolltrigger) {
        if (last_page === false && is_processing === false) {
            addMoreElements();
        }
    }
});