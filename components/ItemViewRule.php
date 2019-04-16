<?php
namespace app\components;

use yii\web\UrlRuleInterface;
use yii\base\BaseObject;

class ItemViewRule extends BaseObject implements UrlRuleInterface
{

    public function createUrl($manager, $route, $params)
    {
        return false;  // данное правило не применимо
    }

    public function parseRequest($manager, $request)
    {
        $pathInfo = explode('/', $request->getPathInfo());
        if ($pathInfo[0] === 'view') {
            return ['site/view', ['name'=> $pathInfo[1]]];
        }
        return false;
    }
}