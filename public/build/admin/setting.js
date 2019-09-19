$(function(){
    
    var dataTableSetting =  $('#table_tag_list').DataTable();
   
    $(document).on('click','#btn-add-tag',function(event){
        event.preventDefault();
        var tagname = $('#tagname').val();
        var tagid = $('#tagid').val();
        if(tagname == '' || tagid == ''){
            Lobibox.notify('error', {
                msg: 'Các trường không được để trống!',
                sound: false
            });
        }else if(isNaN(tagid)){
            Lobibox.notify('error', {
                msg: 'Vị trí tag phải là số!',
                sound: false
            });
        }else{
            $('#form-add-tag').submit();
        }
    });

    $(document).on('submit','#form-add-tag',function(event){
        event.preventDefault();
        $.ajax({
            url: base_url+'/add_tag',
            type: 'POST',
            data: $('#form-add-tag').serialize()
        }).done(function(ketqua) {
            if(ketqua.code == 200){
                Lobibox.notify('success', {
                    msg: 'Đã thêm thành công!',
                    sound: false
                });
                setTimeout(function(){
                    location.reload();
                },2000);
            }else if(ketqua.code == 400){
                Lobibox.notify('error', {
                    msg: 'Tag id đã tồn tại!',
                    sound: false
                });
            }else{
                Lobibox.notify('error', {
                    msg: 'Xảy ra lỗi. Vui lòng thử lại',
                    sound: false
                });
            }
        });
    })

    $(document).on('click','.btn-delete',function(){
        var ele = $(this);
        var id = $(this).data('id');
        Lobibox.confirm({
            msg: "Bạn có muốn xóa tag này không?",
            callback: function ($this, type, ev) {
                if(type == 'yes'){
                    $.ajax({
                        url: base_url+'/del_tag?id='+id,
                        type: 'GET',
                    }).done(function(ketqua) {
                        if(ketqua.code == 200){
                            Lobibox.notify('success', {
                                msg: 'Đã xóa thành công!',
                                sound: false
                            });
                            dataTableSetting
                            .row( ele.parents('tr') )
                            .remove()
                            .draw();
                        }else{
                            Lobibox.notify('error', {
                                sound: false,
                                msg: 'Xảy ra lỗi. Vui lòng thử lại'
                            });
                        }
                    });
                }
            }
        });
    })
    
    $(document).on('click','.btn-edit',function(event){
        event.preventDefault();
        var id = $(this).data('id');
        $.ajax({
            url: base_url+'/get_edit_tag?id='+id,
            type: 'GET',
        }).done(function(ketqua) {
            if(ketqua.code == 200){
                $('#edittagname').val(ketqua.data.name_tag);
                $('#edittagid').val(ketqua.data.id_tag);
                $('#edittagtype').val(ketqua.data.type);
                $('#id').val(ketqua.data.id);
                $('#modal-edit-tag').modal();
            }else if(ketqua.code == 400){
                Lobibox.notify('error', {
                    sound: false,
                    msg: ketqua.msg
                });
            }else{
                Lobibox.notify('error', {
                    sound: false,
                    msg: 'Xảy ra lỗi! Vui lòng thử lại'
                });
            }
        });
        
    })

    $(document).on('click','#btn-edittag',function(event){
        event.preventDefault();
        var tagname = $('#edittagname').val();
        var tagid = $('#edittagid').val();
        if(tagname == '' || tagid == ''){
            Lobibox.notify('error', {
                msg: 'Các trường không được để trống!',
                sound: false
            });
        }else if(isNaN(tagid)){
            Lobibox.notify('error', {
                msg: 'Vị trí tag phải là số!',
                sound: false
            });
        }else{
            $('#form-edit-tag').submit();
        }
    });

    $(document).on('submit','#form-edit-tag',function(event){
        event.preventDefault();
        $.ajax({
            url: base_url+'/edit_tag',
            type: 'POST',
            data: $('#form-edit-tag').serialize()
        }).done(function(ketqua) {
            if(ketqua.code == 200){
                Lobibox.notify('success', {
                    msg: 'Đã sửa thành công!',
                    sound: false
                });
                setTimeout(function(){
                    location.reload();
                },2000);
            }else if(ketqua.code == 400){
                Lobibox.notify('error', {
                    msg: 'Tag id đã tồn tại!',
                    sound: false
                });
            }else{
                Lobibox.notify('error', {
                    msg: 'Xảy ra lỗi. Vui lòng thử lại',
                    sound: false
                });
            }
        });
    })
})