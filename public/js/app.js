$(function () {

    // Checkboxes
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });

    // Ckeditor
    if ($('#editor').length){
        CKEDITOR.replace('editor', {
            filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
    }

    // handle maximum value exceeded
    $('.chosen-select').change(()=>{
        if($(".search-choice").length >= 10) {
            $('span#maxValueFeedback').css('display', 'block');
        }
        if ($(".search-choice").length < 11){
            $('span#maxValueFeedback').css('display', 'none');
        }
    });

    // file chosen select
    $(".chosen-select").chosen({ max_selected_options: 3 });

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

    // handle ajax get request - get data for select tag
    // $.each($('.get-data-ajax-request'), function() {
    //     $(this).change(function () {
    //         let id = $(this).attr('id') == 'country' ? '#city' : '#author';
    //         let route = $(this).attr('id') == 'country' ? 'getCities' : 'getAuthorsByJob';
    //         // console.log(id)
    //         let param = $(this).val();
    //         if (param) {
    //             $.ajax({
    //                 type: "get",
    //                 url: `${window.location.origin}/${route}/${param}`,
    //                 success: function (res) {
    //                     if (res) {
    //                         $('#city-wrapper').css('display', 'block')
    //                         $(`${id}`).empty();
    //                         $(`${id}`).append('<option value="">Select City</option>');
    //                         $.each(res, function (key, value) {
    //                             $(`${id}`).append('<option value="' + key + '">' + value + '</option>');
    //                         });
    //                     }
    //                 }
    //             });
    //         }
    //     });
    // });

    // handle upload image request
    $.each($('.upload-files'), function(){
        $(this).change(()=>{
            let csrf_token = $('meta[name="csrf-token"]').attr('content');
            event.preventDefault();
            let formData = new FormData();
            let files = $(this)[0].files;
            for (let i = 0; i < files.length; i++){
                formData.append("files[]", files[i]);
            }

            $.ajax({
                method: 'post',
                url: `${window.location.origin}/uploadToServer`,
                data: formData ,
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                headers: { 'X-CSRF-TOKEN': csrf_token },
                success: (res) => console.log(res.success),
                error: (err) => console.log(err)
            })
        });
    })
});
