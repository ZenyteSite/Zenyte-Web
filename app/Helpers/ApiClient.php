<?php

namespace App\Helpers;

class ApiClient {

    public function attemptLogin($ux, $px) {
        $login = [
            'username' => $ux,
            'password' => $px
        ];

        $response = $this->submitPostRequest("account/login/", json_encode($login));
        return $response === 'true' ? true : false;
    }

    public function register($username, $password) {
        $attempt = [
            'username' => $username,
            'password' => $password,
            'ip'       => $_SERVER["HTTP_CF_CONNECTING_IP"]
        ];
    }

    public function getPlayerCountFull() {
        return $this->submitGetRequest("worldinfo/all/count/");
    }

    public function getGamemode($user) {
        return $this->submitGetRequest("hiscores/user/$user/gamemode");
    }

    public function getPlayerCount($world) {
        return $this->submitGetRequest("worldinfo/world/{$world}/count/");
    }

    public function submitPostRequest($endpoint, $postData) {
        $ch = curl_init();

        // auth header key, enable when implemented
        curl_setopt($ch, CURLOPT_URL,'https://api.zenyte.com/'.$endpoint);
        curl_setopt($ch, CURLOPT_POST, 1);

        if ($postData != null)
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization: Bearer api-token'));
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $server_output = curl_exec($ch);
        curl_close ($ch);
        return $server_output;
    }

    public function submitGetRequest($endpoint, $data = null) {
        $ch = curl_init();
        $url = 'https://api.zenyte.com/'.$endpoint;

        // auth header key, enable when implemented
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization: Bearer api-token'));

        if ($data != null)
            $url =  $url.'?'.http_build_query($data);

        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $server_output = curl_exec($ch);
        curl_close ($ch);
        return json_decode($server_output, true);
    }

}

