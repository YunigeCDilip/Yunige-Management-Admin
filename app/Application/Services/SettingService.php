<?php

namespace App\Application\Services;

use Throwable;
use AWS\CRT\HTTP\Message;
use App\Models\Localization;
use App\Constants\MessageResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class SettingService extends Service
{
    public function __construct(
    ){
    }

    /**
     * Return required data for view.
     *
     * @return  Response
     */
    public function localization()
    {
        try {
            $data = Localization::all();

            return $data;
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);
        }
    }
      
    /**
     * update settings.
     *
     * @return Response
     */
    public function update($request)
    {
        try {
            Localization::select('*')->update(['active_status' => false]);
            $data = Localization::find($request->id);
            $data->active_status = true;
            $data->save();
            $this->changeCountry($data);
            Session::put('locale', $data->locale);

            return $this->responseOk(null, MessageResponse::SETTING_UPDATED);
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['_trace' => $e->getTraceAsString()]);

            return $this->responseError();
        }
    }

    /**
     * @param Localization $locale
     * 
     * @return void
     */
    private function changeCountry(Localization $locale)
    {
        $countries = Localization::all();
        foreach($countries as $c)
        {
            if($locale->locale == 'en'){
                switch($c->locale){
                    case 'en' :
                        $lang = 'English';
                        break;
                    case 'ja' :
                        $lang = 'Japanese';
                        break;
                    default :
                        $lang = 'Korean';
                        break;
                }
            }

            if($locale->locale == 'ja'){
                switch($c->locale){
                    case 'en' :
                        $lang = 'えいご';
                        break;
                    case 'ja' :
                        $lang = '日本語';
                        break;
                    default :
                        $lang = '韓国語';
                        break;
                }
            }

            if($locale->locale == 'ko'){
                switch($c->locale){
                    case 'en' :
                        $lang = '영어';
                        break;
                    case 'ja' :
                        $lang = '일본어';
                        break;
                    default :
                        $lang = '한국어';
                        break;
                }
            }

            $c->country = $lang;
            $c->save();
        }
    }
}
