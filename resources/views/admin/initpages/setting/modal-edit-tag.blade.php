
<!-- Modal -->
<div class="modal fade" id="modal-edit-tag" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Sửa tag</h4>
      </div>
      <div class="modal-body">
            <form id="form-edit-tag">
                @csrf
                <div class="form-group">
                    <input class="form-control" name="tagname" id="edittagname" type="text" placeholder="Tên Tag" required>
                </div>
                <div class="form-group">
                    <input class="form-control" name="tagid" id="edittagid" type="text" placeholder="Ví trị Tag ID" required>
                </div>
                <input type="hidden" id="id" name="id">
                <div class="form-group">
                    <select class="form-control" name="tagtype" id="edittagtype">
                        <option value="0">Tag Dược Sĩ</option>
                        <option value="1">Tag Khách không chất lượng</option>
                        <option value="2">Tag Khách Hàng</option>
                        <option value="3">Tag Gửi tin nhắn</option>
                    </select>
                </div>
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
        <button type="button" class="btn btn-primary" id="btn-edittag">Lưu chỉnh sửa</button>
      </div>
    </div>
  </div>
</div>