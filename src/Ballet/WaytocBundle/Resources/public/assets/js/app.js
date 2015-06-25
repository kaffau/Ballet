var $container = $('#feed');
$container.masonry({
    itemSelector: '.item'
});

var spinner = $(".spinner").spinner({min: 16, max: 60}).val(26);


$(function() {
    $(".btn-circle").on("click", function(e) {
        e.preventDefault();
        var caption = $(this).closest(".caption");
        var ageValue = $(this).closest(".thumbnail").find('.spinner').spinner().val();
        var data = {age : ageValue};
        var $href = $(this).attr('href');

        $.ajax({
            type: "POST",
            url: $href,
            data: data,
            success: function (data) {
                caption.empty();
                caption.append('<h3>Thank you!</h3>');
            },

            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert('Error : ' + errorThrown);
            }
        })
    })
});