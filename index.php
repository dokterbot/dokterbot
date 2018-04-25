<?php
/*
copyright @ medantechno.com
Modified by Ilyasa
2017
*/
require_once('./line_class.php');

$channelAccessToken = 'zTtaTYUSk0KevDK+g7BTdETH6CmJczqwFs5+i2K3b/hahhOV8+1gW4er856RbYKpIFGjlyjk4ID6kX2fR4+/u/xWwOzvCBKvMq/h3pIp6MIanbbT+k/11oc5EamPaQI0MMdgPlhQrpFpy37dQH5LBQdB04t89/1O/w1cDnyilFU='; //Your Channel Access Token
$channelSecret = '326573e5be58c547c60fa7f80fcaa3ae';//Your Channel Secret

$client = new LINEBotTiny($channelAccessToken, $channelSecret);

$userId 	= $client->parseEvents()[0]['source']['userId'];
$replyToken 	= $client->parseEvents()[0]['replyToken'];
$message 	= $client->parseEvents()[0]['message'];
$profil 	= $client->profil($userId);
$pesan_datang 	= $message['text'];

$string = file_get_contents('./output.json');
$json_a = json_decode($string, true);

if($message['type']=='sticker')
{	
	$balas = array(
		'UserID' => $profil->userId,	
		'replyToken' => $replyToken,							
		'messages' => array(
			array(
					'type' => 'text',									
					'text' => 'Terima Kasih Stikernya.'										

				)
		)
	);
						
}


else if($message['type']=='text')
{
	if ($pesan_datang==$pesan_datang){
	
		foreach ($json_a as $idx) {
			if ($pesan_datang == $idx['judul']){
				
				$balas = array(
					'UserID' => $profil->userId,	
					'replyToken' => $replyToken,													
					'messages' => array(
						array(
								'type' => 'text',					
								'text' => $idx['definisi']
							)
					)
				);
				
				break;
			}
		}
	}

	else if ($message['text']=='B'){
		
		$balas = array(
			'UserID' => $profil->userId,
			'replyToken' => $replyToken,														
			'messages' => array(
				array(
					'type' => 'text',					
					'text' => 'Maaf '.$profil->displayName.' Server Kami Sedang Sibuk Sekarang.'
				)
			)
		);
	}

}
 
$result =  json_encode($balas);

file_put_contents('./reply.json',$result);


$client->replyMessage($balas);
