<?php
/**
 * Created by PhpStorm.
 * User: BDuman
 * Date: 20.03.2016
 * Time: 17:41
 */

class Hizliresim {

    const API_BASE = 'http://hizliresim.com/p/eklenti-yukle';

    private $usefulUrls = true;
    private $replaces = array(
        "search" => array(
            "hizliresim.com",
            "bmp",
            "tif",
            "webp"
        ),
        "replace" => array(
            "i.hizliresim.com",
            "png",
            "jpg",
            "jpg"
        )
    );

    private $uploaded = array();
    private $queue = array();

    private $curl = null;

    function __construct($dump = false) {

        if($dump)
            $this->usefulUrls = false;
    }

    public function collect($photos) {

        if(is_array($photos)) {

            foreach ($photos as $photo)
                $this->setQueue($photo);

        } else {

            $this->setQueue($photos);
        }
    }

    public function upload($photo) {

        $this->collect($photo);

        return $this->go();
    }

    public function go() {

        if(count($this->queue) > 0) {

            $this->postMulti();

            return $this->getUsefulUrls();
        }

        throw new Exception("Queue is empty");
    }

    private function setQueue($photo) {

        $chx = curl_init();
        curl_setopt_array($chx, $this->getOptionsForRemoteUpload($photo));

        $this->queue[] = $chx;
    }

    private function postMulti() {

        $this->curl = curl_multi_init();

        foreach($this->queue as $ch)
            curl_multi_add_handle($this->curl, $ch);

        $running = null;

        do {
            curl_multi_exec($this->curl, $running);
        }
        while($running > 0);

        foreach($this->queue as $key => $val) {

            $this->uploaded[$key] = json_decode(curl_multi_getcontent($val), true);
            curl_multi_remove_handle($this->curl, $val);
            unset($this->queue[$key]);
        }

        curl_multi_close($this->curl);
    }

    private function getOptionsForRemoteUpload($photo) {

        return array(
            CURLOPT_URL => self::API_BASE,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => "remote_file_url=".$photo,
            CURLOPT_RETURNTRANSFER => true
        );
    }

    private function getUsefulUrls() {

        if(!$this->usefulUrls)
            return $this->uploaded;

        if(is_array($this->uploaded)) {

            foreach($this->uploaded as $key => $image) {

                if(key_exists("images", $image)) {

                    if($image["images"][0]["status"] == 0) {


                        $pieces = explode(".", $image["images"][0]["source_url"]);
                        $extension = array_pop($pieces);

                        $this->uploaded[$key] = str_replace($this->replaces["search"], $this->replaces["replace"], $image["images"][0]["image_url"].".".$extension);
                    }
                }
            }

            return $this->uploaded;
        }

        throw new Exception("Maybe API changed!");
    }



}