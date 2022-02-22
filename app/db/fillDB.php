<?php

require dirname(__DIR__) .'../../vendor/autoload.php';

$faker = Faker\Factory::create('fr_FR');

require 'connDB.php';

$posts = [];
$categories = [];
$comments = [];
$users = [];

//nettoyage des tables

$pdo->exec("SET FOREIGN_KEY_CHECKS =  0");
$pdo->exec("TRUNCATE TABLE posts_categories");
$pdo->exec("TRUNCATE TABLE posts_comments");
$pdo->exec("TRUNCATE TABLE users_posts");
$pdo->exec("TRUNCATE TABLE posts");
$pdo->exec("TRUNCATE TABLE users");
$pdo->exec("TRUNCATE TABLE comments");
$pdo->exec("TRUNCATE TABLE categories");
$pdo->exec("SET FOREIGN_KEY_CHECKS =  1");

echo 'Database Table successfully !';

//création fake users

$hashPassword = null;
for ($i = 0; $i < 50; $i++) {
   $hashPassword = password_hash($faker->password,  PASSWORD_BCRYPT);
   $pdo->exec("INSERT INTO users
   SET username= '{$faker->username}',
           password='{$hashPassword}',
           slug='{$faker->slug}',
           ft_image='image{$faker->numberBetween($min = 1, $max =5)}.jpg',
           content='{$faker->paragraphs(rand(3,15), true)}',
           email='{$faker->email}',
           phone='{$faker->e164PhoneNumber}',
           role = 'Suscriber',
           created_at='{$faker->date} {$faker->time}'
   ");

   $users[] = $pdo->lastInsertId();
}

echo 'Utilisateurs, ';

//création Admin


   $hashPassword = password_hash('test',  PASSWORD_BCRYPT);
   $pdo->exec("INSERT INTO users
   SET username= '{lorymvc}',
           password='{$hashPassword}',
           slug='{lorymvc}',
           ft_image='image{$faker->numberBetween($min = 1, $max =5)}.jpg',
           content='{$faker->paragraphs(rand(3,15), true)}',
           email='{$faker->email}',
           phone='{$faker->e164PhoneNumber}',
           role = 'Admin',
           created_at='{$faker->date} {$faker->time}'
   ");

   echo 'Admin, ';
//création des posts

$hashPassword = null;
for ($i = 0; $i < 144; $i++) {
   
   $pdo->exec("INSERT INTO posts
   SET user_id= '51',
           title='{$faker->sentence(2)}',
           slug='{$faker->slug}',
           ft_image='image{$faker->numberBetween($min = 1, $max =5)}.jpg',
           content='{$faker->paragraphs(rand(3,15), true)}',          
           created_at='{$faker->date} {$faker->time}',
           published='1'
   ");

   $posts[] = $pdo->lastInsertId();
}

echo 'Articles, ';

//création des commentaires


for ($i = 0; $i < 288; $i++) {
   
   $pdo->exec("INSERT INTO comments
   SET pseudo= '{$faker->username}',
           title='{$faker->sentence(2)}',
           email='{$faker->email}',
           content='{$faker->paragraphs(rand(3,15), true)}',           
           created_at='{$faker->date} {$faker->time}',
           published='1'
   ");

   $comments[] = $pdo->lastInsertId();
}

echo 'Commentaires créer,';

//création categories

for ($i = 0; $i < 16; $i++) {
   
        $pdo->exec("INSERT INTO categories
        SET 
                title='{$faker->sentence(2)}',
                slug='{$faker->slug}',
                content='{$faker->paragraphs(rand(3,15), true)}',           
                ft_image='image{$faker->numberBetween($min = 1, $max =5)}.jpg'
                
        ");
     
        $categories[] = $pdo->lastInsertId();
     }
     
     echo 'Commentaires créer,';

//lier les articles avec une catégorie

foreach($posts as $post) {
        $randomCategories = $faker->randomElements($categories, rand(1,1));
        foreach ($randomCategories as $category) {
                $pdo->exec("INSERT INTO posts_categories SET post_id=$post, category_id=$category");
        }
}

echo 'POSTS_CATEGORIES, ';

//lier les articles au commentaires

foreach($posts as $post) {
        $randomComments = $faker->randomElements($comments, rand(2,2));
        foreach ($randomComments as $comment) {
                $pdo->exec("INSERT INTO posts_comments SET post_id=$post, comment_id=$comment");
        }
}

echo 'POSTS_COMMENTS, ';

//lier les articles avec l'Admin

foreach($posts as $post) {
           
        $pdo->exec("INSERT INTO users_posts SET user_id='51', post_id=$post");       
}

echo 'USERS_POSTS, ont été créer avec talent !!!';

