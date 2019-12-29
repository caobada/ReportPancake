$(function(){
    $('#option-send').select2();

    $('#option-send').on('change',function(){
        var tags = $(this).val();
        var token = $('#token').val();
        $.ajax({
            url: base_url + '/get_count_customer_ajax',
            type:'POST',
            data:{
                tags :tags,
                _token: token
            },
            success:function(ketqua){
                console.log(ketqua);
            }
        });
    })
})