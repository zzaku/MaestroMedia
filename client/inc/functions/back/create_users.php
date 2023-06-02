<?php

require_once 'db_connection.php';

// array of users to be inserted
$users = [
    [
        'nom' => 'Dupont',
        'prenom' => 'Jean',
        'email' => 'Jean.dupont@gmail.com',
        'password' => 'password123',
        'role' => 'Admin',
    ],
    [
        'nom' => 'Smith',
        'prenom' => 'Michael',
        'email' => 'john.smith@example.com',
        'password' => 'qwerty123',
        'role' => 'Utilisateur',
    ],
    [
        'nom' => 'Brown',
        'prenom' => 'John',
        'email' => 'jane.davis@example.com',
        'password' => '987654321',
        'role' => 'Musicologue'
    ],
    [
        'nom' => 'Wilson',
        'prenom' => 'Olivia',
        'email' => 'noah.wilson@example.com',
        'password' => 'password123',
        'role' => 'Musicologue',
    ],
    [
        'nom' => 'Anderson',
        'prenom' => 'Sophia',
        'email' => 'daniel.anderson@example.com',
        'password' => 'pass1234',
        'role' => 'Utilisateur',
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