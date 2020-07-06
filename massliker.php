<?

$groupid = '28870275';   // айди группы
$lookdown = '1'; // какой пост  по порядку из группы хватать  если есть закреп в шапке  то ставить минимум единицу

include('./tokens.php');
foreach($tokens as $token) {
$wall_group = vkapi('wall.get?owner_id=-'.$groupid.'&offset='.$lookdown.'&count=1&access_token='.$token['token'].'&v=5.58');
$take_object = json_decode($wall_group,true);
$object_id = $take_object['response']['items']['0']['id'];
$checkisliked = vkapi('likes.isLiked?type=post&owner_id=-'.$groupid.'&item_id='.$object_id.'&access_token='.$token['token'].'&v=5.58');
$json_checkisliked = json_decode($checkisliked,true);
$islikepost = $json_checkisliked['response']['liked'];
if ($islikepost == 0) {
vkapi('likes.add?type=post&owner_id=-'.$groupid.'&item_id='.$object_id.'&access_token='.$token['token'].'&v=5.58');
sleep(15); 
}
}

function vkapi($method) {
		$ch = curl_init("https://api.vk.com/method/".$method);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
		$response = curl_exec($ch);
		curl_close($ch);
		return $response;
		
	}
?>