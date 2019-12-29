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
        $('#btn-report').attr('disabled','disabled');
        var date = $('#datetimes').val();
        var shift = $('#shifttime').val();
        $('#table_report_staff tbody').html('');
        $('#table_report_staff').loading({
            message:'Đang thống kê...'
        });
        $.ajax({
            url: base_url + '/report_staff_ajax?date='+date+'&shift='+shift,
            type:'GET',
            success:function(ketqua){
                if(ketqua.code == 401){
                    alert(ketqua.msg)
                }else if(ketqua.code == 200){
               
                    $.each(ketqua.data,function(k,v){
                        if(k != 'total'){
                            $('#table_report_staff tbody').append('<tr>'+
                            '<td>'+k+'</td>'
                            +'<td>'+v.total+'</td>'
                            +'<td>'+v.cus_bad+'</td>'
                            +'<td>'+v.cus_total+'</td>' 
                            +'</tr>');
                        }else{
                            $('#total_cus').html(v.total_cus);
                            $('#total_bad').html(v.total_bad);
                            $('#total').html(v.total);
                            
                        }
                       
                    });
                }else{
                    alert('Server bị lỗi! VUi lòng thử lại vs mạng mạnh hơn!');
                }
                $('#table_report_staff').loading('stop');
                $('#btn-report').removeAttr('disabled');
            }
         
        });
    })
 })