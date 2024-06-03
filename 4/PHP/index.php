<?php
header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $messages = array();

  if (!empty($_COOKIE['save'])) {
    setcookie('save', '', time() - 100000);
    $messages[] = 'Спасибо, результаты сохранены.';
  }

  $errors = array();
  $errors['names'] = !empty($_COOKIE['names_error']);
  $errors['phone'] = !empty($_COOKIE['phone_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['date'] = !empty($_COOKIE['date_error']);
  $errors['gender'] = !empty($_COOKIE['gender_error']);
  $errors['languages'] = !empty($_COOKIE['languages_error']);
  $errors['biography'] = !empty($_COOKIE['biography_error']);
  $errors['agree'] = !empty($_COOKIE['agree_error']);

  if ($errors['names']) {
    setcookie('names_error', '', time() - 100000);
    setcookie('names_value', '', time() - 100000);
    $messages[] = '<div class="error">ФИО должно состоять только из кириллицы и быть заполнено.</div>';
  }

  if ($errors['phone']) {
    setcookie('phone_error', '', time() - 100000);
    setcookie('phone_value', '', time() - 100000);
    $messages[] = '<div class="error">Телефон должен быть в формате +7 (XXX) XXX-XXXX.</div>';
  }

  if ($errors['email']) {
    setcookie('email_error', '', time() - 100000);
    setcookie('email_value', '', time() - 100000);
    $messages[] = '<div class="error">Неверный формат email.</div>';
  }

  if ($errors['date']) {
    setcookie('date_error', '', time() - 100000);
    setcookie('date_value', '', time() - 100000);
    $messages[] = '<div class="error">Дата должна быть в формате ГГГГ-ММ-ДД.</div>';
  }

  if ($errors['gender']) {
    setcookie('gender_error', '', time() - 100000);
    setcookie('gender_value', '', time() - 100000);
    $messages[] = '<div class="error">Выберите пол.</div>';
  }

  if ($errors['languages']) {
    setcookie('languages_error', '', time() - 100000);
    setcookie('languages_value', '', time() - 100000);
    $messages[] = '<div class="error">Выберите хотя бы один язык.</div>';
  }

  if ($errors['biography']) {
    setcookie('biography_error', '', time() - 100000);
    setcookie('biography_value', '', time() - 100000);
    $messages[] = '<div class="error">Заполните биографию.</div>';
  }

  if ($errors['agree']) {
    setcookie('agree_error', '', time() - 100000);
    setcookie('agree_value', '', time() - 100000);
    $messages[] = '<div class="error">Вы должны согласиться с условиями.</div>';
  }

  $values = array();
  $values['names'] = empty($_COOKIE['names_value']) ? '' : $_COOKIE['names_value'];
  $values['phone'] = empty($_COOKIE['phone_value']) ? '' : $_COOKIE['phone_value'];
  $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
  $values['date'] = empty($_COOKIE['date_value']) ? '' : $_COOKIE['date_value'];
  $values['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
  $values['languages'] = empty($_COOKIE['languages_value']) ? array() : explode(',', $_COOKIE['languages_value']);
  $values['biography'] = empty($_COOKIE['biography_value']) ? '' : $_COOKIE['biography_value'];
  $values['agree'] = empty($_COOKIE['agree_value']) ? '' : $_COOKIE['agree_value'];

  include('form.php');
} else {
  $error_messages = [
    'names' => 'ФИО должно состоять только из кириллицы и быть заполнено.',
    'phone' => 'Телефон должен быть в формате +7 (XXX) XXX-XXXX.',
    'email' => 'Неверный формат email.',
    'date' => 'Дата должна быть в формате ГГГГ-ММ-ДД.',
    'gender' => 'Выберите пол.',
    'languages' => 'Выберите хотя бы один язык.',
    'biography' => 'Заполните биографию.',
    'agree' => 'Вы должны согласиться с условиями.'
  ];

  $errors = FALSE;
  $system_messages = [];

  // Проверка ФИО
  if (empty($_POST['names']) || !preg_match("/^[а-яА-ЯёЁ\s]+$/u", $_POST['names'])) {
    setcookie('names_error', '1', time() + 24 * 60 * 60);
    $system_messages['names'] = $error_messages['names'];
    $errors = TRUE;
  } else {
    setcookie('names_value', $_POST['names'], time() + 30 * 24 * 60 * 60);
  }

  // Проверка телефона
  if (empty($_POST['phone']) || !preg_match("/^\+7\s\(\d{3}\)\s\d{3}-\d{4}$/", $_POST['phone'])) {
    setcookie('phone_error', '1', time() + 24 * 60 * 60);
    $system_messages['phone'] = $error_messages['phone'];
    $errors = TRUE;
  } else {
    setcookie('phone_value', $_POST['phone'], time() + 30 * 24 * 60 * 60);
  }

  // Проверка email
  if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    setcookie('email_error', '1', time() + 24 * 60 * 60);
    $system_messages['email'] = $error_messages['email'];
    $errors = TRUE;
  } else {
    setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);
  }

  // Проверка даты
  if (empty($_POST['date']) || !preg_match("/^\d{4}-\d{2}-\d{2}$/", $_POST['date'])) {
    setcookie('date_error', '1', time() + 24 * 60 * 60);
    $system_messages['date'] = $error_messages['date'];
    $errors = TRUE;
  } else {
    setcookie('date_value', $_POST['date'], time() + 30 * 24 * 60 * 60);
  }

  // Проверка пола
  if (empty($_POST['gender'])) {
    setcookie('gender_error', '1', time() + 24 * 60 * 60);
    $system_messages['gender'] = $error_messages['gender'];
    $errors = TRUE;
  } else {
    setcookie('gender_value', $_POST['gender'], time() + 30 * 24 * 60 * 60);
  }

  // Проверка языков
  if (empty($_POST['languages'])) {
    setcookie('languages_error', '1', time() + 24 * 60 * 60);
    $system_messages['languages'] = $error_messages['languages'];
    $errors = TRUE;
  } else {
    $languages = implode(',', $_POST['languages']);
    setcookie('languages_value', $languages, time() + 30 * 24 * 60 * 60);
  }

  // Проверка биографии
  if (empty($_POST['biography'])) {
    setcookie('biography_error', '1', time() + 24 * 60 * 60);
    $system_messages['biography'] = $error_messages['biography'];
    $errors = TRUE;
  } else {
    setcookie('biography_value', $_POST['biography'], time() + 30 * 24 * 60 * 60);
  }

  // Проверка соглашения
  if (empty($_POST['agree'])) {
    setcookie('agree_error', '1', time() + 24 * 60 * 60);
    $system_messages['agree'] = $error_messages['agree'];
    $errors = TRUE;
  } else {
    setcookie('agree_value', $_POST['agree'], time() + 30 * 24 * 60 * 60);
  }

  foreach ($system_messages as $name => $message) {
    setcookie('sys_messages[' . $name . ']', $message, time() + 30 * 24 * 60 * 60);
  }

  if ($errors) {
    header('Location: index.php');
    exit();
  } else {
    setcookie('names_error', '', time() - 100000);
    setcookie('phone_error', '', time() - 100000);
    setcookie('email_error', '', time() - 100000);
    setcookie('date_error', '', time() - 100000);
    setcookie('gender_error', '', time() - 100000);
    setcookie('languages_error', '', time() - 100000);
    setcookie('biography_error', '', time() - 100000);
    setcookie('agree_error', '', time() - 100000);
  }

 $names = $_POST['names'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];
  $date = $_POST['date'];
  $gender = $_POST['gender'];
  $biography = $_POST['biography'];
  $user = 'u67309';
  $pass = '1824692';
  $db = new PDO('mysql:host=localhost;dbname=u67309', $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  try {
    $stmt = $db->prepare("INSERT INTO application (names,phones,email,dates,gender,biography) VALUES (:names, :phone, :email, :date, :gender, :biography)");
    $stmt->execute(array('names' => $names, 'phone' => $phone, 'email' => $email, 'date' => $date, 'gender' => $gender, 'biography' => $biography));
    $applicationId = $db->lastInsertId();

    foreach ($_POST['languages'] as $languageId) {
      $stmt = $db->prepare("INSERT INTO application_languages (id_lang, id_app) VALUES (:languageId, :applicationId)");
      $stmt->bindParam(':languageId', $languageId);
      $stmt->bindParam(':applicationId', $applicationId);
      $stmt->execute();
    }

    print('Спасибо, форма сохранена.');
  } catch (PDOException $e) {
    print('Error : ' . $e->getMessage());
    exit();
  }

  setcookie('save', '1');
  header('Location: index.php');
}
?>
