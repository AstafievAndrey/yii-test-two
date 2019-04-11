<?php

return [
    'clientId' => 6938604,
    'secureKey' => 'qBl2B14YFeAHWHR0AGTq',
    'serviceAccessKey' => 'f419d925f419d925f419d9253cf47006c9ff419f419d925a8b43481843625ef2a9021a1',
    'scope' => 'friends,photos,offline',// доступ к друзьям и фотографиям и вечный токен
    'display' => 'page', // форма авторизации в отдельном окне
    'responseType' => 'code',// тип ответа
    'redirectUri' => 'http://localhost/catalog/web/index.php/site/login', // обязательный параметр
    'version' => 5.92,// обязательный параметр версия используемого api
];