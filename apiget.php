<?
#ambil data json
#menampung requests
if(isset($_GET['user'])){
    $user=$_GET['user'];
    $db=$_GET['Database'];
    echo "data diterima";
    echo "nama user: $user";
    echo "nama database: $db";
}
  ?>
  <html>
    <input type="text" name="user" id="user">
    <input type="submit" value="kirim">
    <button onclick="kirim()">kirim</button>
  </html>