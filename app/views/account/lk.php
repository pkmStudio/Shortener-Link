<section class="personal-area section">
   <div class="personal-area__body container">
      <h2 class="personal-area__title section-title">Personal Area</h2>
      <p class="personal-area__text">Hallo, <?= $_SESSION['authorize']['login']; ?></p>
      <button class="personal-area__button button" id="exit-user" type="submit">Exit</button>
   </div>
</section >