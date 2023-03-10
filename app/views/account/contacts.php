<section class="register-form section">
   <div class="register-form__body container">
      <h2 class="register-form__title section-title">Send Post Form</h2>
      <form action="/account/contacts" class="form">
      <label class="form__title">
         Your Email
         <input  class="form__input" type="text" name="userEmail" id="userEmail">
      </label>
      <label class="form__title">
         Your Theme
         <input  class="form__input" type="text" name="userTheme" id="userTheme">
      </label>
      <label class="form__title">
         Your Message
         <textarea  class="form__textarea" type="text" name="userText" id="userText"></textarea>
      </label>


         <div class="block-error d-none"></div>
         <button class="form__button button">Register me!</button>
      </form>
   </div>
</section >