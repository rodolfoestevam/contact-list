<?php
/**
 * Created by PhpStorm.
 * User: iagobelodeoliveiravieira
 * Date: 06/03/17
 * Time: 16:44
 */

require_once 'Medoo.php';

use Medoo\Medoo;

class DatabaseFactory
{
    private static $database = null;

    /**
     * DatabaseFactory constructor.
     */
    private function __construct()
    {
    }

    /**
     * @return Medoo|null return a Medoo singleton instance.
     */
    public static function getDatabase()
    {
        if (self::$database == null) {
            // Database Configuration
            self::$database = new Medoo(
                [
                    'database_type' => 'mysql',
                    'database_name' => 'book',
                    'server' => 'localhost',
                    'username' => 'root',
                    'password' => 'root',
                    'charset' => 'utf8',
                    'port' => '3306'
                ]
            );
        }
        return self::$database;
    }
}

