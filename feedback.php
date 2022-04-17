<link rel="stylesheet" href="styles.css">

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

<form>
  <div class="form-group">
    <label>Wie hat es dir gefallen?</label> <select class="form-control" name="satisfaction">
      <option value="5">
        Es war großartig!
      </option>

      <option value="4">
        Es war toll
      </option>

      <option value="3">
        Es war unterhaltsam
      </option>

      <option value="2">
        Es war nicht so toll
      </option>

      <option value="1">
        Es war schrecklich!
      </option>
    </select>
  </div>

  <div class="form-group">
    <label>Was könnten wir nächstes Jahr verbessern?</label> 
    <textarea class="form-control" name="betternexttime" placeholder="Gib uns hier dein Feedback">
</textarea>
  </div>

  <div class="form-group">
    <input type="submit" class="btn btn-primary" name="submit" value="Feedback senden">
  </div>
</form>

<p><a href="index.php" class="button">Neu anstellen</a></p>

<?php
    include 'layout/footer.php';
?>
