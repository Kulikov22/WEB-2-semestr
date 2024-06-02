<?php
header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $messages = array();
    if (!empty($_COOKIE['save'])) {
        setcookie('save', '', 100000);
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
        setcookie('names_error', '', 100000);
        setcookie('names_value', '', 100000);
        $messages[] = '<div class="error">Заполните имя.</div>';
    }

    if ($errors['phone']) {
        setcookie('phone_error', '', 100000);
        setcookie('phone_value', '', 100000);
        $messages[] = '<div class="error">Заполните телефон.</div>';
    }

    if ($errors['email']) {
        setcookie('email_error', '', 100000);
        setcookie('email_value', '', 100000);
        $messages[] = '<div class="error">Заполните почту.</div>';
    }

    if ($errors['date']) {
        setcookie('date_error', '', 100000);
        setcookie('date_value', '', 100000);
        $messages[] = '<div class="error">Заполните дату.</div>';
    }

    if ($errors['gender']) {
        setcookie('gender_error', '', 100000);
        setcookie('gender_value', '', 100000);
        $messages[] = '<div class="error">Заполните пол.</div>';
    }

    if ($errors['languages']) {
        setcookie('languages_error', '', 100000);
        setcookie('languages_value', '', 100000);
        $messages[] = '<div class="error">Заполните языки.</div>';
    }

    if ($errors['biography']) {
        setcookie('biography_error', '', 100000);
        setcookie('biography_value', '', 100000);
        $messages[] = '<div class="error">Заполните биографию.</div>';
    }

    if ($errors['agree']) {
        setcookie('agree_error', '', 100000);
        setcookie('agree_value', '', 100000);
        $messages[] = '<div class="error">Заполните соглашение.</div>';
    }

    $values = array();
    $values['names'] = empty($_COOKIE['names_value']) ? '' : $_COOKIE['names_value'];
    $values['phone'] = empty($_COOKIE['phone_value']) ? '' : $_COOKIE['phone_value'];
    $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
    $values['date'] = empty($_COOKIE['date_value']) ? '' : $_COOKIE['date_value'];
    $values['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
    $values['languages'] = empty($_COOKIE['languages_value']) ? '' : explode(',', $_COOKIE['languages_value']);
    $values['biography'] = empty($_COOKIE['biography_value']) ? '' : $_COOKIE['biography_value'];
    $values['agree'] = empty($_COOKIE['agree_value']) ? '' : ($_COOKIE['agree_value'] === '1');

    include('form.php');
} else {
    $errors = FALSE;
    if (empty($_POST['names'])) {
        setcookie('names_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    setcookie('names_value', $_POST['names'], time() + 30 * 24 * 60 * 60);
    if (empty($_POST['phone'])) {
        setcookie('phone_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    setcookie('phone_value', $_POST['phone'], time() + 30 * 24 * 60 * 60);

    if (empty($_POST['email'])) {
        setcookie('email_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);

    if (empty($_POST['date'])) {
        setcookie('date_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    setcookie('date_value', $_POST['date'], time() + 30 * 24 * 60 * 60);

    if (empty($_POST['gender'])) {
        setcookie('gender_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    setcookie('gender_value', $_POST['gender'], time() + 30 * 24 * 60 * 60);

    if (empty($_POST['languages'])) {
        setcookie('languages_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    $language_string = implode(",", $_POST['languages']);
    setcookie('languages_value', $language_string, time() + 30 * 24 * 60 * 60);

    if (empty($_POST['biography'])) {
        setcookie('biography_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    setcookie('biography_value', $_POST['biography'], time() + 30 * 24 * 60 * 60);

    if (empty($_POST['agree'])) {
        setcookie('agree_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    setcookie('agree_value', $_POST['agree'], time() + 30 * 24 * 60 * 60);

    if ($errors) {
        header('Location: index.php');
        exit();
    } else {
        setcookie('names_error', '', 100000);
        setcookie('phone_error', '', 100000);
        setcookie('email_error', '', 100000);
        setcookie('date_error', '', 100000);
        setcookie('gender_error', '', 100000);
        setcookie('languages_error', '', 100000);
        setcookie('biography_error', '', 100000);
        setcookie('agree_error', '', 100000);
    }

    $names = isset($_POST['names']) ? $_POST['names'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $date = isset($_POST['date']) ? $_POST['date'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $biography = isset($_POST['biography']) ? $_POST['biography'] : '';

    $user = 'u67309';
    $pass = '1824692';
    $db = new PDO('mysql:host=localhost;dbname=u67309', $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    try {
        $stmt = $db->prepare("INSERT INTO application (names,phone,email,date,gender,biography) VALUES (:names, :phone, :email, :date, :gender, :biography)");
        $stmt->execute(array('names' => $names, 'phone' => $phone, 'email' => $email, 'date' => $date, 'gender' => $gender, 'biography' => $biography));
        $id = $db->lastInsertId();

        $language_ids = array();
        $stmt = $db->prepare("SELECT id FROM languages WHERE title = :title");
        foreach ($_POST['languages'] as $language) {
            $stmt->execute(array('title' => $language));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $language_ids[] = $result['id'];
            } else {
                print('Error : language not found.');
                exit();
            }
        }

        $stmt = $db->prepare("INSERT INTO languages_app (app_id, languages_id) VALUES (:app_id, :languages_id)");
        foreach ($language_ids as $language_id) {
            $stmt->execute(array('app_id' => $id, 'languages_id' => $language_id));
        }
    } catch (PDOException $e) {
        print('Error : ' . $e->getMessage());
        exit();
    }

    setcookie('save', '1');
    header('Location: index.php');
}
?>
