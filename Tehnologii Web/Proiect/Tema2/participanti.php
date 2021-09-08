<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
    <title>Participanti</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>


<!-- Script pentru validarea numelui concurentului -->
<script type="text/javascript">
    function validateName() {
        let x = document.forms["addConcurentForm"]["nume"].value;
        if (x == "") {
            alert("Trebuie sa introduci un nume");
            return false;
        }
    }
</script>

<body>
    <h1 align="center">Participanti</h1>

    <div align="center">
        <a href="home.html">Home</a>
        <a href="regulament.html">Regulament</a>
        <a href="organizatori.html">Organizatori</a>
        <a href="sponsori.html">Sponsori</a>
        <a href="noutati.php">Noutati</a>
        <a href="participanti.php">Participanti</a>
        <a href="subiecte.html">Subiecte</a>
        <a href="rezultate.php">Rezultate</a>
        <a href="contact.html">Contact</a>
    </div>


    <?php
    include "header.php";
    require_once "connect.php";
    ?>

    <?php
    $comanda = isset($_REQUEST['comanda']) ? $_REQUEST['comanda'] : "";
    if (!empty($comanda)) {
        $nume = $_REQUEST["nume"];

        $query = "SELECT * FROM participanti WHERE nume='$nume'";
        $result = mysqli_query($conexiune, $query);
        if (mysqli_num_rows($result)) {
            echo "<div class='error'>Concurentul $nume a fost deja inregistrat</div>";
        } else {
            $sql = "INSERT INTO participanti(nume) VALUES ('$nume')";
            if (!mysqli_query($conexiune, $sql)) {
                die('Error: ' . mysqli_error($conexiune));
            }
            echo "<div class='succes'>Concurent inregistrat cu succes</div>";
        }
    }
    ?>

    <br><br>
    <p>Inscrie-te</p>

    <!-- Forma de adaugare -->
    <form name="addConcurentForm" method="post" onsubmit="return validateName();">
        <input name="comanda" type="hidden" value="add" />
        Nume: <input type="text" name="nume" />
        <input type="submit" value="Submit" />
    </form>

    <br><br>

    <p>Tabel participanti:</p>

    <?php
    /** Afisarea concurentilor */
    $query = "SELECT * FROM participanti";
    $result = mysqli_query($conexiune, $query);
    if (mysqli_num_rows($result)) {
        print("<table border='1' cellspacing='1' cellpadding='10'>\n");
        print("<tr>\n");
        print("<th>ID</th>
        <th width='300'>Nume</th>");
        print("</tr>\n");
        while ($row = mysqli_fetch_array($result)) {
            print("<tr>\n");
            print("<td>" . $row['id'] . "</td>\n");
            print("<td>" . $row['nume'] . "</td>\n");
            print("</tr>\n");
        }
        print("</table>");
    } else {
        print "Nu exista intrari in agenda!";
    }
    ?>

</body>

</html>