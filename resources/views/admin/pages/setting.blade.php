@extends('wrapper')
@section('title','Cài đặt')
@section('contents')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Cài đặt
        <small>Danh sách Tags</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li class="active">Cài đặt</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Danh sách Tag</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="table_tag_list" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                <thead>
                                    <tr role="row">
                                        <th>id</th>
                                        <th>Tên Tag</th>
                                        <th>ID Tag</th>
                                        <th>Loại tag</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tagslist as $val)
                                    <tr role="row" class="odd">
                                        <td class="sorting_1">{{$val->id}}</td>
                                        <td>{{$val->name_tag}}</td>
                                        <td>{{$val->id_tag}}</td>
                                        <td>
                                            @if($val->type ==0) Tag Dược Sĩ
                                            @elseif($val->type == 1) Tag Khách không chất lượng
                                            @elseif($val->type == 2) Tag Khách Hàng
                                            @else Tag Gửi tin nhắn
                                            @endif
                                        </td>
                                        <td>
                                        <a class="btn btn-edit" data-id="{{$val->id}}">
                                            <i class="fa fa-edit"></i> Sửa
                                        </a>
                                        <a class="btn btn-delete" data-id="{{$val->id}}">
                                            <i class="fa fa-trash-o"></i> Xóa
                                        </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Thêm Tag</h3>
                    </div>
                    <div class="box-body">
                        <form id="form-add-tag">
                        @csrf
                            <div class="form-group">
                                <input class="form-control" name="tagname" id="tagname" type="text" placeholder="Tên Tag" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" name="tagid" id="tagid" type="text" placeholder="Ví trị Tag ID" required>
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="tagtype">
                                    <option value="0">Tag Dược Sĩ</option>
                                    <option value="1">Tag không chất lượng</option>
                                    <option value="2">Tag Khách Hàng</option>
                                    <option value="3">Tag Gửi tin nhắn</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success" id="btn-add-tag">Thêm Tag</button>
                            </div>
                        </form>
                    </div>
                <!-- /.box-body -->
                </div>
            </div>
        </div>
    </section>

    @include('admin.initpages.setting.modal-edit-tag')
@endsection
@section('script')
    <script src="{{asset('build/admin/setting.js')}}"></script>
@endsection