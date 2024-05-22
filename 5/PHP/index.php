<?php
header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $messages = array();
    if (!empty($_COOKIE['save'])) {
        setcookie('save', '', 100000);
        setcookie('login', '', 100000);
        setcookie('pass', '', 100000);
        $messages[] = 'Спасибо, результаты сохранены. ';
        if (!empty($_COOKIE['pass'])) {
            $messages[] = sprintf('Вы можете <a href="login.php">войти</a> с логином <strong>%s</strong>
        и паролем <strong>%s</strong> для изменения данных.',
                strip_tags($_COOKIE['login']),
                strip_tags($_COOKIE['pass']));
        }
    }
    $errors = array();
    $errors['name'] = !empty($_COOKIE['name_error']);
    $errors['phones'] = !empty($_COOKIE['phones_error']);
    $errors['email'] = !empty($_COOKIE['email_error']);
    $errors['data'] = !empty($_COOKIE['data_error']);
    $errors['gender'] = !empty($_COOKIE['gender_error']);
    $errors['agree'] = !empty($_COOKIE['agree_error']);

    if ($errors['name']) {
        setcookie('name_error', '', 100000);
        $messages[] = '<div>Заполните имя.</div>';
    }
    if ($errors['phones']) {
        setcookie('phones_error', '', 100000);
        $messages[] = '<div>Некорректный телефон.</div>';
    }
    if ($errors['email']) {
        setcookie('email_error', '', 100000);
        $messages[] = '<div>Некорректный email.</div>';
    }
    if ($errors['data']) {
        setcookie('data_error', '', 100000);
        $messages[] = '<div>Выберите год рождения.</div>';
    }
    if ($errors['gender']) {
        setcookie('gender_error', '', 100000);
        $messages[] = '<div>Выберите пол.</div>';
    }
    if ($errors['agree']) {
        setcookie('agree_error', '', 100000);
        $messages[] = '<div>Поставьте галочку.</div>';
    }

    $values = array();
    $values['name'] = isset($_COOKIE['name_value']) ? strip_tags($_COOKIE['name_value']) : '';
    $values['phones'] = isset($_COOKIE['phones_value']) ? strip_tags($_COOKIE['phones_value']) : '';
    $values['email'] = isset($_COOKIE['email_value']) ? strip_tags($_COOKIE['email_value']) : '';
    $values['data'] = isset($_COOKIE['data_value']) ? $_COOKIE['data_value'] : '';
    $values['gender'] = isset($_COOKIE['gender_value']) ? $_COOKIE['gender_value'] : '';
    $values['biography'] = isset($_COOKIE['biography_value']) ? strip_tags($_COOKIE['biography_value']) : '';
    $values['agree'] = isset($_COOKIE['agree_value']) ? $_COOKIE['agree_value'] : ''; 
    $values['language'] = isset($_COOKIE['language_value']) ? json_decode($_COOKIE['language_value'], true) : [];

    session_start();
    if (!empty($_COOKIE[session_name()]) && !empty($_SESSION['login'])) {
        $db = new PDO('mysql:host=localhost;dbname=u67309', 'u67309', '1824692', array(PDO::ATTR_PERSISTENT => true));
        $stmt = $db->prepare("SELECT * FROM application WHERE id = ?");
        $stmt->execute([$_SESSION['uid']]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $values['name'] = strip_tags($row['name']);
        $values['phones'] = strip_tags($row['phones']);
        $values['email'] = strip_tags($row['email']);
        $values['data'] = $row['data'];
        $values['gender'] = $row['gender'];
        $values['biography'] = strip_tags($row['biography']);
        $values['agree'] = true; 
        $stmt = $db->prepare("SELECT name_of_language FROM application_languages WHERE id = ?");
        $stmt->execute([$_SESSION['uid']]);
        $values['language'] = $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    include('form.php');
}
else {
    $errors = FALSE;
    if (empty($_POST['name'])) {
        setcookie('name_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('name_value', $_POST['name'], time() + 12 * 30 * 24 * 60 * 60);
    }

    if (!preg_match('/^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/', $_POST['phones'])) {
        setcookie('phones_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('phones_value', $_POST['phones'], time() + 30 * 24 * 60 * 60);
    }

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        setcookie('email_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('email_value', $_POST['email'], time() + 12 * 30 * 24 * 60 * 60);
    }

    if (empty($_POST['data'])) {
        setcookie('data_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('data_value', $_POST['data'], time() + 12 * 30 * 24 * 60 * 60);
    }

    if (empty($_POST['gender'])) {
        setcookie('gender_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('gender_value', $_POST['gender'], time() + 12 * 30 * 24 * 60 * 60);
    }

    if (empty($_POST['agree'])) {
        setcookie('agree_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('agree_value', $_POST['agree'], time() + 12 * 30 * 24 * 60 * 60);
    }

    $languages = isset($_POST['language']) ? $_POST['language'] : [];
    setcookie('language_value', json_encode($languages), time() + 12 * 30 * 24 * 60 * 60);

    if (!empty($_POST['biography'])) {
        setcookie('biography_value', $_POST['biography'], time() + 12 * 30 * 24 * 60 * 60);
    }

    if ($errors) {
        header('Location: index.php');
        exit();
    } else {
        setcookie('name_error', '', 100000);
        setcookie('phones_error', '', 100000);
        setcookie('email_error', '', 100000);
        setcookie('data_error', '', 100000);
        setcookie('gender_error', '', 100000);
        setcookie('agree_error', '', 100000);
    }

    session_start();
    if (!empty($_COOKIE[session_name()]) && !empty($_SESSION['login'])) {
        $db = new PDO('mysql:host=localhost;dbname=u67309', 'u67309', '1824692', array(PDO::ATTR_PERSISTENT => true));
        $stmt = $db->prepare("UPDATE application SET name = ?, phones = ?, email = ?, data = ?, gender = ?, biography = ? WHERE id = ?");
        $stmt->execute([$_POST['name'], $_POST['phones'], $_POST['email'], $_POST['data'], $_POST['gender'], $_POST['biography'], $_SESSION['uid']]);
        $stmt = $db->prepare("DELETE FROM application_languages WHERE id = ?");
        $stmt->execute([$_SESSION['uid']]);
        $stmt = $db->prepare("INSERT INTO application_languages (id, name_of_language) VALUES (?, ?)");
        foreach ($languages as $language) {
            $stmt->execute([$_SESSION['uid'], $language]);
        }
    } else {
        $db = new PDO('mysql:host=localhost;dbname=u67309', 'u67309', '1824692', array(PDO::ATTR_PERSISTENT => true));
        $stmt = $db->prepare("INSERT INTO application (name, phones, email, data, gender, biography) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$_POST['name'], $_POST['phones'], $_POST['email'], $_POST['data'], $_POST['gender'], $_POST['biography']]);
        $id = $db->lastInsertId();
        $stmt = $db->prepare("INSERT INTO application_languages (id, name_of_language) VALUES (?, ?)");
        foreach ($languages as $language) {
            $stmt->execute([$id, $language]);
        }
        $login = 'user' . substr(uniqid(), -5);
        $pass = substr(md5(uniqid()), 0, 10);
        $hash = md5($pass);
        $stmt = $db->prepare("INSERT INTO users (id, login, pass) VALUES (?, ?, ?)");
        $stmt->execute([$id, $login, $hash]);
        setcookie('login', $login);
        setcookie('pass', $pass);
    }
    setcookie('save', '1');
    header('Location: index.php');
}
?>

