<?php

require_once 'db_connection.php';

// array of users to be inserted
$users = [
    [
        'nom' => 'Dupont',
        'prenom' => 'Jean',
        'email' => 'jean.dupont@example.com',
        'password' => 'password123', // plaintext password
        'role' => 'admin',
    ],
    // add more users as needed
];

try {
    foreach ($users as $user) {
        // hash the plaintext password
        $hashed_password = password_hash($user['password'], PASSWORD_DEFAULT);
        
        // prepare SQL statement
        $stmt = $pdo->prepare("INSERT INTO utilisateur (nom, prenom, email, password, role) VALUES (:nom, :prenom, :email, :password, :role)");
        
        // bind parameters and execute
        $stmt->execute([
            ':nom' => $user['nom'],
            ':prenom' => $user['prenom'],
            ':email' => $user['email'],
            ':password' => $hashed_password,
            ':role' => $user['role'],
        ]);
    }

    echo "Users have been inserted successfully.";
} catch (PDOException $e) {
    echo "Error inserting users: " . $e->getMessage();
}
