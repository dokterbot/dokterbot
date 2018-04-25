<?php
/*
copyright @ medantechno.com
Modified by Ilyasa
2017
*/
require_once('./line_class.php');

$channelAccessToken = 'bsKy58ilr15q37HdG2vHwBO/i3fzAEnzKdP/B93dEa0mJkUtRxUhAAVgjJpUi9VHQWeQVflT4kVi2+GvhmFnO3to9KfuK5VN2MmnH81q6frnKup7/F7P7VKZ2DphZ2s8YtpOVFgzAoF3Hc++Vf5ImQdB04t89/1O/w1cDnyilFU='; //Your Channel Access Token
$channelSecret = '132db5f4346d1bba59799d9ef93236f3';//Your Channel Secret

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
