<?php
/*
|--------------------------------------------------------------------------
| Facebook CI
|--------------------------------------------------------------------------
| Powered By Mycools Inc.
| Coding & Design Algorithum By Mr.Jarak Kritkiattisak
|--------------------------------------------------------------------------
| appId,appSecret
| You can find appId & appSecret in Developer Page @ https://developers.facebook.com/apps
*/
$facebook['appId']="403098523111077";
$facebook['appSecret']="f35beb80d53ac40a2b04cea2596807c5";
$facebook['permisions']=array('ads_management','create_event','create_note','export_stream','manage_notifications','manage_pages','photo_upload','publish_stream','read_insights','read_page_mailboxes','read_requests','read_stream','video_upload','email','user_birthday');
/*
| namespace
| Example : https://apps.facebook.com/mycoolsci
| Page Username is "mycoolsci"
*/
$facebook['namespace']="";
/*
| fanpage setting
| Example : https://www.facebook.com/MycoolsSoft
| Page Namespace is "MycoolsSoft"
| Find PageId with https://graph.facebook.com/MycoolsSoft
*/
$facebook['page']['namespace']="";
$facebook['page']['id']="";
/*
| Cache Setting
| enable true|false Enable Cache Control
| time in minute unit Age of cache file to refresh
*/
$facebook['cache']['enable']=true;
$facebook['cache']['time']=5; //Minute
/*
| End of Facebook Config
*/
$config['facebook']=$facebook;