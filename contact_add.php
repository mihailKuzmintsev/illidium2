<?php


$project_name = trim($_POST["project_name"]);
$form_subject = trim($_POST["form_subject"]);
$contact_email = isset($_POST['email']) ? trim($_POST["email"]) : '';
$contact_tel = isset($_POST['tel']) ? trim($_POST["tel"]) : '';
$contact_name = trim($_POST["name"]);

$contacts['add']=array(
   array(
      'name' => 'Новый контакт('.$contact_name.')',
      'responsible_user_id' => 1279638,
      // 'created_at' => date(),
      'tags' => $project_name,
      'custom_fields' => array(
         array(
            'id' => 10240,
            'values' => array(
               array(
                  'value' => $contact_tel,
                  'enum' => 'WORK'
               )
            )
         ),
         array(
            'id' => 10242,
            'values' => array(
               array(
                  'value' => $contact_email,
                  'enum' => 'WORK'
               )
            )
         )         
      )
   )
);

$subdomain='illidium'; #Наш аккаунт - поддомен
#Формируем ссылку для запроса
$link='https://'.$subdomain.'.amocrm.ru/api/v2/contacts';
/* Нам необходимо инициировать запрос к серверу. Воспользуемся библиотекой cURL (поставляется в составе PHP). Вы также
можете использовать и кроссплатформенную программу cURL, если вы не программируете на PHP. */
$curl=curl_init(); #Сохраняем дескриптор сеанса cURL
#Устанавливаем необходимые опции для сеанса cURL
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
curl_setopt($curl,CURLOPT_URL,$link);
curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');
curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($contacts));
curl_setopt($curl,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
curl_setopt($curl,CURLOPT_HEADER,false);
curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);

$out=curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
$code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
/* Теперь мы можем обработать ответ, полученный от сервера. Это пример. Вы можете обработать данные своим способом. */
// $code=(int)$code;
// $errors=array(
//   301=>'Moved permanently',
//   400=>'Bad request',
//   401=>'Unauthorized',
//   403=>'Forbidden',
//   404=>'Not found',
//   500=>'Internal server error',
//   502=>'Bad gateway',
//   503=>'Service unavailable'
// );
// try
// {
//   #Если код ответа не равен 200 или 204 - возвращаем сообщение об ошибке
//  if($code!=200 && $code!=204) {
//     throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error',$code);
//   }
// }
// catch(Exception $E)
// {
//   die('Ошибка: '.$E->getMessage().PHP_EOL.'Код ошибки: '.$E->getCode());
// }
?>