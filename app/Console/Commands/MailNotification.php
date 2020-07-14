<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\User;  
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\mail\dailyWeather;


class MailNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'MailNotification:dailyWeather';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daily weather mail service';

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
        $gSub =  DB::table('user_city')
            ->select('*')
            ->get();

        foreach ($gSub as $key => $value) {
            if (Cache::has($value->city)) {
                Mail::to($value->email)->send(new dailyWeather($value->city,Cache::get($value->city, 'Error')));
            }
            else {
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, "api.openweathermap.org/data/2.5/weather?q=".$value->city."&appid=d4ad354a27e4a8011e722e4703072757");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                $result = curl_exec($curl);
                if ($result!=null) {
                    curl_close($curl);
                    $data[] = json_decode($result,true); 
                    if ($data[0]['cod']==404) {
                        Cache::put($value->city, "Not Found", 10000);
                        Mail::to($value->email)->send(new dailyWeather($value->city, "Not Found"));
                    } 
                    elseif ($data[0]['cod']==200) {
                        Cache::put($value->city, $data[0]['main']['temp']-273, 10000);
                        Mail::to($value->email)->send(new dailyWeather($value->city, $data[0]['main']['temp']-273));
                    }
                    
                }
                $data=null;
            }   
        }    
    }
}    

