<?php

namespace App\BasicShop\Wechat;

use App\Models\Customer;
use App\Models\Order;
use Overtrue\Wechat\Menu;
use Overtrue\Wechat\MenuItem;
use Overtrue\Wechat\Payment\Business;
use Overtrue\Wechat\Payment\Order as WechatOrder;
use Overtrue\Wechat\QRCode;
use Overtrue\Wechat\Server;
use Overtrue\Wechat\Auth;
use Overtrue\Wechat\Payment\Notify;
use Overtrue\Wechat\Payment\UnifiedOrder;
use Overtrue\Wechat\Payment;
use QrCode as ImgCode;

/**
 * Class Wechat
 * @package App\Werashop\Wechat
 */
class Wechat
{

    /**
     * @var mixed
     */
    private $_appId;

    /**
     * @var mixed
     */
    private $_secret;

    /**
     * @var mixed
     */
    private $_aesKey;

    /**
     * @var mixed
     */
    private $_token;

    /**
     * @var mixed
     */
    private $_mchId;

    /**
     * @var mixed
     */
    private $_mchSecret;


    /**
     * @return mixed
     */
    public function getAppId()
    {
        return $this->_appId;
    }

    /**
     * @return mixed
     */
    public function getSecret()
    {
        return $this->_secret;
    }

    /**
     * @return mixed
     */
    public function getAesKey()
    {
        return $this->_aesKey;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->_token;
    }

    /**
     * Wechat constructor.
     */
    public function __construct()
    {
        $this->_appId = env('WX_APPID');
        $this->_secret = env('WX_SECRET');
        $this->_aesKey = env('WX_ENCODING_AESKEY');
        $this->_token = env('WX_TOKEN');
        $this->_mchId = env('WX_MCH_ID');
        $this->_mchSecret = env('WX_MCH_SECRET');
    }

    /**
     * 生成菜单数组, 可变更此处配置
     *
     * @return array
     */
    private function generateMenuItems()
    {
        return [
            (new MenuItem("获取积分", 'view', 'http://www.ohmate.cn/redirect/article-index')),
            (new MenuItem("积分商城", 'view', url('/shop/index')))
        ];
    }


    /**
     * @return boolean
     */
    public function generateMenu()
    {
        $menuService = new Menu($this->_appId, $this->_secret);
        $menus = $this->generateMenuItems();

        try {
            $menuService->set($menus);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @return \Overtrue\Wechat\Server
     */
    public function getServer()
    {
        return new Server($this->_appId, $this->_token, $this->_aesKey);
    }

    /**
     * @param string $jump_url
     * @return null|\Overtrue\Wechat\Utils\Bag
     */
    public function authorizeUser($jump_url)
    {
        $appId = $this->_appId;
        $secret = $this->_secret;
        $auth = new Auth($appId, $secret);

        if (!\Session::has('wx_access_token') || !\Session::has('openid')) {
            $result = $auth->authorize(url($jump_url), 'snsapi_base,snsapi_userinfo');
            \Session::put('wx_access_token', $result->get('access_token'));
            \Session::put('wx_openid', $result->get('openid'));
        }
        return $auth->getUser(\Session::get('wx_openid'), \Session::get('wx_access_token'));
    }

    /**
     * @param array $config
     * @return array|string
     */
    public function generatePaymentConfig($config)
    {
        $business = new Business($this->_appId, $this->_secret, $this->_mchId, $this->_mchSecret);

        $wechatOrder = new WechatOrder();
        $wechatOrder->body = $config['body'];
        $wechatOrder->out_trade_no = $config['out_trade_no'];
        $wechatOrder->total_fee = $config['total_fee'];
        $wechatOrder->openid = $config['openid'];
        $wechatOrder->notify_url = $config['notify_url'];

        $unifiedOrder = new UnifiedOrder($business, $wechatOrder);
        $payment = new Payment($unifiedOrder);

        return $payment->getConfig();
    }


    /**
     * @param array $config
     * @return array|string
     */
    public function getCodeUrl($config)
    {
        $business = new Business($this->_appId, $this->_secret, $this->_mchId, $this->_mchSecret);

        $wechatOrder = new WechatOrder();
        $wechatOrder->body = $config['body'];
        $wechatOrder->out_trade_no = $config['out_trade_no'];
        $wechatOrder->total_fee = $config['total_fee'];
        $wechatOrder->openid = $config['openid'];
        $wechatOrder->notify_url = $config['notify_url'];
        $wechatOrder->trade_type = 'NATIVE';

        $unifiedOrder = new UnifiedOrder($business, $wechatOrder);
        $response = $unifiedOrder->getResponse();
        $imgName = 'shop/images/qrcode/' . time() . '_qrcode.png';
        ImgCode::format('png')->size(350)->generate($response['code_url'], public_path($imgName));
        return '/' . $imgName;
    }


    /**
     * @param array $config
     * @return array|string
     */
    public function testGeneratePaymentConfig($config)
    {
        $code = new QRCode($this->_appId, $this->_secret);
        $img = $code->temporary('http://baidu.com')->get('url');
        $imgUrl = ImgCode::format('png')->size(450)->generate($img, public_path('shop/images/qrcode/' . time() . 'qrcode.png'));
        dd($imgUrl);


        $business = new Business($this->_appId, $this->_secret, $this->_mchId, $this->_mchSecret);

        $wechatOrder = new WechatOrder();
        $wechatOrder->body = $config['body'];
        $wechatOrder->out_trade_no = $config['out_trade_no'];
        $wechatOrder->total_fee = $config['total_fee'];
        $wechatOrder->openid = $config['openid'];
        $wechatOrder->notify_url = $config['notify_url'];
        $wechatOrder->trade_type = 'NATIVE';

        $unifiedOrder = new UnifiedOrder($business, $wechatOrder);
        dd([$unifiedOrder->getOrder(), $unifiedOrder->getBusiness(), $unifiedOrder->getResponse(), $unifiedOrder]);
        $payment = new Payment($unifiedOrder);

        return $payment->getConfig();
    }

    /**
     * @return string
     */
    public function paymentNotify()
    {
        $notify = new Notify($this->_appId, $this->_secret, $this->_mchId, $this->_mchSecret);

        $transaction = $notify->verify();

        if (!$transaction) {
            return $notify->reply('FAIL', 'verify transaction error');
        }

        return $notify->reply();
    }

    /**
     * @param Order $order
     * @return string
     */
    protected function generatePaymentBody(Order $order)
    {
        return '' . $order->commodities()->first()->name . '等' . $order->commodities()->get()->count() . '件商品';
    }
}