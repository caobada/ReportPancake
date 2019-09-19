$(function() {
    var token = $('#token').val();

    $('input[name="datetimes"]').daterangepicker({
        timePicker: true,
        startDate: moment().startOf('day'),
        dateLimit: { days: 2 },
        endDate: moment().startOf('hour'),
        maxDate:moment().endOf('hour'),
        locale: {
        format: 'M/DD HH:mm'
        }
    },function(start, end) {
        var from = start.format('YYYY-MM-DD HH:mm:ss') ;
        var to = end.format('YYYY-MM-DD HH:mm:ss') ;
        $('#table_report_new_customer > tbody').html('');

        $.ajax({
            url: base_url + '/new_customer_ajax',
            type:'POST',
            data:{
                from :from,
                to: to,
                _token: token
            },
            success:function(ketqua){
                $.each( ketqua.data, function( key, value ) {
                    $.each(value,function(k,v){
                        if(k == 'total'){
                            $('#table_report_new_customer #total').html(v);
                        }else{
                            $('#table_report_new_customer > tbody').append('<tr><td>'+
                            k
                        +'</td><td>'+
                            v.count
                        +'</td><td>'+
                            v.tags
                        +'</td></tr>')
                        }
                    })
                  });
            }
        })
    });
});