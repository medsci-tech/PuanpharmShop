<?php


namespace App\BasicShop\Message;

use App\Models\MessageVerify;

/**
 * Class LuosimaoMessageSender
 * @package App\Werashop\Message
 */
class LuosimaoMessageSender implements MessageSenderInterface
{
    /**
     * @param int $start
     * @param int $end
     * @return string
     */
    public function generateMessageVerify($start = 000000, $end = 999999)
    {
        return sprintf('%06d', random_int($start, $end));
    }

    /**
     * @param $phone
     * @return boolean
     */
    public function createMessageVerify($phone)
    {
        $message_verify_number = mt_rand(100000, 999999);
        $message = '验证码：' . $message_verify_number . '【' . \Config::get('shop.message_sign') . '】';
        $res = $this->sendMessageVerify($phone, $message);
        //$res = '{"error":0,"msg":"ok"}';
        $res = json_decode($res);
        if ($res->error == 0) {
            $messageVerify = new MessageVerify();
            $messageVerify->phone = $phone;
            $messageVerify->code = $message_verify_number;
            $messageVerify->save();
            return $messageVerify->id;
        } else {
            return false;
        }

    }


    /**
     * @param $phone
     * @param $verify
     * @return int
     */
    public function sendMessageVerify($phone, $message)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://sms-api.luosimao.com/v1/send.json");

        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, 'api:key-' . env('SMS_KEY'));
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            array('mobile' => $phone, 'message' => $message));
        $res = curl_exec($ch);
        curl_close($ch);

        return $res;
    }


    /**
     * @param $phone int
     * @param $verify int
     * @return boolean
     */
    public function checkVerify($phone, $code)
    {
        $array = array(
            'phone' => $phone,
            'code' => $code,
            'status' => 0,
            //'created_at' => ['>', Carbon::now()->addMinute('-15')->toDateTimeString()]
        );
        $row = MessageVerify::where($array)->first();
        if ($row) {
            $row->status = 1;
            $row->save();
            return true;
        }
        return false;
    }
}