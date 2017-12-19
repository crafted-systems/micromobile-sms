<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 12/13/17
 * Time: 10:24 AM
 */

namespace CraftedSystems\MicroMobile;

use Unirest\Request;
use Unirest\Request\Body;

class MicroMobileSMS
{
    /**
     * Base URL.
     *
     * @var string
     */
    const BASE_URL = 'http://micromobile.co.ke:8098/mobi-text/api/';

    /**
     * Get Balance endpoint.
     *
     * @var string
     */
    const GET_BALANCE_ENDPOINT = 'sms/balance';

    /**
     * settings .
     *
     * @var array.
     */
    protected $settings;

    /**
     * MicroMobileSMS constructor.
     * @param $settings
     * @throws \Exception
     */
    public function __construct($settings)
    {
        $this->settings = (object)$settings;

        if (
            empty($this->settings->service_id) ||
            empty($this->settings->username) ||
            empty($this->settings->password)
        ) {
            throw new \Exception('Please ensure that all MicroMobile configuration variables have been set.');
        }
    }


    /**
     * @param $recipient
     * @param $message
     * @return mixed
     * @throws \Exception
     */
    public function send($recipient, $message)
    {
        if (!is_string($message)) {

            throw new \Exception('The Message Should be a string');
        }

        if (!is_string($recipient)) {
            throw new \Exception('The Phone number should be a string');
        }

        $endpoint = self::BASE_URL . 'sms/' . $this->settings->service_id . '/send';

        $headers = [
            'Accept' => 'application/json',
        ];

        $body = array(
            'addresses' => $recipient,
            'message' => $message,
            'callbackUrl' => $this->settings->call_back_url
        );

        Request::auth($this->settings->username, $this->settings->password);

        $response = Request::post($endpoint, $headers, Body::form($body));

        return $response->body;

    }

    /**
     * @return mixed
     */
    public function getBalance()
    {
        $headers = [
            'Accept' => 'application/json',
        ];

        $endpoint = self::BASE_URL . self::GET_BALANCE_ENDPOINT;

        Request::auth($this->settings->username, $this->settings->password);

        return Request::get($endpoint, $headers)->body->balance;
    }


    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function getDeliveryReports(\Illuminate\Http\Request $request)
    {
        return json_decode($request->getContent());
    }

}