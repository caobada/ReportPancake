<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\TagsList;
use Illuminate\Support\Facades\DB; 
use App\Model\Customer;
use Validator;
use App\Model\Shift;
use Carbon\Carbon;
class AdminController extends Controller
{
    //
    public function setting_admin(){
        $tagslist = TagsList::all();
        return view('admin.pages.setting',['tagslist'=>$tagslist]);
    }
    public function add_tag(Request $request){
        try{
            $tag = TagsList::where('id_tag',$request->tagid)->first();
            if($tag){
                return self::JsonExport(400,'Tồn tại Tag');
            }else{
                DB::beginTransaction();
                $data = [
                    'name_tag' => $request->tagname,
                    'id_tag' => $request->tagid,
                    'type' => $request->tagtype
                ];
                $commit = TagsList::create($data);
                if($commit){
                    DB::commit();
                    return self::JsonExport(200,'Success');
                }else{
                    DB::rollBack();
                    return self::JsonExport(500,'Server Internal Error');
                }
            }
        }catch(\Exception $ex){
            DB::rollBack();
            return self::JsonExport(500,'Server Internal Error');
        }
    }
    public function del_tag(Request $request){
        try{
            DB::beginTransaction();
            $commit = TagsList::where('id',$request->id)->delete();
            if($commit){
                DB::commit();
                return self::JsonExport(200,'Success');
            }else{
                DB::rollBack();
                return self::JsonExport(500,'Server Internal Error');
            }
        }catch(\Exception $ex){
            DB::rollBack();
            return self::JsonExport(500,'Server Internal Error');
        }
    }
    public function get_edit_tag(Request $request){
        try{
            $data = TagsList::where('id',$request->id)->first();
            if($data){
                return self::JsonExport(200,'success',$data);
            }else{
                return self::JsonExport(400,'Không có dữ liệu',[]);
            }
        }catch(\Exception $ex){
            return self::JsonExport(500,'Server Internal Error');
        }
    }

    public function edit_tag(Request $request){
        try{
            $tag_check =  TagsList::where('id_tag',$request->tagid)
            ->where('id','!=',$request->id)->first();
            if($tag_check){
                return self::JsonExport(400,'Tag đã tồn tại');
            }else{
                DB::beginTransaction();
                $data_upd = [
                    'name_tag' => $request->tagname,
                    'id_tag' => $request->tagid,
                    'type' => $request->tagtype
                ];
                $commit = TagsList::where('id',$request->id)
                ->update($data_upd);
                if($commit){
                    DB::commit();
                    return self::JsonExport(200,'success');
                }else{
                    DB::rollBack();
                    return self::JsonExport(500,'Server Internal Error');
                }
            }
        }catch(\Exception $ex){
            DB::rollBack();
            return self::JsonExport(500,'Server Internal Error');
        }
    }

    public function report_new_customer(){
        return view('admin.pages.report_new_customer');
    }

