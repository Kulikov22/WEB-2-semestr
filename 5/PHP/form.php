<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Задание 5</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
  <?php  
    if (!empty($messages)) {
      print('<div class="messages">');
      foreach ($messages as $message) {
        print($message);
      }
      print('</div>');
    }
  ?>

  <div class="container">
    <h2>Форма</h2>
    <form action="" method="POST">
      Имя:<br><input type="text" name="names" <?php if (!empty($errors['name'])) {print 'class="group error"';} else print 'class="group"'; ?> value="<?php print isset($values['name']) ? htmlspecialchars($values['name']) : ''; ?>">
      <br>
      Телефон:<br><input type="tel" name="phones" <?php if (!empty($errors['phones'])) {print 'class="group error"';} else print 'class="group"'; ?> value="<?php print isset($values['phones']) ? htmlspecialchars($values['phones']) : ''; ?>">
      <br>
      E-mail:
        <br><input type="text" name="email" <?php if (!empty($errors['email'])) {print 'class="group error"';} else print 'class="group"'; ?> value="<?php print isset($values['email']) ? htmlspecialchars($values['email']) : ''; ?>"><br>
      Дата рождения:
      <div class="form-group">
        <input type="date" id="data" size="3" name="data" <?php if (!empty($errors['data'])) {print 'class="group error"';} else print 'class="group"';?> value="<?php print isset($values['data']) ? htmlspecialchars($values['data']) : ''; ?>">
      </div>
      <div <?php if (!empty($errors['gender'])) {print 'class="error"';} ?>>
        Пол:<br>
        <input class="radio" type="radio" name="gender" value="M" <?php if (isset($values['gender']) && $values['gender'] == 'M') {print 'checked';} ?>> Мужской
        <input class="radio" type="radio" name="gender" value="W" <?php if (isset($values['gender']) && $values['gender'] == 'W') {print 'checked';} ?>> Женский
      </div>
      Любимый язык программирования:<br>
      <select class="group" name="languages[]" size="10" multiple>
        <option value="Pascal" <?php if (isset($values['languages']) && in_array("Pascal", $values['languages'])) {print 'selected';} ?>>Pascal</option>
        <option value="C" <?php if (isset($values['languages']) && in_array("C", $values['languages'])) {print 'selected';} ?>>C</option>
        <option value="C_plus_plus" <?php if (isset($values['languages']) && in_array("C_plus_plus", $values['languages'])) {print 'selected';} ?>>C++</option>
        <option value="JavaScript" <?php if (isset($values['languages']) && in_array("JavaScript", $values['languages'])) {print 'selected';} ?>>JavaScript</option>
        <option value="PHP" <?php if (isset($values['languages']) && in_array("PHP", $values['languages'])) {print 'selected';} ?>>PHP</option>
        <option value="Python" <?php if (isset($values['languages']) && in_array("Python", $values['languages'])) {print 'selected';} ?>>Python</option>
        <option value="Java" <?php if (isset($values['languages']) && in_array("Java", $values['languages'])) {print 'selected';} ?>>Java</option>
        <option value="Haskel" <?php if (isset($values['languages']) && in_array("Haskel", $values['languages'])) {print 'selected';} ?>>Haskel</option>
        <option value="Clojure" <?php if (isset($values['languages']) && in_array("Clojure", $values['languages'])) {print 'selected';} ?>>Clojure</option>
        <option value="Prolog" <?php if (isset($values['languages']) && in_array("Prolog", $values['languages'])) {print 'selected';} ?>>Prolog</option>
      </select>
      <br>
      Биография:<br><textarea class="group" name="biography" rows="3" cols="30"><?php print isset($values['biography']) ? htmlspecialchars($values['biography']) : ''; ?></textarea>
      <div  <?php if (!empty($errors['agree'])) {print 'class="error"';} ?>>
        <input type="checkbox" name="agree" <?php if (isset($values['agree']) && $values['agree']) {print 'checked';} ?> value="1"> С контрактом ознакомлен(a) 
      </div>
      <input type="submit" id="send" value="ОТПРАВИТЬ">
    </form>
  </div>
  
  <div class="container">
    <?php
      if (!empty($_COOKIE[session_name()]) && !empty($_SESSION['login']))
        print('<a href="login.php" class="enter-exit" title="Log out">Выйти</a>');
      else
        print('<a href="login.php" class="enter-exit" title="Log in">Войти</a>');
    ?>
  </div>
</body>
</html>
