<?php
$server="localhost";
$username="root";
$password="";
$my_db="piotr_dzieci";
$conn=mysqli_connect($server,$username,$password,$my_db);
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Pioter</title>
  </head>
  <body>
    <div class="container">
      <div class="row">
<?php

if(!$conn){die("Problem z połączeniem z bazą danych".mysqli_connect_error());
}else{ echo "Połączono z bazą danych";}

$url = $_SERVER['REQUEST_URI'];

if(strpos($url, 'tabela_bazy2.php?dodaj') === false){
echo '<div class="mt-3"><a href="tabela_bazy2.php?dodaj" class="btn btn-outline-primary" role="button">Dodaj</a></div>';
}
if(strpos($url, 'tabela_bazy2.php?usun=') !== false) {
  echo '
        <div class="bd-example bg-light fixed-top">
        <div class="position-fixed top-50 start-50 translate-middle">
        <div class="progress">
          <div id="myBar" class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="text-align: start; width: 100%;"></div>
        </div>
          <div id="liveToast" class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
              <svg class="bd-placeholder-img rounded me-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#FF0000"></rect></svg>
              <strong class="me-auto">Usuń</strong>
              <small>zamknie za <span id="czas">5</span></small>
              <a href="tabela_bazy2.php" type="button" class="btn-close" aria-label="Close"></a>
              <meta http-equiv="refresh" content="5; url=tabela_bazy2.php">
            </div>
            <div class="toast-body">
              <div class="toast-header">
              Usunięto rekord o numerze pesel: '.$pesel=$_REQUEST['usun'];
              $zap2 = "DELETE FROM dzieci WHERE pesel='$pesel'";
              $wynik2 = mysqli_query($conn, $zap2);
              echo mysqli_error($conn).'
            </div>
            </div>
          </div>
        </div>
        </div>
        ';
}else if(strpos($url, 'tabela_bazy2.php?dodaj') !== false){
if(isset($_POST['zapisz']))
{
  $pesel=$_POST['pesel'];
  $imie=$_POST['imie'];
  $nazwisko=$_POST['nazwisko'];
  $plec=$_POST['plec'];
  $wiek=$_POST['wiek'];
  $pesel=$_REQUEST['pesel'];
  $zap = "INSERT INTO dzieci (pesel, imie, nazwisko, plec, wiek) VALUES ('$pesel', '$imie', '$nazwisko', '$plec', '$wiek')";
  if(mysqli_query($conn, $zap)==true){
  echo '<div class="bd-example bg-light fixed-top">
  <div class="position-fixed top-50 start-50 translate-middle">
  <div class="progress">
    <div id="myBar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="text-align: start; width: 100%;"></div>
  </div>
    <div id="liveToast" class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header">
        <svg class="bd-placeholder-img rounded me-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="true"><rect width="100%" height="100%" fill="#0000FF"></rect></svg>
        <strong class="me-auto">Dodaj</strong>
        <small>zamknie za <span id="czas">5</span></small>
        <a href="tabela_bazy2.php" type="button" class="btn-close" aria-label="Close"></a>
        <meta http-equiv="refresh" content="5; url=tabela_bazy2.php">
      </div>
      <div class="toast-body">
        <div class="toast-header">
          Utworzono nowy rekord o numerze pesel: '.$pesel.'
        </div>
      </div>
    </div>
  </div>
</div>';
}else{
  echo '<div class="alert-danger" role="alert">Nie utworzono nowego rekordu</div>';
  echo mysqli_error($conn);

}
}
?>
<form class="was-validated" method="post">

  <div class="form-floating mt-5">
    <input maxlength="12" pattern="p+[0-9]{11}" class="form-control is-invalid" placeholder="a" name="pesel" required>
    <label for="floatingInput">pesel</label>
  </div>

  <div class="form-floating mt-3">
    <input maxlength="50" class="form-control is-invalid" placeholder="a" name="imie" required>
    <label for="floatingInput">imie</label>
  </div>

  <div class="form-floating mt-3">
    <input maxlength="50" class="form-control is-invalid" placeholder="a" name="nazwisko" required>
    <label for="floatingInput">nazwisko</label>
  </div>

  <div class="mt-3">
    <select class="form-select" aria-label="select example" name="plec" required>
      <option value="" selected>płeć</option>
      <option value="chlopiec">chlopiec</option>
      <option value="dziewczynka">dziewczynka</option>
    </select>
  </div>

  <div class="form-floating mt-3">
    <input type="number" maxlength="1" class="form-control is-invalid" placeholder="a" name="wiek" oninput="if (this.value.length = this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>
    <label for="floatingInput">wiek</label>
  </div>
  <div class="mt-3"><button type="submit" name="zapisz" class="btn btn-outline-success">Zapisz</button>
  <a href="tabela_bazy2.php" class="btn btn-outline-primary" role="button">Anuluj</a></div>
</form>
<?php
}else if(strpos($url, 'tabela_bazy2.php?edytuj=') !== false){
  $pesel=$_REQUEST['edytuj'];
  $zap2 = "SELECT * FROM dzieci WHERE pesel='$pesel'";
  $wynik2 = mysqli_query($conn, $zap2);
  $row2 = mysqli_fetch_array($wynik2);
  $imie=$row2['imie'];
  $nazwisko=$row2['nazwisko'];
  $plec=$row2['plec'];
  $wiek=$row2['wiek'];
  if(isset($_POST['zapisz']))
  {
    $imie=$_POST['imie'];
    $nazwisko=$_POST['nazwisko'];
    $plec=$_POST['plec'];
    $wiek=$_POST['wiek'];
    $zap3 = "UPDATE dzieci SET imie='$imie', nazwisko='$nazwisko', plec='$plec', wiek='$wiek' WHERE pesel='$pesel'";
    if(mysqli_query($conn, $zap3)==true){
      echo '<div class="bd-example bg-light fixed-top">
      <div class="position-fixed top-50 start-50 translate-middle">
      <div class="progress">
        <div id="myBar" class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="text-align: start; width: 100%;"></div>
      </div>
        <div id="liveToast" class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="toast-header">
            <svg class="bd-placeholder-img rounded me-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#FFF000"></rect></svg>
            <strong class="me-auto">Edytuj</strong>
            <small>zamknie za <span id="czas">5</span></small>
            <a href="tabela_bazy2.php" type="button" class="btn-close" aria-label="Close"></a>
            <meta http-equiv="refresh" content="5; url=tabela_bazy2.php">
          </div>
          <div class="toast-body">
            <div class="toast-header">
              Edytowano rekord o numerze pesel: '.$pesel.'
            </div>
          </div>
        </div>
      </div>
    </div>';
  }else{
    echo '<div class="alert-danger" role="alert">Dane nie zostały edytowane</div>';
    echo mysqli_error($conn);
    echo'<meta http-equiv="refresh" content="2; url=tabela_bazy2.php">';
  }
  }
  ?>
  <form class="was-validated" method="POST">

    <div class="form-floating mt-3">
      <input class="form-control is-valid" value="<?php echo $pesel; ?>" disabled>
      <label for="floatingInput">pesel</label>
    </div>

    <div class="form-floating mt-3">
      <input maxlength="50" class="form-control is-invalid" placeholder="a" name="imie" value="<?php echo $imie; ?>" required>
      <label for="floatingInput">imie</label>
    </div>

    <div class="form-floating mt-3">
      <input maxlength="50" class="form-control is-invalid" placeholder="a" name="nazwisko" value="<?php echo $nazwisko; ?>" required>
      <label for="floatingInput">nazwisko</label>
    </div>

    <div class="mt-3">
      <select class="form-select" aria-label="select example" name="plec" required>
        <?php if($plec=='chlopiec'){
          echo '<option value="chlopiec" selected>chlopiec</option>
          <option value="dziewczynka">dziewczynka</option>';
        }else{
          echo '<option value="chlopiec">chlopiec</option>
          <option value="dziewczynka" selected>dziewczynka</option>';
        }
        ?>
      </select>
    </div>

    <div class="form-floating mt-3">
      <input type="number" maxlength="1" class="form-control is-invalid" placeholder="a" name="wiek" value="<?php echo $wiek; ?>" oninput="if (this.value.length = this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>
      <label for="floatingInput">wiek</label>
    </div>
    <div class="mt-3">
      <button type="submit" name="zapisz" class="btn btn-outline-success">Zapisz</button>
      <a href="tabela_bazy2.php" class="btn btn-outline-warning" role="button">Anuluj</a>
    </div>
  </form>
  <?php
}

