<?php

class Singleton
{
    // instance PDO di simpan sebagai variabel static
    protected static ?PDO $_singleton = null;

    private string $name;

    private string $user;

    private string $password;


    public function __construct(string $name, string $user, string $password)
    {
        $this->name = $name;
        $this->user = $user;
        $this->password = $password;
        $this->setConnection();
    }

    
    public static function getSingleton() : ?PDO
    {
        // di sini proses pengecekan jika variabel $_singleton sudah terdapat instance pdo sebelumnnya maka gunakan itu
        if (isset(self::$_singleton)) {
            return self::$_singleton;
        }
        
        // buat instance pdo baru jika tidak ada instance sebelumnnya
        $_instance = new Singleton(name: 'singleton', user: 'test', password: 'pass');
        return $_instance->isConnecting();
    }

    private function setConnection() : void
    {
        try {
            self::$_singleton = new PDO(dsn: "mysql:host=localhost:3306;dbname={$this->name}", username: $this->user, password: $this->password);
            self::$_singleton->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo "Error". PHP_EOL;
            echo $e->getMessage(). PHP_EOL;
            self::$_singleton = null;
            exit;
        }
    }
    
    private function isConnecting() : ?PDO
    {
        return self::$_singleton;
    }
}


// gunakan identical operator untuk membandingkan kedua instance sekaligus tipenya
$db1 = Singleton::getSingleton();
$db2 = Singleton::getSingleton();
var_dump($db1 === $db2); // true

// atau gunakan instanceof
var_dump($db1 instanceof $db2); // true