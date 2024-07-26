<?php

use App\Core\Database;
use Faker\Factory as Faker;


return new class extends Database {
    public $table = 'users';
    protected $pdo;
    public function __construct() {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    public function run() {
        $faker = Faker::create();

        // generate sql command 
        $sql = "INSERT INTO $this->table (name, email, phone, password, is_admin, address, status, avatar, title, created_at) VALUES 
        (:name, :email, :phone, :password, :is_admin, :address, :status, :avatar, :title, :created_at)";
        
        // ready for run sql command 
        $stmt = $this->pdo->prepare($sql);

        for ($i = 0; $i < 50; $i++) {
            $name = $faker->name;
            $email = $faker->email;
            $phone = $faker->phoneNumber;
            $password = password_hash('12345678', PASSWORD_DEFAULT);
            $is_admin = $faker->randomElement(['0', '1']);
            $address = $faker->address;
            $status = $faker->randomElement(['0', '1']);
            $avatar = $faker->imageUrl(250, 250);
            $title = $faker->jobTitle;
            $created_at = $faker->dateTimeThisYear->format('Y-m-d H:i:s');

            
            $stmt->execute([
                ':name'         => $name,
                ':email'        => $email,
                ':phone'        => $phone,
                ':password'     => $password,
                ':is_admin'     => $is_admin,
                ':address'      => $address,
                ':status'       => $status,
                ':avatar'       => $avatar,
                ':title'        => $title,
                ':created_at'   => $created_at
            ]);
        }    
    }


};