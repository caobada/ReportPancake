@extends('wrapper')
@section('title','Thống kê khách hàng')
@section('contents')
 <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Thống kê
        <small>Dược sĩ</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li class="active">Thống kê dược sĩ</li>
      </ol>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Thời gian thống kê</h3>
            </div>
            <div class="container">
                <div class="row">
                    <div class='col-md-3'>
                    <label>Chọn ngày:</label>
                        <div class="form-group">
                            <input type="text" id="datetimes" name="datetimes" class="form-control"/>
                        </div>
                    </div>
                    <div class='col-md-3'>
                    <label></label>
                        <div class="form-group">
                            <input type="button" id="btn-report" name="submit" class="btn btn-success" value="Thống kê"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table id="table_report_customer" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                            <thead>
                                <tr role="row">
                                    <th>Loại Khách</th>
                                    <th>Số lượng</th>
                                </tr>
                            </thead>
                            <tbody>
                                   
                            </tbody>
                            <tfoot >
                            <td><b>Tổng</b></td>
                            <td id="total"><b id="total"></b></td>
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
        <script src="{{asset('build/admin/report_customer.js')}}"></script>
@endsection