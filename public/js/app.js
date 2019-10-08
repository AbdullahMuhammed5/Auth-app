$(function () {

    // Checkboxes
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });

    // Ckeditor
    CKEDITOR.replace('editor', {
        filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });
    $(".chosen-select").chosen();
    // $('#news-type').change(function(){
    //     let typeID = $(this).val() == 'News' ? 2 : 1;
    //     $.ajax({
    //         type:"get",
    //         url: window.location.hostname+":8000/getAuthorsByJob/"+typeID,
    //         headers : {
    //             "Access-Control-Allow-Origin" : "*"},
    //         success:function(res){
    //             if(res){
    //                 $('#author-wrapper').css('display', 'block')
    //                 $("#author").empty();
    //                 $("#author").append('<option value="">Select Author</option>');
    //                 $.each(res, function(key, value){
    //                     $("#author").append('<option value="'+key+'">'+value+'</option>');
    //                 });
    //             }
    //         },
    //         error: (err)=>{
    //             console.log(err)
    //         }
    //     });
    // });
});
