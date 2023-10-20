CREATE DATABASE IF NOT EXISTS quai_antique_test;
USE quai_antique_test;

CREATE OR REPLACE USER admin IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON quai_antique.* TO 'admin';
FLUSH PRIVILEGES ;

CREATE TABLE admin
(
    id       BINARY(16)   NOT NULL COMMENT '(DC2Type:uuid)',
    email    VARCHAR(180) NOT NULL,
    password VARCHAR(255) NOT NULL,
    roles    LONGTEXT     NOT NULL COMMENT '(DC2Type:simple_array)',
    UNIQUE INDEX UNIQ_880E0D76E7927C74 (email),
    PRIMARY KEY (id)
) DEFAULT CHARACTER SET utf8mb4
  COLLATE `utf8mb4_unicode_ci`
  ENGINE = InnoDB;

CREATE TABLE allergen
(
    id INT AUTO_INCREMENT NOT NULL,
    title VARCHAR(100) NOT NULL,
    PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8mb4
    COLLATE `utf8mb4_unicode_ci`
    ENGINE = InnoDB;

CREATE TABLE business_hours
(
    id INT AUTO_INCREMENT NOT NULL,
    restaurant_id INT DEFAULT NULL,
    weekday VARCHAR(255) NOT NULL,
    opening_hour TIME DEFAULT NULL,
    closing_hour TIME DEFAULT NULL,
    INDEX IDX_F4FB5A32B1E7706E (restaurant_id),
    PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8mb4
    COLLATE `utf8mb4_unicode_ci`
    ENGINE = InnoDB;

CREATE TABLE client
(
    id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid)',
    email VARCHAR(180) NOT NULL,
    password VARCHAR(255) NOT NULL,
    default_seats_number SMALLINT DEFAULT NULL,
    roles LONGTEXT NOT NULL COMMENT '(DC2Type:simple_array)',
    UNIQUE INDEX UNIQ_C7440455E7927C74 (email),
    PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8mb4
    COLLATE `utf8mb4_unicode_ci`
    ENGINE = InnoDB;

CREATE TABLE client_allergen
(
    client_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid)',
    allergen_id INT NOT NULL,
    INDEX IDX_B59380B19EB6921 (client_id),
    INDEX IDX_B59380B6E775A4A (allergen_id),
    PRIMARY KEY(client_id, allergen_id)
) DEFAULT CHARACTER SET utf8mb4
    COLLATE `utf8mb4_unicode_ci`
    ENGINE = InnoDB;

CREATE TABLE dish
(
    id INT AUTO_INCREMENT NOT NULL,
    category_id INT NOT NULL,
    title VARCHAR(100) NOT NULL,
    description VARCHAR(255) NOT NULL,
    price DOUBLE PRECISION NOT NULL,
    INDEX IDX_957D8CB812469DE2 (category_id),
    PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8mb4
    COLLATE `utf8mb4_unicode_ci`
    ENGINE = InnoDB;

CREATE TABLE dish_allergen
(
    dish_id INT NOT NULL,
    allergen_id INT NOT NULL,
    INDEX IDX_3C4389A5148EB0CB (dish_id),
    INDEX IDX_3C4389A56E775A4A (allergen_id),
    PRIMARY KEY(dish_id, allergen_id)
) DEFAULT CHARACTER SET utf8mb4
    COLLATE `utf8mb4_unicode_ci`
    ENGINE = InnoDB;

CREATE TABLE dish_category
(
    id INT AUTO_INCREMENT NOT NULL,
    title VARCHAR(100) NOT NULL,
    PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8mb4
    COLLATE `utf8mb4_unicode_ci`
    ENGINE = InnoDB;

CREATE TABLE formula
(
    id INT AUTO_INCREMENT NOT NULL,
    menu_id INT DEFAULT NULL,
    title VARCHAR(100) NOT NULL,
    description VARCHAR(255) NOT NULL,
    temporality VARCHAR(255) DEFAULT NULL,
    price DOUBLE PRECISION NOT NULL,
    INDEX IDX_67315881CCD7E912 (menu_id),
    PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8mb4
    COLLATE `utf8mb4_unicode_ci`
    ENGINE = InnoDB;

CREATE TABLE menu
(
    id INT AUTO_INCREMENT NOT NULL,
    title VARCHAR(100) NOT NULL,
    PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8mb4
    COLLATE `utf8mb4_unicode_ci`
    ENGINE = InnoDB;

CREATE TABLE menu_dish
(
    menu_id INT NOT NULL,
    dish_id INT NOT NULL,
    INDEX IDX_5D327CF6CCD7E912 (menu_id),
    INDEX IDX_5D327CF6148EB0CB (dish_id),
    PRIMARY KEY(menu_id, dish_id)
) DEFAULT CHARACTER SET utf8mb4
    COLLATE `utf8mb4_unicode_ci`
    ENGINE = InnoDB;

CREATE TABLE reservation
(
    id INT AUTO_INCREMENT NOT NULL,
    restaurant_id INT NOT NULL,
    client_id BINARY(16) DEFAULT NULL COMMENT '(DC2Type:uuid)',
    date DATETIME NOT NULL,
    email VARCHAR(255) NOT NULL,
    seats_number SMALLINT NOT NULL,
    comment VARCHAR(500) DEFAULT NULL,
    INDEX IDX_42C84955B1E7706E (restaurant_id),
    INDEX IDX_42C8495519EB6921 (client_id),
    PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8mb4
    COLLATE `utf8mb4_unicode_ci`
    ENGINE = InnoDB;

CREATE TABLE reservation_allergen
(
    reservation_id INT NOT NULL,
    allergen_id INT NOT NULL,
    INDEX IDX_B80AEADAB83297E7 (reservation_id),
    INDEX IDX_B80AEADA6E775A4A (allergen_id),
    PRIMARY KEY(reservation_id, allergen_id)
) DEFAULT CHARACTER SET utf8mb4
    COLLATE `utf8mb4_unicode_ci`
    ENGINE = InnoDB;

CREATE TABLE restaurant
(
    id INT AUTO_INCREMENT NOT NULL,
    max_capacity SMALLINT NOT NULL,
    PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8mb4
    COLLATE `utf8mb4_unicode_ci`
    ENGINE = InnoDB;

CREATE TABLE image
(
    id    INT AUTO_INCREMENT NOT NULL,
    title VARCHAR(255)       NOT NULL,
    image_name VARCHAR(255) DEFAULT NULL,
    image_size INT DEFAULT NULL,
    updated_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
    PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;

CREATE TABLE messenger_messages
(
    id BIGINT AUTO_INCREMENT NOT NULL,
    body LONGTEXT NOT NULL,
    headers LONGTEXT NOT NULL,
    queue_name VARCHAR(190) NOT NULL,
    created_at DATETIME NOT NULL,
    available_at DATETIME NOT NULL,
    delivered_at DATETIME DEFAULT NULL,
    INDEX IDX_75EA56E0FB7336F0 (queue_name),
    INDEX IDX_75EA56E0E3BD61CE (available_at),
    INDEX IDX_75EA56E016BA31DB (delivered_at),
    PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8mb4
    COLLATE `utf8mb4_unicode_ci`
    ENGINE = InnoDB;

ALTER TABLE business_hours
    ADD CONSTRAINT FK_F4FB5A32B1E7706E
        FOREIGN KEY (restaurant_id)
            REFERENCES restaurant (id);

ALTER TABLE client_allergen
    ADD CONSTRAINT FK_B59380B19EB6921
        FOREIGN KEY (client_id)
            REFERENCES client (id)
            ON DELETE CASCADE;

ALTER TABLE client_allergen
    ADD CONSTRAINT FK_B59380B6E775A4A
        FOREIGN KEY (allergen_id)
            REFERENCES allergen (id)
            ON DELETE CASCADE;

ALTER TABLE dish
    ADD CONSTRAINT FK_957D8CB812469DE2
        FOREIGN KEY (category_id)
            REFERENCES dish_category (id);

ALTER TABLE dish_allergen
    ADD CONSTRAINT FK_3C4389A5148EB0CB
        FOREIGN KEY (dish_id)
            REFERENCES dish (id)
            ON DELETE CASCADE;

ALTER TABLE dish_allergen
    ADD CONSTRAINT FK_3C4389A56E775A4A
        FOREIGN KEY (allergen_id)
            REFERENCES allergen (id)
            ON DELETE CASCADE;

ALTER TABLE formula
    ADD CONSTRAINT FK_67315881CCD7E912
        FOREIGN KEY (menu_id)
            REFERENCES menu (id)
            ON DELETE CASCADE;

ALTER TABLE menu_dish
    ADD CONSTRAINT FK_5D327CF6CCD7E912
        FOREIGN KEY (menu_id)
            REFERENCES menu (id)
            ON DELETE CASCADE;

ALTER TABLE menu_dish
    ADD CONSTRAINT FK_5D327CF6148EB0CB
        FOREIGN KEY (dish_id)
            REFERENCES dish (id)
            ON DELETE CASCADE;

ALTER TABLE reservation
    ADD CONSTRAINT FK_42C84955B1E7706E
        FOREIGN KEY (restaurant_id)
            REFERENCES restaurant (id);

ALTER TABLE reservation
    ADD CONSTRAINT FK_42C8495519EB6921
        FOREIGN KEY (client_id)
            REFERENCES client (id);

ALTER TABLE reservation_allergen
    ADD CONSTRAINT FK_B80AEADAB83297E7
        FOREIGN KEY (reservation_id)
            REFERENCES reservation (id)
            ON DELETE CASCADE;

ALTER TABLE reservation_allergen
    ADD CONSTRAINT FK_B80AEADA6E775A4A
        FOREIGN KEY (allergen_id)
            REFERENCES allergen (id)
            ON DELETE CASCADE;

