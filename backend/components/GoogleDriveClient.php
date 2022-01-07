<?php

namespace backend\components;

use Yii;
use yii\base\Component;
use yii\httpclient\Client;
use yii\web\BadRequestHttpException;

class GoogleDriveClient extends Component
{
    private $access_token;

    private $refresh_token;

    const CREDENTIALS_FILE_PATH = "../credentials.json";
    
    /**
     * http client
     *
     * @var \yii\httpclient\Client
     */
    private $client;
    
    public function __construct()
    {
        $this->client = new Client();
        $credentials = json_decode(file_get_contents(self::CREDENTIALS_FILE_PATH));
        $this->access_token = $credentials->access_token;
        $this->refresh_token = $credentials->refresh_token;
    }
        
    /**
     * listFiles
     *
     * @return array
     * 
     * @throws \yii\web\BadRequestHttpException
     */
    public function listFiles()
    {
        $access_token = $this->access_token;
        $response = $this->client->get('https://www.googleapis.com/drive/v2/files', [], [
            'Authorization' => "Bearer $access_token"
        ])
        ->send();
    
        if ($response->statusCode == 401) {
            $this->refreshTokenFromAccessToken();
            $this->listFiles();
        }

        if ($response->statusCode == 200) {
            return $response->data['items'];
        }

        throw new BadRequestHttpException("Error getting the files.");
    }

    private function refreshTokenFromAccessToken()
    {
        $response = $this->client->post('https://oauth2.googleapis.com/token', [
            "client_id" => Yii::$app->params['google_client_id'],
            "client_secret" => Yii::$app->params['google_client_secret'],
            "refresh_token" => $this->refresh_token,
            "grant_type" => "refresh_token",
            "access_type" => "offline"
        ], [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ])->send();

        if ($response->statusCode) {
            $data = $response->data + ['refresh_token' => $this->refresh_token];
            file_put_contents(self::CREDENTIALS_FILE_PATH, json_encode($data));
            $this->access_token = $data['access_token'];
            $this->access_token = $data['refresh_token'];
        }
    }
}
