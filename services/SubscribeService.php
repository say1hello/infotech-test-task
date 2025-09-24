<?php

namespace app\services;

use yii\base\InvalidConfigException;
use yii\httpclient\Client;
use yii\httpclient\Exception;

class SubscribeService
{
    /**
     * @throws Exception
     * @throws InvalidConfigException
     */
    public static function notify(string $phone, string $authorName, string $bookTitle): void
    {
        $text = "У автора $authorName вышла новая книга '$bookTitle'";

        $client = new Client();
        $client->createRequest()
            ->setMethod('GET')
            ->setUrl('https://smspilot.ru/api.php')
            ->setData([
                'send' => urlencode($text),
                'to' => urlencode($phone),
                'from' => \Yii::$app->params['smspilotFrom'],
                'apikey' => \Yii::$app->params['smspilotApikey'],
                'format' => 'json'
            ])
            ->send();
    }
}