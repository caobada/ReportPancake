@extends('wrapper')
@section('title','Gửi tin nhắn')
@section('contents')
<section class="content-header">
      <h1>
        Gửi tin nhắn
        <small>Send messages</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li class="active">Gửi tin nhắn</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Send Messages</h3>

            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-9">
                        <form >
                        <div class="form-group">
                            <label>Tùy chọn tags gửi: </label>
                            <select class="form-control" name="option-send" id="option-send" name="tags[]" multiple="multiple">
                                <option disabled="disabled">--Chọn--</option>
                       
                                @foreach($tags as $val)
                                <option value="{{$val->id}}">{{$val->name_tag}}</option>
                                @endforeach
                            </select>
                            <small>Gửi tất cả các người dùng có thời gian tương tác với fanpage không quá 24h  </small  >   
                        </div>
                      
                            

                        <div class="form-group">
                            <label>Nội dung: </label>
                            <textarea class="form-control" name="content" id="content">
                           </textarea>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <input type="hidden" value="{{csrf_token()}}" id="token">
@endsection

@section('script')
    <script src="{{asset('build/admin/send_messages.js')}}"></script>
@endsection