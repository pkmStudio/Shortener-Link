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