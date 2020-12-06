<?php
include('../inc/config.php');
include('../inc/functions.php');

if(isset($_GET['Attachment'])){
    $VideoID = filter_var($_GET['Attachment'], FILTER_SANITIZE_STRING);
    downloadAttachment($VideoID);
    header('Location: home');
}
if(isset($_GET['Thumbnail'])){
    $VideoID = filter_var($_GET['Thumbnail'], FILTER_SANITIZE_STRING);
    downloadThumbnail($VideoID);
    header('Location: home');
}
?>