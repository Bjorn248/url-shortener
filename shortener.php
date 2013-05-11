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
}

if (isset($_GET["code"])) {
    echo htmlspecialchars($_GET["code"]);
}
?>
