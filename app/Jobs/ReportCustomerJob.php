<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Carbon\Carbon;
use App\Model\TagsList;
use App\Model\Customer;

class ReportCustomerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $date;
    public function __construct($date)
    {
        //
        $this->date = $date;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        file_put_contents('report.txt','r');
        $start = Carbon::parse($this->date)->startOfday();
        $end = Carbon::parse($this->date)->endOfday();
        $tag_customer = TagsList::where('type',2)->get();
        foreach($tag_customer as $val){
            $data[$val->name_tag] = 0;
        }
        
      $time_start = microtime(true);
       //  return $start.$end;
       $customer = Customer::whereBetween('updated_at',[$start,$end])
       ->where('type',0)
       ->get();
       $i_bad = 0;
       if(count($customer) > 0){
           foreach($customer as $val){
               $customer_check = Customer::where('uuid',$val['uuid'])
               ->where('type',1)
               ->where('id','>',$val['id'])
               ->first();
               if($customer_check){
                   // tồn tại ở ca sau
                    $tags = $customer_check->id_tags;
                   if(strpos($tags, '-') !== false) {
                       $id_tags = explode('-',$tags);
                   } else {
                       $id_tags = (array)$tags;
                   }
                   foreach($tag_customer as $k){
                        foreach($id_tags as $v){
                            if($k == $v){
                                $data[$k->name_tag]++;
                            }
                        }
                   }
                   
               }else{
                    // phải get từ URL
                    $url_cus =  self::GetInfoCustomer($val->uuid,$val->page_id);
                    $id_tags = json_decode($url_cus)->tags;
                    foreach($tag_customer as $k){
                        foreach($id_tags as $v){
                            if($k->id_tag == $v){
                                $data[$k->name_tag]++;
                            }
                        }
                    }
               }
           }
       }
       $end = microtime(true) - $time_start;
       file_put_contents('report.txt', json_encode($data));
    }

    static function GetInfoCustomer($uuid,$page_id){
        // if($token == null){
            $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1aWQiOiIzOGVkMDZiNy1hMzM4LTQxZjAtYjcyZC0wMGE4MDExZTdjNmUiLCJpYXQiOjE1NjU4NDUzMTcsImZiX25hbWUiOiJDYW8gQmFkYSIsImZiX2lkIjoiNzIyMjY4NzY3OTEwOTkwIiwiZXhwIjoxNTczNjIxMzE3fQ.OrMnQa--TuY4OoZ_P5yeD3LJDZHQtP6zI9iDwbXt5do';
        // }
       
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => 'https://pages.fm/api/v1/pages/'.$page_id.'/conversations/'.$uuid.'?access_token='.$token
        ]);
        $resp = curl_exec($ch);
        $values = ($resp);
        curl_close($ch);
        return $values;
    }
}
