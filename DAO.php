<?php
class DAO {
  private $servername;
  private $username;
  private $password;
  private $dbname;
  private $conn;

  public function __construct() {
    $this->servername = "localhost";
    $this->username = "test";
    $this->password = "password";
    $this->dbname = "test";
    $this->createConnection();
  }

  public function createUser($name, $email) {
    $sql = "SELECT id FROM users WHERE name='$name'";
    $result = mysqli_query($this->conn, $sql);

    if($result->num_rows == 0) {
      $id = md5(uniqid(rand(), true));

      $sql = "INSERT INTO users (id, name, email) VALUES ('$id', '$name', '$email')";

      if ($this->conn->query($sql) === TRUE) {
        echo "<div>New user created successfully</div>";
      }
      else {
        echo "<div>Error: " . $sql . $this->conn->error . "</div>";
      }
    }
    else {
      echo '<div>Error: user already exists </div>';
    }
  }

  public function deleteUser($id) {
    $sql = "SELECT id FROM users WHERE id='$id'";
    $result = mysqli_query($this->conn, $sql);

    if($result->num_rows != 0) {
      $sql = "DELETE FROM users WHERE id='$id'";

      if ($this->conn->query($sql) === TRUE) {
        echo "<div>User deleted successfully</div>";
      }
      else {
        echo "<div>Error: " . $sql . $this->conn->error . "</div>";
      }
    }
    else {
      echo '<div>Error: user does not exist</div>';
    }
  }

  public function displayUsers() {
    $sql = "SELECT * FROM users";
    $result = mysqli_query($this->conn, $sql);
    echo "<h2> Table of Users </h2>";
    echo "<table border='1'>";
    echo "<tr> <th>ID</th> <th>NAME</th> <th>EMAIL</th> </tr>";
    while ($row = mysqli_fetch_assoc($result)) {
      echo "<tr>";
      foreach ($row as $field => $value) {
        echo "<td>" . $value . "</td>";
      }
      echo "</tr>";
    }
    echo "</table>";
  }

  public function createConnection() {
    $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
  }

  public function closeConnection() {
    $this->conn->close();
  }
}
?>
