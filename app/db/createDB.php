<?php
require 'connDb.php';

$pdo->exec("CREATE TABLE users (
   id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
   username VARCHAR(255) NOT NULL,
   password CHAR(255) NOT NULL,
   slug VARCHAR(255) NOT NULL,
   ft_image VARCHAR(255) NOT NULL,
   content TEXT NOT NULL,
   email VARCHAR(255) NOT NULL,
   phone VARCHAR(255) NOT NULL,
   role ENUM ('Author','Admin','Suscriber') NULL DEFAULT 'Suscriber',
   created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

echo 'Tables : USERS, ';

//création table users_posts

$pdo->exec("CREATE TABLE posts (
   id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
   user_id int DEFAULT NULL,
   slug VARCHAR(255) NOT NULL,
   title VARCHAR(255) NOT NULL,
   ft_image VARCHAR(255) NOT NULL,
   content TEXT NOT NULL,  
   created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
   published TINYINT NOT NULL,
   FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

echo ' POSTS, ';

//création table comments

$pdo->exec("CREATE TABLE comments (
   id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
   pseudo VARCHAR(255) NOT NULL,
   email VARCHAR(255) NOT NULL,
   title VARCHAR(255) NOT NULL,
   content TEXT NOT NULL,  
   created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
   published TINYINT NOT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

echo ' COMMENTS, ';

//création table categories

$pdo->exec("CREATE TABLE categories (
   id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
   title VARCHAR(255) NOT NULL,
   ft_image VARCHAR(255) NOT NULL,
   content TEXT NOT NULL,  
   slug VARCHAR(255) NOT NULL
    
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

echo ' CATEGORIES, ';

// Create posts_comments table

$pdo->exec("CREATE TABLE posts_comments (
   post_id INT UNSIGNED NOT NULL,
   comment_id INT UNSIGNED NOT NULL,
   PRIMARY KEY (post_id, comment_id),
   CONSTRAINT fk_post
      FOREIGN KEY (post_id)
      REFERENCES posts (id)
      ON UPDATE CASCADE
      ON DELETE RESTRICT,
   CONSTRAINT fk_comment
      FOREIGN KEY (comment_id)
      REFERENCES comments (id)
      ON UPDATE CASCADE
      ON DELETE RESTRICT
)  DEFAULT CHARSET=utf8mb4 ");

echo 'POSTS_COMMENTS,';

//création table users_posts

$pdo->exec("CREATE TABLE users_posts (
   user_id INT UNSIGNED NOT NULL,
   post_id INT UNSIGNED NOT NULL,
   PRIMARY KEY (user_id, post_id),
   CONSTRAINT fk_user
      FOREIGN KEY (user_id)
      REFERENCES users (id)
      ON UPDATE CASCADE
      ON DELETE RESTRICT,
   CONSTRAINT fk_post
      FOREIGN KEY (post_id)
      REFERENCES posts (id)
      ON UPDATE CASCADE
      ON DELETE RESTRICT
)  DEFAULT CHARSET=utf8mb4 ");

echo 'USERS_POSTS,';

//création table posts_categories

$pdo->exec("CREATE TABLE posts_categories (
   post_id INT UNSIGNED NOT NULL,
   category_id INT UNSIGNED NOT NULL,
   PRIMARY KEY (post_id, category_id),
   CONSTRAINT fk_post
      FOREIGN KEY (post_id)
      REFERENCES posts (id)
      ON UPDATE CASCADE
      ON DELETE RESTRICT,
   CONSTRAINT fk_category
      FOREIGN KEY (category_id)
      REFERENCES categories (id)
      ON UPDATE CASCADE
      ON DELETE RESTRICT
)  DEFAULT CHARSET=utf8mb4 ");

echo 'POSTS_CATEGORIES were created successfully !';

