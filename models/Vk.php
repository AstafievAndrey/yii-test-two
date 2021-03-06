<?php

namespace app\models;
use Yii;
use linslin\yii2\curl;

class Vk extends \yii\base\BaseObject 
{
    private $_clientId;
    private $_secureKey;
    private $_serviceAccessKey;
    private $_scope; // доступ к друзьям и фотографиям и вечный токен
    private $_display; // форма авторизации в отдельном окне
    private $_responseType; // тип ответа
    private $_redirectUri; // обязательный параметр
    private $_version; // обязательный параметр версия используемого api

    private $_curl;

    private function setConfig() {
        $config = Yii::$app->params['vkConfig'];
        $this->_clientId = $config['clientId'];
        $this->_secureKey = $config['secureKey'];
        $this->_serviceAccessKey = $config['serviceAccessKey'];
        $this->_scope = $config['scope'];
        $this->_display = $config['display'];
        $this->_responseType = $config['responseType'];
        $this->_redirectUri = $config['redirectUri'];
        $this->_version = $config['version'];
    }

    private function getLinkAccessToken(string $code): string {
        return 'https://oauth.vk.com/access_token?client_id='.$this->_clientId
            .'&client_secret='.$this->_secureKey
            .'&redirect_uri='.$this->_redirectUri 
            .'&code='.$code;
    }

    public function __construct() {
        parent::__construct();
        $this->setConfig();
        $this->_curl = new curl\Curl();
    }

    public function getAccessToken(string $code): object {
        $response = $this->_curl->get($this->getLinkAccessToken($code));
        return json_decode($response);
    }

    public function getUser(int $user_id, string $token): object {
        return json_decode(
                $this->_curl->get(
                    'https://api.vk.com/method/users.get?user_ids='.$user_id
                        .'&fields=bdate'.
                        '&access_token='.$token
                        .'&v='.$this->_version
                )
            );
    }
    

    public function setUri (string $uri): void {
        $this->_redirectUri = $this->_redirectUri.$uri;
    }

    public function getLink(): string {
        return urldecode('https://oauth.vk.com/authorize?client_id='.$this->_clientId
            .'&display='.$this->_display
            .'&redirect_uri='.$this->_redirectUri
            .'&scope='.$this->_scope
            .'&response_type='.$this->_responseType
            .'&v='.$this->_version);
    }
}