    public function new_customer_ajax(Request $request){
        try{
            $from = Carbon::parse($request->from)->format('Y-m-d H:i:s');
            $to = Carbon::parse($request->to)->format('Y-m-d H:i:s');
            $ab_hour = Carbon::parse($request->to)->diffInHours(Carbon::parse($request->from));
            $total = Customer::where('type',0)
            ->whereBetween('updated_at',[$from,$to])
            ->orderBy('updated_at')
            ->count();
          
            
            if($ab_hour <= 24){
                $num_dev = 2;
                $ab_hour_dev = $ab_hour/$num_dev;
                $ab_hour_dev_sub = $ab_hour%$num_dev;
            }else{
                $num_dev = 4;
                $ab_hour_dev = $ab_hour/$num_dev;
                $ab_hour_dev_sub = $ab_hour%$num_dev;
            }
             $day_tmp =  Carbon::parse($request->from);
             $ab_arr= [];
            for($i=0;$i<$ab_hour_dev;$i++){
                $val_db = $day_tmp;
                $ab_arr[$i] = Carbon::parse($val_db)->format('Y-m-d H:i:s');
                $day_tmp->addHours($num_dev);
            }
            if($ab_hour_dev_sub =! 0){
                $ab_arr[] = Carbon::parse($request->to)->format('Y-m-d H:i:s');
            }
            // return Customer::whereBetween('updated_at',[$from,$to])->get();
            $name_tags =  TagsList::where('type',0)->get();
            $name_tag = [];
            foreach($name_tags as $value){
                $name_tag[$value->id_tag] = $value->name_tag;
            }
        
            if(!empty($ab_arr)){
                $data = [];
                for($i=0;$i<count($ab_arr);$i++){
                    if($i+1 != count($ab_arr)){
                        $from_ab = $ab_arr[$i];
                        $to_ab = $ab_arr[$i+1];
                        $data_ab  = Customer::where('type',0)
                        ->select(DB::raw('count(*) as count, group_concat(id_tags separator  "-") as tags'))
                        ->whereBetween('updated_at',[$from_ab,$to_ab])
                        ->get();
                        $tags = $data_ab[0]->tags;
                        $count = $data_ab[0]->count;
                        $tags_name = [];
                        if($tags != null){
                            if(strpos($tags, '-') !== false) {
                                $tags = explode('-',$tags);
                                $tags = array_unique($tags);
                                foreach($tags as $val){
                                    $tags_name[] = $name_tag[$val]; 
                                }
                                
                            } else{
                                $tags_name[] = $name_tag[$tags]; 
                            }
                            $tags = implode(',',$tags_name);
                        }
                        $result['count'] = $count;
                        $result['tags'] = $tags_name;
                        array_push($data,[$from_ab.' tới '.$to_ab => $result]);
                    }
                }
            }
            array_push($data,['total' => $total]);
            return self::JsonExport(200,'success',($data));
    
            // return ($ab_arr);exit;

            
            // foreach($data as $val){

            // }
            if(!empty($data)){ 
                // return self::JsonExport(200,'success',$data);
            }
        }catch(\Exception $ex ){
            // return self::JsonExport(500,'Server Internal Error');
            return $ex->getMessage();
        }
    }

