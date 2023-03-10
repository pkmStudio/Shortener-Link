<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/public/src/img/cat.ico" type="image/x-icon">
    <!-- Подключаем шрифты -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Yanone+Kaffeesatz:wght@300;400;700&display=swap" rel="stylesheet" />
    <!-- Обнуление CSS -->
    <link rel="stylesheet" href="/public/src/css/zero.css">
    <link rel="stylesheet" href="/public/src/css/style.css">
    <title><?=$title;?></title>
</head>

<body>

    <header class="header">
        <div class="header__body container">
            <div class="header__logo">
                <img class="logo" src="/public/src/img/logocat.png" alt="Кот">
                <p class="site-name">Let's remove all the extra of your link!</p>
            </div>
            <ul class="nav">
                <li class="nav__list"><a href="/" class="nav__link">Главная</a></li>
                <li class="nav__list"><a href="/about" class="nav__link">Про нас</a></li>
                <!-- Если авторизован, то отображать это -->
            <?php if(isset($_SESSION['authorize']['login'])) :?>
                <li class="nav__list"><a href="/account" class="nav__link">Личный кабинет</a></li>
                <li class="nav__list"><a href="/account/contacts" class="nav__link">Контакты</a></li>
                <!-- Иначе это -->
            <?php else : ?>
                <li class="nav__list"><a href="/account/login" class="nav__link">Войти</a></li>
                <li class="nav__list"><a href="/account/register" class="nav__link">Зарегистрироваться</a></li>
            <?php endif; ?>
            </ul>
        </div>
    </header>

    <main class="main">
        <?=$content;?>
    </main >

    <footer class="footer">
        <div class="footer__body container">
            <p class="footer__text">All rights reserved &COPY;</p>
        </div>
        
    </footer>


    <!-- Тут я работаю -->
    <script src="/public/src/js/script.js"></script>
</body>

</html>