$zap="SELECT * FROM dzieci";
$wynik=mysqli_query($conn,$zap);

echo '<div class="table-responsive">
<table class="table table-dark table-striped mt-3">
<thead>
<tr>
<th>pesel</th>
<th>imie</th>
<th>nazwisko</th>
<th>płeć</th>
<th>wiek</th>
<th></th>
<th></th>
</tr>
</thead>';
while($row=mysqli_fetch_array($wynik)){
echo "<tr><td>".$row['pesel']."</td>";
echo "<td>".$row['imie']."</td>";
echo "<td>".$row['nazwisko']."</td>";
echo "<td>".$row['plec']."</td>";
echo "<td>".$row['wiek']."</td>";
echo '<td><a href="tabela_bazy2.php?edytuj='.$row["pesel"].'" class="btn btn-outline-warning" role="button">Edytuj</a></td>';
echo '<td><a href="tabela_bazy2.php?usun='.$row["pesel"].'" class="btn btn-outline-danger" role="button">Usuń</a></td></tr>';
}
echo '</table>
</div>';

?>
</div>
</div>
<p id="czas" class="text-white">0</p>
<script>
var czas = document.getElementById("czas");
  var stoper = function() {
    var time = parseFloat(czas.textContent);
    if (time > 0) {
       czas.textContent = time - 1;
    } else {
        window.clearInterval(timer);
    }
  };
  var timer = window.setInterval(stoper, 1000);
  var elem = document.getElementById("myBar");
  var width = 100;
  var id = setInterval(frame, 46);
  function frame() {
    if (width <= 0) {
      clearInterval(id);
    } else {
      width--;
      elem.style.width = width + "%";
    }
  }
</script>

<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
-->
</body>
</html>
