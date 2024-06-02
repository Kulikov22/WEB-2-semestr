<?php
header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $messages = array();

    $errors = array();
    $errors['names'] = !empty($_COOKIE['names_error']);
    $errors['email'] = !empty($_COOKIE['email_error']);
    $errors['date'] = !empty($_COOKIE['date_error']);
    $errors['phone'] = !empty($_COOKIE['phone_error']);
    $errors['gender'] = !empty($_COOKIE['gender_error']);
    $errors['biography'] = !empty($_COOKIE['biography_error']);
    $errors['agree'] = !empty($_COOKIE['agree_error']);
    $errors['languages'] = !empty($_COOKIE['languages_error']);

    if ($errors['names']) {
        setcookie('names_error', '', 100000);
        $messages[] = '<div class="error">Заполните имя.</div>';
    }

    if ($errors['email']) {
        setcookie('email_error', '', 100000);
        $messages[] = '<div class="error">Заполните email.</div>';
    }

    if ($errors['date']) {
        setcookie('date_error', '', 100000);
        $messages[] = '<div class="error">Заполните дату рождения.</div>';
    }

    if ($errors['phone']) {
        setcookie('phone_error', '', 100000);
        $messages[] = '<div class="error">Заполните телефон.</div>';
    }

    if ($errors['gender']) {
        setcookie('gender_error', '', 100000);
        $messages[] = '<div class="error">Укажите пол.</div>';
    }

    if ($errors['biography']) {
        setcookie('biography_error', '', 100000);
        $messages[] = '<div class="error">Заполните биографию.</div>';
    }

    if ($errors['agree']) {
        setcookie('agree_error', '', 100000);
        $messages[] = '<div class="error">Согласие обязательно.</div>';
    }

    if ($errors['languages']) {
        setcookie('languages_error', '', 100000);
        $messages[] = '<div class="error">Выберите язык.</div>';
    }

    $values = array();
    $values['names'] = empty($_COOKIE['names_value']) ? '' : $_COOKIE['names_value'];
    $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
    $values['date'] = empty($_COOKIE['date_value']) ? '' : $_COOKIE['date_value'];
    $values['phone'] = empty($_COOKIE['phone_value']) ? '' : $_COOKIE['phone_value'];
    $values['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
    $values['biography'] = empty($_COOKIE['biography_value']) ? '' : $_COOKIE['biography_value'];
    $values['agree'] = empty($_COOKIE['agree_value']) ? '' : $_COOKIE['agree_value'];
    $values['languages'] = empty($_COOKIE['languages_value']) ? array() : json_decode($_COOKIE['languages_value'], true);

    include('form.php');
} else {
    $errors = FALSE;

    if (empty($_POST['names'])) {
        setcookie('names_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('names_value', $_POST['names'], time() + 30 * 24 * 60 * 60);
    }

    if (empty($_POST['email'])) {
        setcookie('email_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);
    }

    if (empty($_POST['date'])) {
        setcookie('date_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('date_value', $_POST['date'], time() + 30 * 24 * 60 * 60);
    }

    if (empty($_POST['phone'])) {
        setcookie('phone_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('phone_value', $_POST['phone'], time() + 30 * 24 * 60 * 60);
    }

    if (empty($_POST['gender'])) {
        setcookie('gender_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('gender_value', $_POST['gender'], time() + 30 * 24 * 60 * 60);
    }

    if (empty($_POST['biography'])) {
        setcookie('biography_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('biography_value', $_POST['biography'], time() + 30 * 24 * 60 * 60);
    }

    if (!isset($_POST['agree'])) {
        setcookie('agree_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('agree_value', $_POST['agree'], time() + 30 * 24 * 60 * 60);
    }

    if (empty($_POST['languages'])) {
        setcookie('languages_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('languages_value', json_encode($_POST['languages']), time() + 30 * 24 * 60 * 60);
    }

    if ($errors) {
        header('Location: index.php');
        exit();
    } else {
        setcookie('names_error', '', 100000);
        setcookie('email_error', '', 100000);
        setcookie('date_error', '', 100000);
        setcookie('phone_error', '', 100000);
        setcookie('gender_error', '', 100000);
        setcookie('biography_error', '', 100000);
        setcookie('agree_error', '', 100000);
        setcookie('languages_error', '', 100000);

        echo 'Спасибо, данные сохранены!';
    }
}