    public function report_staff(){
        // $post_field = [
        //     'action'=> 'reply_inbox',
        //     'message' => 'Quân Mỹ!',
        //     'thread_key' => 't_1397230680414792'
        // ];
        // // if($token == null){
        // //     $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1aWQiOiIzOGVkMDZiNy1hMzM4LTQxZjAtYjcyZC0wMGE4MDExZTdjNmUiLCJpYXQiOjE1NjU4NDUzMTcsImZiX25hbWUiOiJDYW8gQmFkYSIsImZiX2lkIjoiNzIyMjY4NzY3OTEwOTkwIiwiZXhwIjoxNTczNjIxMzE3fQ.OrMnQa--TuY4OoZ_P5yeD3LJDZHQtP6zI9iDwbXt5do';
        // // }
        // $ch = curl_init();
        // //post
        // curl_setopt($ch, CURLOPT_URL, 'https://pages.fm/api/v1/pages/203805870401023/conversations/203805870401023_2530474070319250/messages?access_token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1aWQiOiIzOGVkMDZiNy1hMzM4LTQxZjAtYjcyZC0wMGE4MDExZTdjNmUiLCJpYXQiOjE1Njc5MzUyOTQsImZiX25hbWUiOiJDYW8gQmFkYSIsImZiX2lkIjoiNzIyMjY4NzY3OTEwOTkwIiwiZXhwIjoxNTc1NzExMjk0fQ.hZpS_Tg_P3EGmZ8REug5CSCp-GSrb84_I4MJN0sifvM');
        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        // curl_setopt($ch, CURLOPT_POSTFIELDS,$post_field );
        // $resp = curl_exec($ch);
        // $values = json_decode($resp);
        // curl_close($ch);
        // return $values;
        $shift = Shift::all();
        return view('admin.pages.report_staff',['shift'=>$shift]);

    }
    public function report_staff_ajax(Request $request){
        $date = Carbon::parse($request->date)->format('Y-m-d');
        $now = Carbon::now()->format('Y-m-d');
        if($date > $now) {
            return self::JsonExport(401,'Không có dữ liệu');
        }
        $shift = Shift::find($request->shift);
        $staff = TagsList::where('type',0)->get();
        $from_time = $date.' '. $shift->timestart;
        $to_time = $date.' '.$shift->timeend;
        $to_time = Carbon::parse($to_time)->subSeconds(1)->format('Y-m-d H:i:s');
        $customer = Customer::whereBetween('updated_at',[$from_time,$to_time])->get();
        $customer_of_staff = [];
        foreach($staff as $val){
            $staff = $val->id_tag;
            $list_customer = [];
            $list_customer_boolean = [];
            foreach($customer as $v){
                if(strpos($v->id_tags, '-') !== false) {
                    $id_tags = explode('-',$v->id_tags);
                } else {
                    $id_tags = (array)$v->id_tags;
                }
                if(in_array($staff,$id_tags)){
                    array_push($list_customer,['id'=>$v->id,'uuid' => $v->uuid]);
                    array_push($list_customer_boolean,$v->id);
                }
            }
            foreach($list_customer as $v){
                $customer_tmp = Customer::where('uuid',$v['uuid'])->orderBy('id','asc')->get();
                if(count($customer_tmp) > 1){
                    for($i= count($customer_tmp)- 1;$i>=0;$i--){
                        if($i != 0){
                            $data[$customer_tmp[$i]['id']] = $customer_tmp[$i]['count_message'] - $customer_tmp[$i-1]['count_message'];
                        }else{
                            $data[$customer_tmp[$i]['id']] = $customer_tmp[$i]['count_message'];
                        }
                    }
                    $find_key = max($data);
                    $boolean_key = array_search($find_key,$data);
                    if(in_array($boolean_key,$list_customer_boolean) === false){
                        unset($list_customer_boolean[array_search($v['id'],$list_customer_boolean)]);
                        $list_customer_boolean = array_values($list_customer_boolean);
                    }
                }
            }
            $customer_of_staff[$val->name_tag] = $list_customer_boolean;
        }

        // get được id của từng dược sĩ
        $data = [];
        foreach($customer_of_staff as $key => $value){

            $tag_list_bad = TagsList::where('type',1)->pluck('id_tag')->toArray();
            $customer_bad = [];
            
            foreach($value as $val){
         
                $customer = Customer::where('id',$val)->first();
       
                if(strpos($customer->id_tags, '-') !== false) {
                    $id_tags = explode('-',$customer->id_tags);
                } else {
                    $id_tags = (array)$customer->id_tags;
                }
                $have_bad_tag = false;
                foreach($id_tags as $v){
                    if(in_array($v,$tag_list_bad)){
                        $have_bad_tag = true;
                    }
                }
                if($have_bad_tag === false){
                    $check_next_customer = Customer::where('uuid',$customer->uuid)
                    ->where('id','>',$customer->id)->first();
                    if($check_next_customer){
                        if(strpos($check_next_customer->id_tags, '-') !== false) {
                            $id_tags = explode('-',$check_next_customer->id_tags);
                        } else {
                            $id_tags = (array)$check_next_customer->id_tags;
                        }
                        $check_next_bad = false;
                        foreach($id_tags as $v){
                            if(in_array($v,$tag_list_bad)){
                                $check_next_bad = true;
                            }
                        }
                        if($check_next_bad){
                            $customer_bad[] = $val;
                        }
                    }else{
                        $url_customer = self::GetInfoCustomer($customer->uuid,$customer->page_id);
                        if($url_customer != false){
                            $id_tags = json_decode($url_customer)->tags;
                            $check_next_bad = false;
                            foreach($id_tags as $v){
                                if(in_array($v,$tag_list_bad)){
                                    $check_next_bad = true;
                                }
                            }
                            if($check_next_bad){
                                $customer_bad[] = $val;
                            }
                        }
                    }
                } 
            }
            $total_customer = count($value);
            $total_customer_bad = count($customer_bad);
            $total_gub = $total_customer - $total_customer_bad ;
            array_push($data,['name'=>$key,'count'=>$total_customer,'count_bad'=>$total_customer_bad,'gub'=>$total_gub]);
        }
        return self::JsonExport(200,'success',$data);
    }

    public function send_messages(){
        $tag_list_customer = TagsList::where('type',1)->get();
        return view('admin.pages.send_messages',['tags'=>$tag_list_customer]);
    }
}
