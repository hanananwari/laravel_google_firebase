<?php

namespace Solumax\GoogleFirebase\App\Device\Managers\Topics;

use Solumax\GoogleFirebase\App\Device\DeviceModel;

class Retrieve {

  protected $device;

  public function __construct(DeviceModel $device) {
    $this->device = $device;
  }

  public function topic() {
        /*
         * {
          "connectDate": "2019-05-15",
          "application": "com.chrome.windows",
          "subtype": "wp:https://antrian.hondagelora.com/#4BA5B54E-880F-4139-911D-C5D6332DA-V2",
          "scope": "*",
          "authorizedEntity": "45669778914",
          "rel": {
          "topics": {
          "antrian": {
          "addDate": "2019-05-15"
          }
          }
          },
          "connectionType": "WIFI",
          "platform": "BROWSER"
          }
         * 
         */

          try {

            $client = new \GuzzleHttp\Client();

            $res = $client->get('https://iid.googleapis.com/iid/info/' . $this->device->token, [
              'headers' => [
                'Authorization' => 'key=' .config('solumax.googleFirebase.firebase.server_key')
              ],
              'query' => ['details' => true]
            ]);
<<<<<<< HEAD
            
=======

>>>>>>> 0514fa4
            return json_decode($res->getBody()->getContents());

          } catch (\GuzzleHttp\Exception\ServerException $e) {

            return [
              'status' => false,
              'status_code' => $e->getCode(),
              'error' => $e->getMessage()
            ];
          } catch (\GuzzleHttp\Exception\ClientException $e) {

            return [
              'status' => false,
              'status_code' => $e->getCode(),
              'error' => $e->getMessage()
            ];
          }

        }

      }
