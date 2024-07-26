<?php

use App\Core\Database;
use Faker\Factory as Faker;


return new class extends Database {
    public $table = 'categories';
    protected $pdo;
    public function __construct() {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    public function run() {
        $faker = Faker::create();

        // generate sql command 
        $sql = "INSERT INTO $this->table (name, order_id,  status, image, created_at) VALUES  (:name, :order_id, :status, :image, :created_at)";
        
        // ready for run sql command 
        $stmt = $this->pdo->prepare($sql);
        $lang = ['PHP', 'JavaScript', 'ReactJs', 'NextJs', 'Laravel', 'DSA', 'RDBMS', 'NoSQL'];
        for ($i = 0; $i < count($lang); $i++) {
            $name = $lang[$i]; 
            $image = $faker->imageUrl(250, 250);
            $order_id = $i;
            $status = $faker->randomElement(['0', '1']);
            $created_at = $faker->dateTimeThisYear->format('Y-m-d H:i:s');

            $stmt->execute([
                ':name'         => $name,
                ':status'       => $status,
                ':image'        => $image,
                ':order_id'     => $order_id,
                ':created_at'   => $created_at
            ]);
        }    
    }


};