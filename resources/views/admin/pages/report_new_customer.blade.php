@extends('wrapper')
@section('title','Thống kê khách mới')
@section('contents')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Thống kê
        <small>Khách mới</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li class="active">Thống kê</li>
      </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Thời gian thống kê</h3>
            </div>
            <div class="container">
                <div class="row">
                    <div class='col-sm-6'>
                        <div class="form-group">
                            <input type="text" name="datetimes" class="form-control"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table id="table_report_new_customer" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                            <thead>
                                <tr role="row">
                                    <th>Thời gian</th>
                                    <th>Số lượng</th>
                                    <th>Tag được gắn</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                            <td><b>Tổng</b></td>
                            <td><b id="total"></b></td>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <input type="hidden" value="{{csrf_token()}}" id="token">
@endsection
@section('script')
        <script src="{{asset('build/admin/new_customer.js')}}"></script>
@endsection