<?php

namespace App\Services;

class Embedding
{

    /**
     * @var string |null
     * //This is a general function for generating an embed link of an FB/Vimeo/Youtube Video.
     */
    public function getEmbedPath(?string $path) : ?string
    { 
        $embedPath = '';
        if(strpos($path, 'facebook.com/') !== false) {
            //it is FB video
            $embedPath.='https://www.facebook.com/plugins/video.php?href='.rawurlencode($url).'&show_text=1&width=200';
        }else if(strpos($path, 'vimeo.com/') !== false) {
            //it is Vimeo video
            $videoId = explode("vimeo.com/",$path)[1];
        if(strpos($videoId, '&') !== false){
            $videoId = explode("&",$videoId)[0];
        }
        $embedPath.='https://player.vimeo.com/video/'.$videoId;
        }else if(strpos($path, 'youtube.com/') !== false) {
            //it is Youtube video
            $videoId = explode("v=",$path)[1];
        if(strpos($videoId, '&') !== false){
            $videoId = explode("&",$videoId)[0];
        }
        $embedPath.='https://www.youtube.com/embed/'.$videoId; 
        }else if(strpos($path, 'youtu.be/') !== false){
            //it is Youtube video
            $videoId = explode("youtu.be/",$path)[1];
        if(strpos($videoId, '&') !== false){
            $videoId = explode("&",$videoId)[0];
        }
            $embedPath.='https://www.youtube.com/embed/'.$videoId;
        }else{
            //Enter valid video URL
        }

        return $embedPath;

    }
}