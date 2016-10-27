<?php

namespace App\BasicShop\Helper;

use App\Constants\AppConstant;
use App\Models\Customer;
use App\BasicShop\Exceptions\UserNotCachedException;
use App\BasicShop\Exceptions\UserNotSubscribedException;
use App\Models\Member\Member;
use App\Models\Member\MemberBeanLog;
use App\Models\Wx\WxMember;
use App\Models\Wx\WxMemberBeanLog;
use Curl\Curl;

/**
 * Class Helper
 * @package App\BasicShop\Helper
 */
class Helper
{
    /**
     * @return mixed
     * @throws UserNotCachedException
     * @throws UserNotSubscribedException;
     */
    public function getSessionCachedUser()
    {
        if (!$this->hasSessionCachedUser()) {
            throw new UserNotCachedException;
        }
        $user = \Session::get(AppConstant::SESSION_USER_KEY);

        if (is_null($user)) {
            throw new UserNotSubscribedException;
        }
        return $user;
    }

    /**
     * @return bool
     */
    public function hasSessionCachedUser()
    {
        return \Session::has(AppConstant::SESSION_USER_KEY);
    }

    /**
     * @return array
     */
    public function getUser()
    {
        try {
            $user = \Helper::getSessionCachedUser();

            return $user;
        } catch (\Exception $e) {
            abort('404');
        }
    }

    /**
     * @return \App\Models\Customer;
     */
    public function getCustomer()
    {
        try {
            $user = self::getSessionCachedUser();
            $customer = Customer::where('openid', $user['openid'])->firstOrFail();

            return $customer;
        } catch (\Exception $e) {
            abort('404');
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model|static
     * @throws UserNotCachedException
     * @throws UserNotSubscribedException
     */
    public function getCustomerOrFail()
    {
        $user = self::getSessionCachedUser();
        $customer = Customer::where('openid', $user['openid'])->firstOrFail();

        return $customer;
    }

    /**
     * @return \App\Models\Customer|null|static
     */
    public function getCustomerOrNull()
    {
        try {
            $user = self::getSessionCachedUser();
            $customer = Customer::where('openid', $user['openid'])->firstOrFail();

            return $customer;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @param $file
     * @return mixed
     */
    public function qiniuUpload($file)
    {
        $clientName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $newName = md5(date('ymdhis') . $clientName) . "." . $extension;
        $disk = \Storage::disk('qiniu');
        $contents = file_get_contents($file->getRealPath());
        $disk->put($newName, $contents);
        return $disk->getDriver()->downloadUrl($newName);
    }


    /**
     * @param $unionid
     * @return bool
     */
    public function getBeansByUnionid($unionid)
    {
        $curl = new Curl();
        $curl->post('http://www.ohmate.cn/puan/beans-for-union-id', array(
            'unionid' => $unionid
        ));

        if ($curl->error) {
            $curl->close();
            return false;
        } else {
            $data = json_decode($curl->response);
            if ($data->success) {
                return $data->data->beans;
            }
            return false;
        }
    }

    /**
     * @param $unionid
     * @return array
     */
    public function getBeansLogByUnionid($unionid)
    {
        $curl = new Curl();
        //http://www.ohmate.cn/puan/beans-log-for-union-id?unionid=oCrLzv0GsJJ08V3Dh614AckIahu4
        $curl->get('http://www.ohmate.cn/puan/beans-log-for-union-id', array(
            'unionid' => $unionid
        ));

        if ($curl->error) {
            $curl->close();
            return false;
        } else {
            $data = json_decode($curl->response);
            if ($data->success) {
                return $data->data->beans_log;
            }
            return false;
        }
    }

    /**
     * @param $unionid
     * @param $beans
     * @return bool
     */
    public function updateBeansByUnionid($unionid, $beans)
    {
        //http://www.ohmate.cn/puan/update-beans-when-purchase-for-union-id?unionid=123123&beans=1
        $curl = new Curl();
        $curl->post('http://www.ohmate.cn/puan/update-beans-when-purchase-for-union-id', array(
            'unionid' => $unionid,
            'beans' => $beans,
        ));

        if ($curl->error) {
            $curl->close();
            return false;
        } else {
            $data = json_decode($curl->response);
            return $data->success;
        }
    }

    /**
     * @param $phone
     * @return mixed
     */
    public function getBeansByPhone($phone)
    {
        //$mobile = '13151070001';
        //echo $mobile;
        $mobile = $phone;

        $time = time();
        $tmpArr = array($mobile, $time, 'ohmate');
        $tmpStr = implode($tmpArr);
        $token = sha1($tmpStr);
        $param = array('mobile' => $mobile, 'time' => $time, 'token' => $token);

        $curl = new Curl();
        $curl->get('http://wxtnbw.chinacloudsites.cn/guanhuai/index.php/api/get_money', $param);

        if ($curl->error) {
            $curl->close();
            return false;
        } else {
            $data = json_decode($curl->response);
            if($data) {
                if ($data->result == 'ok') {
                    return $data->money;
                } else {
                    throw new \Exception('糖豆维护ing');
                }
            }
            return false;
        }
    }

    /**
     * @param $mobile
     * @param $beans
     * @return  bool
     */
    public function costBeansByPhone($mobile, $beans, $platform)
    {
        $time = time();
        $tmpArr = array($mobile, $time, $beans, 'ohmate');
        $tmpStr = implode($tmpArr);
        $token = sha1($tmpStr);
        $param = array(
            'mobile' => $mobile,
            'time' => $time,
            'money' => $beans,
            'token' => $token
        );
        $base_url = 'http://wxtnbw.chinacloudsites.cn/guanhuai/index.php/api/cost_money';

        $curl = new Curl();
        $curl->get($base_url, $param);

        if ($curl->error) {
            $curl->close();
            return false;
        } else {
            $data = json_decode($curl->response);
            if ($data->result == 'ok') {
                if ($platform == 'member') {
                    $member = Member::where('phone', $mobile)->first();
                    MemberBeanLog::create([
                        'member_id' => $member ? $member->id : 0,
                        'action' => 'cost',
                        'beans' => $beans,
                    ]);
                } else {
                    $wxMember = WxMember::where('phone', $mobile)->first();
                    WxMemberBeanLog::create([
                        'wx_member_id' => $wxMember ? $wxMember->id : 0,
                        'action' => 'cost',
                        'beans' => $beans,
                    ]);
                }
                return true;
            } else {
                return false;
            }
        }
    }


    /**
     * @param $mobile
     * @param $beans
     * @return  bool
     */
    public function receiveBeansByPhone($mobile, $beans)
    {
        $time = time();
        $tmpArr = array($mobile, $time, $beans, 'ohmate');
        $tmpStr = implode($tmpArr);
        $token = sha1($tmpStr);
        $param = array(
            'mobile' => $mobile,
            'time' => $time,
            'money' => $beans,
            'token' => $token
        );
        $base_url = 'http://wxtnbw.chinacloudsites.cn/guanhuai/index.php/api/receive_money?';

        $curl = new Curl();
        $curl->get($base_url, $param);

        if ($curl->error) {
            $curl->close();
            return false;
        } else {
            $data = json_decode($curl->response);
            if ($data->result == 'ok') {
                return true;
            } else {
                return false;
            }
        }
    }
}