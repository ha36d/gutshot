<?php
namespace Gutshot\Api;

use Phalcon\Mvc\User\Component;

class Api extends Component
{
    protected $params, $curl, $response, $obj;

    public function poker($params)
    {
        // Settings
        $apiSettings = $this->config->poker_api;

        global $url, $pw;
        $params['Password'] = $apiSettings->password;
        $params['JSON'] = 'Yes';
        $curl = curl_init($apiSettings->url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_VERBOSE, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curl);
        if (curl_errno($curl)) $obj = (object) array('Result' => 'Error', 'Error' => curl_error($curl));
        else if (empty($response)) $obj = (object) array('Result' => 'Error', 'Error' => 'Connection failed');
        else $obj = json_decode($response);
        curl_close($curl);
        return $obj;
    }

}