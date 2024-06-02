<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Форма</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php
        if (!empty($messages)) {
            echo '<div class="messages">';
            foreach ($messages as $message) {
                echo $message;
            }
            echo '</div>';
        }
        ?>
        <form action="index.php" method="POST">
            <label>ФИО:
                <input type="text" name="names" placeholder="Введите ФИО" class="<?php echo $errors['names'] ? 'error' : ''; ?>" value="<?php echo $values['names']; ?>">
            </label><br>
            <label>Телефон:
                <input type="text" name="phone" placeholder="Введите номер телефона" class="<?php echo $errors['phone'] ? 'error' : ''; ?>" value="<?php echo $values['phone']; ?>">
            </label><br>
            <label>E-mail:
                <input type="email" name="email" placeholder="Введите e-mail" class="<?php echo $errors['email'] ? 'error' : ''; ?>" value="<?php echo $values['email']; ?>">
            </label><br>
            <label>Дата рождения:
                <input type="date" name="date" placeholder="дд.мм.гггг" class="<?php echo $errors['date'] ? 'error' : ''; ?>" value="<?php echo $values['date']; ?>">
            </label><br>
            <label>Укажите ваш пол:
                <input type="radio" name="gender" value="M" <?php echo ($values['gender'] == 'M') ? 'checked' : ''; ?>>М
                <input type="radio" name="gender" value="F" <?php echo ($values['gender'] == 'F') ? 'checked' : ''; ?>>Ж
            </label><br>
            <label>Укажите любимые языки программирования:
                <select name="languages[]" multiple class="<?php echo $errors['languages'] ? 'error' : ''; ?>">
                    <option value="Pascal" <?php echo in_array('Pascal', $values['languages']) ? 'selected' : ''; ?>>Pascal</option>
                    <option value="C" <?php echo in_array('C', $values['languages']) ? 'selected' : ''; ?>>C</option>
                    <option value="C++" <?php echo in_array('C++', $values['languages']) ? 'selected' : ''; ?>>C++</option>
                    <option value="JavaScript" <?php echo in_array('JavaScript', $values['languages']) ? 'selected' : ''; ?>>JavaScript</option>
                    <option value="PHP" <?php echo in_array('PHP', $values['languages']) ? 'selected' : ''; ?>>PHP</option>
                </select>
            </label><br>
            <label>Биография:
                <textarea name="biography" placeholder="Расскажите о себе" class="<?php echo $errors['biography'] ? 'error' : ''; ?>"><?php echo $values['biography']; ?></textarea>
            </label><br>
            <label>
                <input type="checkbox" name="agree" <?php echo $values['agree'] ? 'checked' : ''; ?>> С контрактом ознакомлен(а)
            </label><br>
            <input type="submit" value="Сохранить">
        </form>
    </div>
</body>
</html>
