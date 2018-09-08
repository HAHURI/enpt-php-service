<?php echo '<h2>DockerベースのまっさらなPHPのてんぷれーと</h2>'; ?>
<?php
echo '<p>Postgresへの接続をテストするよ！</p>';
$dsn = 'pgsql:dbname=postgres;host=enpt-service_pgsql_1;port=5432';
$user = 'postgres';
$pass = 'example';

try {
    $dbh = new PDO($dsn, $user, $pass);
    $sql = 'SELECT CURRENT_TIMESTAMP';
    foreach ($dbh->query($sql) as $row) {
        print "接続できているよ！<br/>現在時間は" . $row[0] . "です。\n";
    }
    $dbh = null;
} catch (PDOException $e){
    print('接続できていないみたい！理由は以下の通り！<br/>[ERROR] ' . $e->getMessage() . "\n");
    die();
}

?>
