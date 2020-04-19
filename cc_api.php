<?php
/*--------
 - Библиотека API приложения CoronaCoin
 - @author temajm - Кручинин Артём - (https://vk.com/temajm)
 - @version 1.0
 - @version API: 0.1Beta
 --------*/
 
 
class CoronaCoin {

	private $apikey = "";
	private $user_id = 0;

	/**
	 * Конструктор 
	 - @param int $merchant_id - ID пользователя, для которого получен ключ
	 - @param string $apikey - Секрет ключ
	 */
	public function __construct($user_id, $apikey) {
		$this->user_id = $user_id;
		$this->apikey = $apikey;
	}

	/**
	 * Отправка POST запроса 
	 - @param int $url - Ссылка на который будет отправлен запрос
	 - @param array/string $arr - Массив/Строка которую необходимо передать.
	 */
	public function post_send($url,$arr){
	$ch = curl_init($url);

	$payload = json_encode($arr );
	curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
	curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

	$result = curl_exec($ch);
	curl_close($ch);

	return $result;
	}

		/**
		 * Перевод другим пользователям.
		 - @param int $to_id - Id пользователя которому необходимо передать коины  (обязательный, целое число)
		 - @param int $amount - Количество коинов которых необходимо передать (обязательный, целое число)
		 */
	public function transfer($to_id,$amount){
	$arr['token'] = $this->apikey;
	$arr['method'] = 'transfer';
	$arr['to_id'] = $to_id;
	$arr['amount'] = $amount;
	return $this->post_send('https://corona-coins.ru/api/',$arr);
	}

		/**
		 * Получение баланса других пользователей.
		 - @param array $user_ids - ПОЛЬЗОВАТЕЛИ которых вы желаете получить баланс. (обязательный, массив ID пользователей, не более 100)
		 */
	public function score($user_ids){
	$arr['token'] = $this->apikey;
	$arr['method'] = 'score';
	$arr['user_ids'] = $user_ids;
	return $this->post_send('https://corona-coins.ru/api/',$arr);
	}

		/**
		 * Перевод другим пользователям.
		 - @param int $type - Тип истории (обязательный, 1 - перевод пользователем, 2 - перевод через API)
		 - @param int $amount - Смещение (необязательный, целое число от 0 и более)
		 */
	public function history($type,$offset = 1){
	$arr['token'] = $this->apikey;
	$arr['method'] = 'history';
	$arr['type'] = $type;
	$arr['offset'] = $offset;
	return $this->post_send('https://corona-coins.ru/api/',$arr);
	}

		/**
		 * Узнать баланс мерчанта
		*/
	public function getMyBalance(){
		$req = json_decode($this->score([$this->user_id]));
		return $req->response[0]->coins;
	}
}
?>
