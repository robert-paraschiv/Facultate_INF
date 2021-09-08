<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
    <title>Rezultate</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>




<style>
    li,
    p {
        line-height: 1.3;
    }
</style>

<!-- Script pentru validarea textului anuntului -->
<script type="text/javascript">
    function validateText() {
        let x = document.forms["addRezultatForm"]["text"].value;
        if (x == "") {
            alert("Anuntul nu poate fi gol");
            return false;
        }
    }
</script>

<body>
    <h1 align="center">Rezultate</h1>

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
    /** Afisarea rezultatelor */
    $query = "SELECT * FROM rezultate ORDER BY `media` DESC";
    $result = mysqli_query($conexiune, $query);
    if (mysqli_num_rows($result)) {
        print("<table border='1' cellpadding='10' cellspacing='1'>
        <tr>
            <th rowspan='2' width='200'>Nume</th>
            <th colspan='3' width='150'>Note</th>
            <th rowspan='2'>Media</th>
            <th rowspan='2'>Actiuni</th>
        </tr>
        <tr>
            <th>Subiect 1</th>
            <th>Subiect 2</th>
            <th>Subiect 3</th>
        </tr>\n");

        while ($row = mysqli_fetch_array($result)) {
            print("<tr>\n");
            print("<td>" . $row['nume'] . "</td>");
            print("<td align='right'>" . $row['nota1'] . "</td>\n");
            print("<td align='right'>" . $row['nota2'] . "</td>\n");
            print("<td align='right'>" . $row['nota3'] . "</td>\n");
            print("<td align='right'>" . $row['media'] . "</td>\n");
            print("<td><a href='rezultate.php?comanda=delete&id=" . $row['id'] . "'>Delete</a>\n");
            print("<a href='rezultate.php?comanda=edit&id=" . $row['id'] . "'>Edit</a></td>\n");
            print("</tr>\n");

            //     <tr>
            //     <td>2</td>
            //     <td>Maria Ionescu</td>
            //     <td align="right">8</td>
            //     <td align="right">8</td>
            //     <td align="right">8</td>
            //     <td align="right">8</td>
            //     </tr>
        }
        print("</table>");
    } else {
        print "Nu exista rezultate!";
    }
    ?>


    <?php

    function calculeazaMedia($a, $b, $c)
    {
        return ($a + $b + $c) / 3;
    }
    $comanda = isset($_REQUEST['comanda']) ? $_REQUEST['comanda'] : "";
    if (!empty($comanda)) {
        switch ($comanda) {
            case 'add':
                $nume = $_REQUEST["nume"];
                $nota1 = $_REQUEST["nota1"];
                $nota2 = $_REQUEST["nota2"];
                $nota3 = $_REQUEST["nota3"];
                $media = calculeazaMedia($nota1, $nota2, $nota3);
                $sql = "INSERT INTO rezultate(nume, nota1, nota2, nota3, media) VALUES ('$nume ','$nota1','$nota2','$nota3','$media')";
                if (!mysqli_query($conexiune, $sql)) {
                    die('Error: ' . mysqli_error($conexiune));
                }
                echo "<div class='succes'>Intrare adaugata cu succes</div>";
                echo "<meta http-equiv='refresh' content='0'>";
                break;
            case 'delete':
                $id = $_REQUEST["id"];
                $sql = "DELETE FROM rezultate WHERE id=$id";
                if (!mysqli_query($conexiune, $sql)) {
                    die('Error: ' . mysqli_error($conexiune));
                } else {
                    echo "<div class='succes'>Intrarea cu id-ul $id a fost stearsa cu succes</div>";
                    // echo "<meta http-equiv='refresh' content='0'>";
                }
                break;
            case 'edit':
                $id = $_REQUEST["id"];
                $sql = "SELECT * FROM rezultate WHERE id=$id";
                $result = mysqli_query($conexiune, $sql);
                if ($row = mysqli_fetch_array($result)) {
                    $nume = $row['nume'];
                    $nota1 = $row['nota1'];
                    $nota2 = $row['nota2'];
                    $nota3 = $row['nota3'];
    ?>
                    <!-- Forma de editare (begin) -->
                    <h3>Editare</h3>
                    <form action="rezultate.php" method="post">
                        <input name="comanda" type="hidden" value="update" />
                        <input name="id" type="hidden" value="<?php echo $id; ?>" />
                        Nume: <input type="text" name="nume" value="<?php echo $nume; ?>" />
                        Nota subiect 1: <input type="text" name="nota1" value=" <?php echo $nota1; ?>" />
                        Nota subiect 2: <input type="text" name="nota2" value="<?php echo $nota2; ?>" />
                        Nota subiect 3: <input type="text" name="nota3" value="<?php echo $nota3; ?>" />
                        <input type="submit" value="Update" />
                    </form>
                    <br><br>
                    <!-- Forma de editare (end) -->
    <?php
                } else {
                    echo "<div class='error'>Intrarea cu id-ul $id nu exista!</div>";
                }
                break;
            case 'update':
                $id = $_REQUEST["id"];
                $nume = $_REQUEST["nume"];
                $nota1 = $_REQUEST["nota1"];
                $nota2 = $_REQUEST["nota2"];
                $nota3 = $_REQUEST["nota3"];
                $media = calculeazaMedia($nota1, $nota2, $nota3);
                $sql = "UPDATE rezultate SET nume='$nume',nota1='$nota1',nota2='$nota2',nota3='$nota3',media='$media' WHERE id=$id";
                if (!mysqli_query($conexiune, $sql)) {
                    die('Error: ' . mysqli_error($conexiune));
                    echo "<div class='error'>A aparut o eroare la actualizarea intrarii cu id-ul $id</div>";
                } else {
                    echo "<div class='succes'>Intrarea cu id-ul $id a fost actualizata cu succes!</div>";
                    echo "<meta http-equiv='refresh' content='0'>";
                }
                break;
        }
    }
    ?>

    <br><br>
    <p><b>Adauga rezultat</b></p>
    <!-- Forma de adaugare -->
    <form name="addRezulatForm" action="rezultate.php" method="post" onsubmit="return validateText();">
        <input name="comanda" type="hidden" value="add" />
        Nume: <input type="text" name="nume" />
        Nota subiect 1: <input type="text" name="nota1" />
        Nota subiect 2: <input type="text" name="nota2" />
        Nota subiect 3: <input type="text" name="nota3" />
        <input type="submit" value="Submit" />
    </form>

</body>






<!-- <body>
    <h1 align="center">Rezultate</h1>

    <div align="center">
        <a href="home.html">Home</a>
        <a href="regulament.html">Regulament</a>
        <a href="organizatori.html">Organizatori</a>
        <a href="sponsori.html">Sponsori</a>
        <a href="rezultate.php">rezultate</a>
        <a href="participanti.php">Participanti</a>
        <a href="subiecte.html">Subiecte</a>
        <a href="rezultate.html">Rezultate</a>
        <a href="contact.html">Contact</a>
    </div>


    <table border="1" cellpadding="10" cellspacing="1">
        <tr>
            <th rowspan="2">Nr.</th>
            <th rowspan="2" width="200">Nume</th>
            <th colspan="3" width="150">Note</th>
            <th rowspan="2">Media</th>
        </tr>
        <tr>
            <th>Subiect 1</th>
            <th>Subiect 2</th>
            <th>Subiect 3</th>
        </tr>
        <tr>
            <td>1</td>
            <td>Mihai Popa</td>
            <td align="right">10</td>
            <td align="right">10</td>
            <td align="right">10</td>
            <td align="right">10</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Maria Ionescu</td>
            <td align="right">8</td>
            <td align="right">8</td>
            <td align="right">8</td>
            <td align="right">8</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Andrei Ionescu</td>
            <td align="right">7</td>
            <td align="right">7</td>
            <td align="right">7</td>
            <td align="right">7</td>
        </tr>
    </table>
</body> -->

</html>