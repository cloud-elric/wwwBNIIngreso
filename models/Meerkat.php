<?php
namespace app\models;

class Meerkat{

    const URL_API = "https://demo.meerkat.com.br/frapi/";
    public $api_key = "81846eb7d66fd8e421c9f474fff89535";

    public function guardarUsuario($urlImage, $label){

        $apiUrl = 'train/person';
        $params= ['imageUrl'=>$urlImage, 'label'=>$label];
        return $this->curlPost(self::URL_API.$apiUrl, $params);
    }

    public function reconocerUsuario($urlImage){
        $apiUrl = 'recognize/people';
        $params = self::URL_API.$apiUrl."?imageUrl=".$urlImage;
        return $this->curlGet($params);
    }

    private function curlGet($url){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['api-key:'.$this->api_key,'Content-Type: application/json',]);

        $content = curl_exec($ch);

        curl_close($ch);

        return $content;
    }

    private function curlPost($url, $parameters){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($parameters));

        curl_setopt($ch, CURLOPT_HTTPHEADER, ['api-key:'.$this->api_key,'Content-Type: application/json',]);

        $content = curl_exec($ch);

        curl_close($ch);

        return $content;
    }
}
      
