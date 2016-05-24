$(function() {

    var feed = $('#feed');
    if(feed.length) {
        var $grid = $('#feed').imagesLoaded( function() {
            $grid.masonry({
                itemSelector: '.item',
                percentPosition: false
            });
        });
        scrollFrame('#feed .item img');
    }

    var spinner = $(".spinner").spinner({min: 16, max: 90}).val(26);

});


$(function() {
    $("body").on("click",".btn-circle", function(e) {
        e.preventDefault();
        var caption = $(this).closest(".caption");
        var ageValue = $(this).closest(".thumbnail").find('.spinner').spinner().val();
        if($.isNumeric(ageValue)) {
            var data = {age : ageValue};
            var $href = $(this).attr('href');

            $.ajax({
                type: "POST",
                url: $href,
                data: data,
                success: function (data) {
                    caption.empty();
                    caption.append('<h4>Thank you!</h4>').hide().fadeIn(2000);
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log('Error : ' + errorThrown);
                }
            })
        }

    });

    $("body").on("click",".btn-like", function(e) {
        e.preventDefault();
        var $href = $(this).attr('href');
        var self = $(this);
        $.ajax({
            type: 'POST',
            url: $href,
            beforeSend: function() {
                if(self.children().hasClass("fa-heart-o")) {
                    self.children().removeClass().addClass("fa fa-heart");
                    var unlike = self.data("unlike");
                    self.attr("href", unlike);
                }
                else {
                    self.children().removeClass().addClass("fa fa-heart-o");
                    var like = self.data("like");
                    self.attr("href", like);
                }
            },
            success: function (data) {
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log('Error : ' + errorThrown);
            }
        })
    });

});


$(document).ready(function(){
    var dropzone = $(".dropzone");
    if(dropzone.length) {
        Dropzone.autoDiscover = false;
        var href= $(location).attr('href');
        var myDropzone = new Dropzone(".dropzone", {
            url: href,
            paramName: "form[file]",
            addRemoveLinks: true,
            dictDefaultMessage: "Drag your image here",
            maxFiles: 1,
            maxFilesize: 2,
            maxThumbnailFilesize: 2,
            autoProcessQueue: false,
            autoDiscover: false,
            uploadMultiple: false,
            acceptedFiles: "image/*",
            dictInvalidFileType: "This file type is not supported.",
            previewsContainer: '.dropzone-preview',
            init: function() {
                var myDropzone = this;
                $("#form_upload").on('click',function(e) {
                    e.preventDefault();
                    myDropzone.processQueue();
                });
                this.on('complete', function () {
                    var url = $(".after-upload").data("redirect");
                    document.location.href=url;
                });
            },
            accept: function(file, done) {
                if (file.height > 3000 && file.width > 3000) {
                    done("Invalid dimensions!");
                }
                else {
                    done();
                }
            },
            success: function() {
                console.log("Success");
            }
        });
    }

});

