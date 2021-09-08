<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
    <title>Noutati</title>
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
        let x = document.forms["addAnuntForm"]["text"].value;
        if (x == "") {
            alert("Anuntul nu poate fi gol");
            return false;
        }
    }
</script>

<body>
    <h1 align="center">Noutati</h1>

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
    /** Afisarea anunturilor */
    $query = "SELECT * FROM anunturi ORDER BY `data` DESC";
    $result = mysqli_query($conexiune, $query);
    if (mysqli_num_rows($result)) {
        print("<ul>\n");
        while ($row = mysqli_fetch_array($result)) {
            print("<li>\n");
            print("" . $row['data'] . "<b>          ");
            print("" . $row['text'] . "</b>\n");
            print("<a href='noutati.php?comanda=delete&id=" . $row['id'] . "'>Delete</a>\n");
            print("<a href='noutati.php?comanda=edit&id=" . $row['id'] . "'>Edit</a>\n");
            print("</li>\n");
        }
        print("</ul>");
    } else {
        print "Nu exista anunturi!";
    }
    ?>


    <?php
    $comanda = isset($_REQUEST['comanda']) ? $_REQUEST['comanda'] : "";
    if (!empty($comanda)) {
        switch ($comanda) {
            case 'add':
                $text = $_REQUEST["text"];
                $sql = "INSERT INTO anunturi(text, data) VALUES ('$text',now())";
                if (!mysqli_query($conexiune, $sql)) {
                    die('Error: ' . mysqli_error($conexiune));
                }
                echo "<div class='succes'>Intrare adaugata cu succes</div>";
                echo "<meta http-equiv='refresh' content='0'>";
                break;
            case 'delete':
                $id = $_REQUEST["id"];
                $sql = "DELETE FROM anunturi WHERE id=$id";
                if (!mysqli_query($conexiune, $sql)) {
                    die('Error: ' . mysqli_error($conexiune));
                }else{
                    echo "<div class='succes'>Intrarea cu id-ul $id a fost stearsa cu succes</div>";
                    // echo "<meta http-equiv='refresh' content='0'>";
                }
                break;
            case 'edit':
                $id = $_REQUEST["id"];
                $sql = "SELECT * FROM anunturi WHERE id=$id";
                $result = mysqli_query($conexiune, $sql);
                if ($row = mysqli_fetch_array($result)) {
                    $text = $row['text'];
    ?>
                    <!-- Forma de editare (begin) -->
                    <h3>Editare</h3>
                    <form action="noutati.php" method="post">
                        <input name="comanda" type="hidden" value="update" />
                        <input name="id" type="hidden" value="<?php echo $id; ?>" />
                        Anunt: <input type="text" name="text" value="<?php echo $text; ?>" />
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
                $text = $_REQUEST["text"];
                $sql = "UPDATE anunturi SET text='$text' WHERE id=$id";
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

    <!-- Forma de adaugare -->
    <form name="addAnuntForm" action="noutati.php" method="post" onsubmit="return validateText();">
        <input name="comanda" type="hidden" value="add" />
        Anunt: <input type="text" name="text" />
        <input type="submit" value="Submit" />
    </form>

</body>

</html>