$(function(){
    $('input[name="datetimes"]').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        minYear: 2018,
        maxYear: parseInt(moment().format('YYYY'),10),
        locale: {
            format: 'DD-MM-YYYY'
        }
    });

    $(document).on('click','#btn-report',function(event){
        event.preventDefault();
        var token = $('#token').val();
        $('#btn-report').attr('disabled','disabled');
        var date = $('#datetimes').val();
        var shift = $('#shifttime').val();
        $('#table_report_customer tbody').html('');
        $('#table_report_customer').loading({
            message:'Đang thống kê...'
        });
        $.ajax({
            url: base_url + '/report_customer_ajax?date='+date,
            type:'GET',
            success:function(ketqua){
                if(ketqua.code == 200){
                    start = 0;
                    var get_customer = 10;
                    var data = ketqua.data;
                    final = new Object();
                    var count_cus = data.length;
                    if(count_cus > 0){
                        var get_cus = setInterval(function(){
                          
                            end = start + get_customer;
                           
                            if(end > count_cus){
                                end = count_cus;
                            }
                            customer = data.slice(start,end);
                            $.ajax({
                                url: base_url + '/report_customer_ajax',
                                type:'POST',
                                data:{
                                    data: customer,
                                    _token: token
                                },
                                success:function(res){
                                    $.each(res,function(k,v){
                                        if(start == 0){
                                            final[k] = 0;
                                        }

                                        final[k] += v;
                                    })
                                    start = end;
                                  
                                    if(end == count_cus){
                                        // console.log(final.length);
                                        clearInterval(get_cus);       
                                        $('#table_report_customer').loading('stop');
                                        $('#btn-report').removeAttr('disabled');
                                     
                                        $.each(final,function(m,n){
                                            // console.log(m +'a'+ n)
                                            $('#table_report_customer > tbody').append('<tr><td>'+
                                            m
                                            +'</td><td>'+
                                            n
                                            +'</td></tr>');
                                        })
                                    
                                    }
                                }
                            });
                 
                           
                      
                        }, 5000);
                    }else{
                        alert('Không có dữ liệu ngày hôm nay');
                    }
                }

            }
        });
    });
});