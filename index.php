<?php
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  
  $messages = array();

  if (!empty($_COOKIE['save'])) {
    setcookie('save', '', 100000);
    // Если есть параметр save, то выводим сообщение пользователю.
    $messages[] = 'Спасибо, результаты сохранены.';
  }

  // Складываем признак ошибок в массив.
  $errors = array();
  $errors['name'] = !empty($_COOKIE['name_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['year'] = !empty($_COOKIE['year_error']);
  $errors['radio-1'] = !empty($_COOKIE['pol_error']);
  $errors['radio-2'] = !empty($_COOKIE['limb_error']);
  $errors['super'] = !empty($_COOKIE['super_error']);
  $errors['bio'] = !empty($_COOKIE['bio_error']);
  $errors['check-1'] = !empty($_COOKIE['check_error']);

  // Выдаем сообщения об ошибках.
  if ($errors['name']) {
    setcookie('name_error', '', 100000);
    $messages[] = '<div class="error">Заполните имя или у него неверный формат (only English)</div>';
  }
  if ($errors['email']) {
    setcookie('email_error', '', 100000);
    $messages[] = '<div class="error">Заполните имейл или у него неверный формат</div>';
  }
  if ($errors['year']) {
    setcookie('year_error', '', 100000);
    $messages[] = '<div class="error">Выберите год.</div>';
  }
  if ($errors['radio-1']) {
    setcookie('pol_error', '', 100000);
    $messages[] = '<div class="error">Выберите пол.</div>';
  }
  if ($errors['radio-2']) {
    setcookie('limb_error', '', 100000);
    $messages[] = '<div class="error">Укажите кол-во конечностей.</div>';
  }
  if ($errors['super']) {
    setcookie('super_error', '', 100000);
    $messages[] = '<div class="error">Выберите суперспособности(хотя бы одну).</div>';
  }
  if ($errors['bio']) {
    setcookie('bio_error', '', 100000);
    $messages[] = '<div class="error">Заполните биографию или у неё неверный формат (only English)</div>';
  }
  if ($errors['check-1']) {
    setcookie('check_error', '', 100000);
    $messages[] = '<div class="error">Вы должны быть согласны дать свои данные.</div>';
  }
  
  // Складываем предыдущие значения полей в массив, если есть.
  $values = array();
  $values['name'] = empty($_COOKIE['name_value']) ? '' : $_COOKIE['name_value'];
  $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
  $values['year'] = empty($_COOKIE['year_value']) ? 0 : $_COOKIE['year_value'];
  $values['radio-1'] = empty($_COOKIE['pol_value']) ? '' : $_COOKIE['pol_value'];
  $values['radio-2'] = empty($_COOKIE['limb_value']) ? '' : $_COOKIE['limb_value'];
  $values['fly'] = empty($_COOKIE['fly_value']) ? 0 : $_COOKIE['fly_value'];
  $values['sleep'] = empty($_COOKIE['sleep_value']) ? 0 : $_COOKIE['sleep_value'];
  $values['run'] = empty($_COOKIE['run_value']) ? 0 : $_COOKIE['run_value'];
  $values['bio'] = empty($_COOKIE['bio_value']) ? '' : $_COOKIE['bio_value'];
  $values['check-1'] = empty($_COOKIE['check_value']) ? 0 : $_COOKIE['check_value'];

  // Включаем содержимое файла form.php.
  // В нем будут доступны переменные $messages, $errors и $values для вывода 
  // сообщений, полей с ранее заполненными данными и признаками ошибок.
  include('form.php');
}
else {
  //Регулярные выражения
  $bioregex = "/^\s*\w+[\w\s\.,-]*$/";
  $nameregex = "/^\w+[\w\s-]*$/";
  $mailregex = "/^[\w\.-]+@([\w-]+\.)+[\w-]{2,4}$/";
	
  // Проверяем ошибки.
  $errors = FALSE;
  if ((empty($_POST['name'])) || (!preg_match($nameregex,$_POST['name']))) {
    setcookie('name_error', '1', time() + 24 * 60 * 60);
    setcookie('name_value', '', 100000);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на год.
    setcookie('name_value', $_POST['name'], time() + 12 * 30 * 24 * 60 * 60);
    setcookie('name_error', '', 100000);
  }
  
  if ((empty($_POST['email'])) || (!preg_match($mailregex,$_POST['email']))) {
    setcookie('email_error', '1', time() + 24 * 60 * 60);
    setcookie('email_value', '', 100000);
    $errors = TRUE;
  }
  else {
    setcookie('email_value', $_POST['email'], time() + 12 * 30 * 24 * 60 * 60);
    setcookie('email_error', '', 100000);
  }
  
  if ($_POST['year']=='Год') {
    setcookie('year_error', '1', time() + 24 * 60 * 60);
    setcookie('year_value', '', 100000);
    $errors = TRUE;
  }
  else {
    setcookie('year_value', intval($_POST['year']), time() + 12 * 30 * 24 * 60 * 60);
    setcookie('year_error', '', 100000);
  }
  
  if (!isset($_POST['radio-1'])) {
    setcookie('pol_error', '1', time() + 24 * 60 * 60);
    setcookie('pol_value', '', 100000);
    $errors = TRUE;
  }
  else {
    setcookie('pol_value', $_POST['radio-1'], time() + 12 * 30 * 24 * 60 * 60);
    setcookie('pol_error','',100000);
  }
  
  if (!isset($_POST['radio-2'])) {
    setcookie('limb_error', '1', time() + 24 * 60 * 60);
    setcookie('limb_value', '', 100000);
    $errors = TRUE;
  }
  else {
    setcookie('limb_value', $_POST['radio-2'], time() + 12 * 30 * 24 * 60 * 60);
    setcookie('limb_error','',100000);
 }
  
  if (!isset($_POST['super'])) {
    setcookie('super_error', '1', time() + 24 * 60 * 60);
    setcookie('fly_value', '', 100000);
    setcookie('sleep_value', '', 100000);
    setcookie('run_value', '', 100000);
    $errors = TRUE;
  }
  else {
    $powrs=$_POST['super'];
    $apw=array(
      "fly_value"=>0,
      "sleep_value"=>0,
      "run_value"=>0,
    );
  foreach($powrs as $pwer){
    if($pwer=='fly'){setcookie('fly_value', 1, time() + 12 * 30 * 24 * 60 * 60); $apw['fly_value']=1;} 
    if($pwer=='sleep'){setcookie('sleep_value', 1, time() + 12*30 * 24 * 60 * 60);$apw['sleep_value']=1;} 
    if($pwer=='run'){setcookie('run_value', 1, time() + 12*30 * 24 * 60 * 60);$apw['run_value']=1;} 
    }
  foreach($apw as $c=>$val){
    if($val==0){
      setcookie($c,'',100000);
    }
  }
}
  
  if ((empty($_POST['bio'])) || (!preg_match($bioregex,$_POST['bio']))) {
    setcookie('bio_error', '1', time() + 24 * 60 * 60);
    setcookie('bio_value', '', 100000);
    $errors = TRUE;
  }
  else {
    setcookie('bio_value', $_POST['bio'], time() + 12 * 30 * 24 * 60 * 60);
    setcookie('bio_error', '', 100000);
  }
  
  if(!isset($_POST['check-1'])){
    setcookie('check_error','1',time()+  n24 * 60 * 60);
    setcookie('check_value', '', 100000);
    $errors=TRUE;
  }
  else{
    setcookie('check_value', TRUE,time()+ 12 * 30 * 24 * 60 * 60);
    setcookie('check_error','',100000);
  }

  if ($errors) {
    // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
    header('Location: index.php');
    exit();
  }
  else {
    // Удаляем Cookies с признаками ошибок.
    setcookie('name_error', '', 100000);
    setcookie('email_error', '', 100000);
    setcookie('year_error', '', 100000);
    setcookie('pol_error', '', 100000);
    setcookie('limb_error', '', 100000);
    setcookie('super_error', '', 100000);
    setcookie('bio_error', '', 100000);
    setcookie('check_error', '', 100000);
  }
  
  $name = $_POST['name'];
  $email = $_POST['email'];
  $birth_year = $_POST['year'];
  $pol = $_POST['radio-1'];
  $limbs = intval($_POST['radio-2']);
  $superruns = $_POST['super'];
  $bio= $_POST['bio'];

  // Сохранение в БД.
$user = 'u47577';
$pass = '9303559';
  $db = new PDO('mysql:host=localhost;dbname=u41028', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
   try {
    $stmt = $db->prepare("INSERT INTO application SET name=:name, email=:email, year=:byear, pol=:pol, limbs=:limbs, bio=:bio");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':byear', $birth_year);
    $stmt->bindParam(':pol', $pol);
    $stmt->bindParam(':limbs', $limbs);
    $stmt->bindParam(':bio', $bio);
    if($stmt->execute()==false){
    print_r($stmt->errorCode());
    print_r($stmt->errorInfo());
    exit();
    }
    $id = $db->lastInsertId();
    $sppe= $db->prepare("INSERT INTO super SET name=:name, per_id=:person");
    $sppe->bindParam(':person', $id);
    foreach($superruns as $inserting){
  	$sppe->bindParam(':name', $inserting);
  	if($sppe->execute()==false){
	    print_r($sppe->errorCode());
	    print_r($sppe->errorInfo());
	    exit();
  	}
    }
  }
  catch(PDOException $e){
    print('Error : ' . $e->getMessage());
    exit();
  }

  // Сохраняем куку с признаком успешного сохранения.
  setcookie('save', '1');

  // Делаем перенаправление.
  header('Location: index.php');
}