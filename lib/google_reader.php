<?php

require_once 'HTTP/Request.php';

class GoogleReader {

    var $authKey = '';
    var $baseURL = 'http://www.google.com/reader/api/0/';

    public function __construct() {
        $url = 'https://www.google.com/accounts/ClientLogin';
        $req = new HTTP_Request($url);
        $req->setMethod(HTTP_REQUEST_METHOD_POST);
        $req->addPostData("service", "reader");
        $req->addPostData("Email", GOOGLE_EMAIL);
        $req->addPostData("Passwd", GOOGLE_PASSWD);
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

    public function fetchRequestWithURL($url) {
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
}
