<?php if(isset($_SESSION['authorize']['login'])) :?>
   <!-- Секция с сокращением ссылок, если пользователь авторизован. -->
   <section class="short-link section">
      <div class="short-link__body container">

         <h2 class="section-title">ShortLink Form</h2>

         <form action="/link/add" class="short-link__form form">
            <label class="form__title">
               Enter your Link
               <input  class="form__input" type="text" name="longLink" id="LongLink">
            </label>

            <label class="form__title">
               Enter your Short Link after www/
               <input  class="form__input" type="text" name="shortLink" id="ShortLink">
            </label>

            <div class="block-error d-none"></div>
            <button class="form__button button">ShortLink!</button>
         </form>

         <div class="short-link__links-block">
            <h3 class="short-link__title">Сокращенные ссылки</h3>
            
            <!-- <div class="short-link__link-block">
               <p class="short-link__text">Длинная: <a class="short-link__link" href=""></a></p>
               <p class="short-link__text">Короткая: <a class="short-link__link" href=""></a></p>
               <button class="short-link__button button" type="button">Удалить</button>
            </div> -->
            
            <?php 
            if (isset($links)){
               foreach ($links as $link) {
                  echo "<div class='short-link__link-block'>
                  <p class='short-link__text'>Длинная: 
                  <a class='short-link__link' href='{$link->long_link}'>{$link->long_link}</a></p>
                  <p class='short-link__text'>Короткая: 
                  <a class='short-link__link' href='http://www/s/{$link->short_link}'>http://www/s/{$link->short_link}</a></p>
                  <button class='short-link__button button' type='button' id = '{$link->short_link}'>Удалить</button></div>";
               }
            }
            ?>
         </div>
      </div>
   </section >
<?php else : ?>
      <!-- Секция с регистрацией, если пользователь не авторизован. -->
   <section class="register-form section">
      <div class="register-form__body container">
         <h2 class="register-form__title section-title">Register Form</h2>
         <form action="/account/register" class="form">
            <label class="form__title">
               Login
               <input  class="form__input" type="text" name="userLogin" id="userLogin">
            </label>
            <label class="form__title">
               Password
               <input  class="form__input" type="password" name="userPassword" id="userPassword">
            </label>
            <label class="form__title">
               Repeat Password
               <input  class="form__input" type="password" name="userRepeatPassword" id="userRepeatPassword">
            </label>
            <div class="block-error d-none"></div>
            <button class="form__button button">Register me!</button>
         </form>
      </div>
   </section >
<?php endif; ?>