<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\DB; 
use Illuminate\Console\Command;
use App\Model\TagsList;
use App\Model\ConfigAutoTag;
use App\Model\Customer;
use App\Model\Shift;
use Carbon\Carbon;
class AutoTag extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'autotag:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try{
            $ds = [];
            $data_tags = TagsList::where('type',0)->get();
            foreach($data_tags as $val){
                array_push($ds,$val->id_tag);
            }
            // for($j = 0;$j<=10;$j++){
                // sleep(5);          
                $i = self::getDS();
                $values = self::getConversation();

                if(isset($values->error_code)){
                    echo $values->message;exit;
                }
                $cons = $values->conversations;
                foreach($cons as $value){
                    if($i >= count($ds)){
                        $i = 0;
                    }
                    if(empty($value->tags)){
                        // action tag
                        // $stt = self::autotag($value->page_id,$value->id,$ds[$i]);
                        // if($stt->success){
                        //     $i++;
                        // }
                        self::saveCustomer($value->id,$value->page_id,0,$value->message_count);
                    }else{
                        $tags = implode('-',$value->tags);
                        self::saveCustomer($value->id,$value->page_id,1,$value->message_count,$value->updated_at,$tags);
                        $tmp = true;
                        foreach($value->tags as $val){
                            if(in_array($val,$ds)){
                                $tmp = false;
                            }
                        }
                        if($tmp){
                        // action tag
                        // $stt = self::autotag($value->page_id,$value->id,$ds[$i]);
                        //     if($stt->success){
                        //         $i++;
                        //     }
                        }
                    }
                }
                $result = self::updateDS($i);
                if($result){
                    echo "Thành công!";
                }
            // }
        }catch(Exception $ex){
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
    function getConversation($token = null){
        $ch = curl_init();
        $pages = ConfigAutoTag::first();
        if($pages && !empty($pages->page_id)){
            if(strpos($pages->page_id, '|') !== false) {
                $page = explode('|',$pages->page_id);
            }else{
                $page = $pages->page_id;
            }
        }else{
            $page = '203805870401023';
        }
        if(is_array($page) && count($page) > 1){
            $page_str = '';
            for($i = 0;$i<count($page);$i++){
                if($i == 1){
                    $page_str .= '&';
                }
                $page_str .='pages['.$page[$i].']=0';
            }
        }
        if($token == null){
            $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1aWQiOiIzOGVkMDZiNy1hMzM4LTQxZjAtYjcyZC0wMGE4MDExZTdjNmUiLCJpYXQiOjE1NjU4NDUzMTcsImZiX25hbWUiOiJDYW8gQmFkYSIsImZiX2lkIjoiNzIyMjY4NzY3OTEwOTkwIiwiZXhwIjoxNTczNjIxMzE3fQ.OrMnQa--TuY4OoZ_P5yeD3LJDZHQtP6zI9iDwbXt5do';
        }
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => 'https://pages.fm/api/v1/conversations?'.$page_str.'&unread_first=true&type=INBOX&mode=null&tags=%22ALL%22&access_token='.$token
        ]);
        $resp = curl_exec($ch);
        $values = json_decode($resp);
        curl_close($ch);
        return $values;
    }

    function autotag($page_id,$id,$ds,$token = null){
        $post_field = [
            'tag_id'=> $ds,
            'value' => 1
        ];
        if($token == null){
            $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1aWQiOiIzOGVkMDZiNy1hMzM4LTQxZjAtYjcyZC0wMGE4MDExZTdjNmUiLCJpYXQiOjE1NjU4NDUzMTcsImZiX25hbWUiOiJDYW8gQmFkYSIsImZiX2lkIjoiNzIyMjY4NzY3OTEwOTkwIiwiZXhwIjoxNTczNjIxMzE3fQ.OrMnQa--TuY4OoZ_P5yeD3LJDZHQtP6zI9iDwbXt5do';
        }
        $ch = curl_init();
        //post
        curl_setopt($ch, CURLOPT_URL, 'https://pages.fm/api/v1/pages/'.$page_id.'/conversations/'.$id.'/toggle_tag?access_token='.$token);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$post_field );
        $resp = curl_exec($ch);
        $values = json_decode($resp);
        curl_close($ch);
        return $values;
    }

    function updateDS($ds){
        $data = ConfigAutoTag::first()->update(['position'=>$ds]);
    }

    function getDS(){
        $data = ConfigAutoTag::first();
        if(!empty($data)){
            return $data->position;
        }else{
            return 0;
        }
    }

    function saveCustomer($uuid,$page_id,$type,$num_msg,$update_at = null,$tagid = null){
        $data = [
            'page_id' =>$page_id,
            'type' => $type,
            'count_message' => $num_msg,
            'id_tags' => $tagid
        ];
        if($type == 0){
            $commit = Customer::firstOrCreate(['uuid'=>$uuid,'type'=>0],$data);
        }else{ 
            $day_update = Carbon::parse($update_at)->format('Y-m-d');
        
            if(Carbon::now()->format('Y-m-d') == $day_update){
                $time_update = Carbon::parse($update_at)->addHours(7)->format('H:i:s');
                $updated_at = Carbon::parse($day_update.' '.$time_update)->format('Y-m-d H:i:s');
                $shift_at = Shift::where('timestart','<=',$time_update)
                ->where('timeend','>',$time_update)->first();
         
                $time_via_shift_start = Carbon::now()->format('Y-m-d') .' '.$shift_at->timestart;
                $time_via_shift_end = Carbon::now()->format('Y-m-d') .' '.Carbon::parse($shift_at->timeend)->subSeconds(1)->format('H:i:s');
           
                 $customer_check = Customer::where('uuid',$uuid)
                ->whereBetween('updated_at',[$time_via_shift_start,$time_via_shift_end])
                ->first();
               
            
                if(!isset($customer_check)){
                    $data['uuid'] = $uuid;
                    $data['updated_at'] = $updated_at;
                    $commit = Customer::create($data);
                }
            }
        }
        if(isset($commit)&& $commit){
            echo 1;
        }else{
            echo 0;
        }
    }
}
