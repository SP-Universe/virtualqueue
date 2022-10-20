<?php
    include 'layout/header.php';

    require 'main.php';

    connectmysql();
    $guestid = checkforcookie();

    if($guestid != null)
    {
        remove_guest($guestid);
        close_connection();
    }
?>

<h2>VIELEN DANK FÜR DEINEN BESUCH!</h2>

<p>Wie hat dir die Show gefallen? Können wir etwas verbessern? Hinterlasse uns gerne hier Feedback oder rede mit unseren Mitarbeitern:</p>

<br>

<form method="post" action="feedback_sent.php">

  <div class="container">
  <div class="feedback">
    <p>Wie hat dir die Show gefallen?</p>
    <div class="rating">
      <input type="radio" name="rating" id="rating-5" value="5">
      <label for="rating-5"></label>
      <input type="radio" name="rating" id="rating-4" value="4">
      <label for="rating-4"></label>
      <input type="radio" name="rating" id="rating-3" value="3">
      <label for="rating-3"></label>
      <input type="radio" name="rating" id="rating-2" value="2">
      <label for="rating-2"></label>
      <input type="radio" name="rating" id="rating-1" value="1">
      <label for="rating-1"></label>
      <div class="emoji-wrapper">
        <div class="emoji">
          <img class="rating-0" src="app/client/src/images/hw40a_emoji_neutral.svg" alt="Logo des Halloweenhauses">
          <img class="rating-1" src="app/client/src/images/hw40a_emoji_reallysad.svg" alt="Logo des Halloweenhauses">
          <img class="rating-2" src="app/client/src/images/hw40a_emoji_sad.svg" alt="Logo des Halloweenhauses">
          <img class="rating-3" src="app/client/src/images/hw40a_emoji_neutral.svg" alt="Logo des Halloweenhauses">
          <img class="rating-4" src="app/client/src/images/hw40a_emoji_happy.svg" alt="Logo des Halloweenhauses">
          <img class="rating-5" src="app/client/src/images/hw40a_emoji_reallyhappy.svg" alt="Logo des Halloweenhauses">
        </div>
      </div>
    </div>
  </div>
</div>

  <div class="form-group">
    <label>Was könnten wir nächstes Jahr verbessern?</label> 
    <textarea rows="3" cols="33" class="form-control" name="text"></textarea>
  </div>

  <div class="form-group">
    <label>Wie hast du von unserem Halloweenhaus gehört?</label> 
    <textarea rows="3" cols="33" class="form-control" name="text"></textarea>
  </div>

  <div class="form-group">
    <input type="submit" class="btn btn-primary" name="submit" value="Feedback senden">
  </div>
</form>

<p><a href="leavequeuetowebsite.php" class="button">Besuche unsere Webseite!</a></p>

<?php
    include 'layout/footer.php';
?>
