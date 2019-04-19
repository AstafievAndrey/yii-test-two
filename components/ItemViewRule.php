<?php
namespace app\components;

use Yii;
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
        if ($pathInfo[0] === 'list') {
            if(count($pathInfo) === 1) {
                return ['site/list', []];
            }

            return ['site/list', [
                'city' => $pathInfo[1] === 'all-city' ? '' : $pathInfo[1],
                'category' => $pathInfo[2] === 'all-category' ? '' : $pathInfo[2],
            ]];

        }
        return false;
    }
}