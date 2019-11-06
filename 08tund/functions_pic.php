<?php
function makeImage($picFile, $imageFileType){
    if($imageFileType == "jpg" or $imageFileType == "jpeg"){
        $myTempImage = imagecreatefromjpeg($picFile);
    }
    if($imageFileType == "png"){
        $myTempImage = imagecreatefrompng($picFile);
    }
    if($imageFileType == "gif"){
        $myTempImage = imagecreatefromgif($picFile);
    }
    return $myTempImage;
}

function setPicSize($myTempImage, $picSizeRatio){
    $picW = imagesx($myTempImage);
    $picH = imagesy($myTempImage);
    $picNewW = round($picW / $picSizeRatio, 0);
    $picNewH = round($picH / $picSizeRatio, 0);
    $newImage = imagecreatetruecolor($picNewW, $picNewH);
    imagecopyresampled($newImage, $myTempImage, 0, 0, 0, 0, $picNewW, $picNewH, $picW, $picH); //kuhu, kust, kus uul pildi x koorinaat, y koordinaat, kust vanast pildilt x, y, kui laialt x, y, kust nii laialt x, y
    return $newImage;
}

function saveImage($myNewImage, $targetFile, $imageFileType){
    if($imageFileType == "jpg" or $imageFileType == "jpeg"){
        if(imagejpeg($myNewImage, $targetFile, 50)){
            $notice = "vähendatud pilt edukalt salvestatud";
        }
        else{
            $notice = "vähendatud pildi salvestamine ebaõnnestus";
        }
    }
    if($imageFileType == "png"){
        if(imagepng($myNewImage, $targetFile, 6)){
            $notice = "vähendatud pilt edukalt salvestatud";
        }
        else{
            $notice = "vähendatud pildi salvestamine ebaõnnestus";
        }
    }
    if($imageFileType == "gif"){
        if(imagegif($myNewImage, $targetFile)){
            $notice = "vähendatud pilt edukalt salvestatud";
        }
        else{
            $notice = "vähendatud pildi salvestamine ebaõnnestus";
        }
    }
    return $notice;
}