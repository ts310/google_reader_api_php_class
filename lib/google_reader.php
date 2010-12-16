<?php

require_once 'HTTP/Request.php';

/**
 * Google Reader API client class
 * 
 * @author Tsuyoshi Saito
 * @version 1.0
 */
class GoogleReader {
    var $authKey = '';
    var $baseURL = 'http://www.google.com/reader/api/0/';

    public function __construct() {
    }

    /**
     * Connect with google account
     *
     * @param $email String
     * @param $password String
     */
    public function connectWithAccount($email, $password) {
        $url = 'https://www.google.com/accounts/ClientLogin';
        $req = new HTTP_Request($url);
        $req->setMethod(HTTP_REQUEST_METHOD_POST);
        $req->addPostData("service", "reader");
        $req->addPostData("Email", $email);
        $req->addPostData("Passwd", $password);
        $req->addPostData("source", "reader");
        $response = $req->sendRequest();
        if (PEAR::isError($response)) {
            echo $response->getMessage();
        } else {
            $response = $req->getResponseBody();
            $data = explode("\n", trim($response));
            foreach ($data as $item) {
                $params = explode('=', $item);
                if (isset($params[0]) && isset($params[1]) && $params[0] == 'Auth') {
                    $this->authKey = $params[1];
                }
            }
        }
    }

    private function fetchRequestWithURL($url) {
        $url = $this->baseURL . $url;
        $req = new HTTP_Request($url);
        $auth = sprintf("GoogleLogin auth=%s", $this->authKey);
        $req->addHeader("Authorization", $auth);
        $response = $req->sendRequest();
        if (PEAR::isError($response)) {
            echo $response->getMessage();
        } else {
            $body = $req->getResponseBody();
            return $body;
        }
        return false;
    }

    public function fetch($type = null) {
        switch ($type) {
        case 'unread':
            $url = "unread-count?output=json";
            break;
        case 'user-info':
            $url = "user-info?output=json";
            break;
        case 'tags':
            $url = "tag/list?output=json"; 
            break;
        case 'reading-list':
            $url = "stream/contents/user/-/state/com.google/reading-list";
            break;
        case 'subscriptions':
        default:
            $url = "subscription/list?output=json";
            break;
        }
        $data = $this->fetchRequestWithURL($url);
        return json_decode($data, true);
    }
}
