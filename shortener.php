<?php
// Create connection
// fill with appropriate server, user, password, and db name
$con = new mysqli("localhost","pananda","b4ck3nd5y5a433","shorten");

// Check connection
if ($con->connect_errno)
{
  echo "Failed to connect to MySQL: (" . $con->connect_errno . ") " . $con->connect_error;
}

if (isset($_GET["URL"])) {
    $URL = htmlspecialchars($_GET["URL"]);
    $query = $con->prepare('INSERT INTO url_mapping (URL) VALUES (?)');
    $query->bind_param('s', $URL);

    $query->execute();
    $query->close();
    $urlID = base_convert($con->insert_id, 10, 36);
    $returnURL = $_SERVER["HTTP_HOST"] . "/$urlID";
    ?>
    <script language="JavaScript">
      function selectText(textField) 
      {
        textField.focus();
        textField.select();
      }
    </script>
    <?php

    echo "<center><h1>Shortened URL</h1><input type=\"text\" name=\"returnURL\" size=\"100\" value=$returnURL onClick='selectText(this);'></center>";
}

elseif (isset($_GET["code"])) {
    // decided to switch up the query operation here :3
    $urlID = base_convert($_GET["code"], 36, 10);
    $result = mysqli_query($con, "SELECT URL FROM url_mapping WHERE url_id=$urlID");
    $retArr = mysqli_fetch_array($result);
    if(isset($retArr['URL'])) {
        $redirect = $retArr['URL'];
        header( "Location:$redirect");
    }
    else {
        echo "not a valid url ID!";
    }
    // echo print_r($con, TRUE);
}
else {
    header( 'Location: /');
}
?>
