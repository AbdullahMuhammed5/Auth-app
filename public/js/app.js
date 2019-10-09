$(function () {

    // Checkboxes
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });

    // Ckeditor
    if ($('#editor').length){
        alert("Asdas")
        CKEDITOR.replace('editor', {
            filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
    }

    // handle maximum value exceeded
    $('.chosen-select').change(()=>{
        if($(".chosen-choices li.search-choice").length > 10) {
            $('span#maxValueFeedback').css('display', 'block');
        } else if ($(".chosen-choices li.search-choice").length <= 10){
            $('span.maxValueFeedback').css('display', 'none');
        }
    });

    // file chosen select
    $(".chosen-select").chosen();

    // handle request for authors based on post type
    $('#news-type').change(function(){
        let type = $(this).val();
        $.ajax({
            type:"get",
            url: `${window.location.origin}/getAuthorsByJob/${type}`,
            headers : {
                "Access-Control-Allow-Origin" : "*"},
            success:function(res){
                if(res){
                    $('#author-wrapper').css('display', 'block')
                    $("#author").empty();
                    $("#author").append('<option value="">Select Author</option>');
                    $.each(res, function(key, value){
                        $("#author").append('<option value="'+key+'">'+value+'</option>');
                    });
                }
            },
            error: (err) => console.log(err)
        });
    });

    // handle request for cities based on it's country
    $('#country').change(function(){
        let cid = $(this).val();
        if(cid){
            $.ajax({
                type:"get",
                url: `${window.location.origin}/getCities/${cid}`,
                success:function(res){
                    if(res){
                        $('#city-wrapper').css('display', 'block')
                        $("#city").empty();
                        $("#city").append('<option value="">Select City</option>');
                        $.each(res, function(key, value){
                            $("#city").append('<option value="'+key+'">'+value+'</option>');
                        });
                    }
                }
            });
        }
    });
});
