create table admin
(
    id       binary(16)   not null comment '(DC2Type:uuid)'
        primary key,
    email    varchar(180) not null,
    roles    longtext     not null comment '(DC2Type:simple_array)',
    password varchar(255) not null,
    constraint UNIQ_880E0D76E7927C74
        unique (email)
)
    collate = utf8mb4_unicode_ci;

create table allergen
(
    id    int auto_increment
        primary key,
    title varchar(100) not null
)
    collate = utf8mb4_unicode_ci;

create table client
(
    id                   binary(16)   not null comment '(DC2Type:uuid)'
        primary key,
    email                varchar(180) not null,
    roles                longtext     not null comment '(DC2Type:simple_array)',
    password             varchar(255) not null,
    default_seats_number smallint     null,
    constraint UNIQ_C7440455E7927C74
        unique (email)
)
    collate = utf8mb4_unicode_ci;

create table client_allergen
(
    client_id   binary(16) not null comment '(DC2Type:uuid)',
    allergen_id int        not null,
    primary key (client_id, allergen_id),
    constraint FK_B59380B19EB6921
        foreign key (client_id) references client (id)
            on delete cascade,
    constraint FK_B59380B6E775A4A
        foreign key (allergen_id) references allergen (id)
            on delete cascade
)
    collate = utf8mb4_unicode_ci;

create index IDX_B59380B19EB6921
    on client_allergen (client_id);

create index IDX_B59380B6E775A4A
    on client_allergen (allergen_id);

create table dish_category
(
    id    int auto_increment
        primary key,
    title varchar(100) not null
)
    collate = utf8mb4_unicode_ci;

create table dish
(
    id          int auto_increment
        primary key,
    category_id int          not null,
    title       varchar(100) not null,
    description varchar(255) not null,
    price       double       not null,
    constraint FK_957D8CB812469DE2
        foreign key (category_id) references dish_category (id)
)
    collate = utf8mb4_unicode_ci;

create index IDX_957D8CB812469DE2
    on dish (category_id);

create table dish_allergen
(
    dish_id     int not null,
    allergen_id int not null,
    primary key (dish_id, allergen_id),
    constraint FK_3C4389A5148EB0CB
        foreign key (dish_id) references dish (id)
            on delete cascade,
    constraint FK_3C4389A56E775A4A
        foreign key (allergen_id) references allergen (id)
            on delete cascade
)
    collate = utf8mb4_unicode_ci;

create index IDX_3C4389A5148EB0CB
    on dish_allergen (dish_id);

create index IDX_3C4389A56E775A4A
    on dish_allergen (allergen_id);

create table doctrine_migration_versions
(
    version        varchar(191) not null
        primary key,
    executed_at    datetime     null,
    execution_time int          null
)
    collate = utf8_unicode_ci;

create table formula
(
    id          int auto_increment
        primary key,
    title       varchar(100) not null,
    description varchar(255) not null,
    temporality varchar(255) null,
    price       double       not null
)
    collate = utf8mb4_unicode_ci;

create table menu
(
    id    int auto_increment
        primary key,
    title varchar(100) not null
)
    collate = utf8mb4_unicode_ci;

create table menu_dish
(
    menu_id int not null,
    dish_id int not null,
    primary key (menu_id, dish_id),
    constraint FK_5D327CF6148EB0CB
        foreign key (dish_id) references dish (id)
            on delete cascade,
    constraint FK_5D327CF6CCD7E912
        foreign key (menu_id) references menu (id)
            on delete cascade
)
    collate = utf8mb4_unicode_ci;

create index IDX_5D327CF6148EB0CB
    on menu_dish (dish_id);

create index IDX_5D327CF6CCD7E912
    on menu_dish (menu_id);

create table menu_formula
(
    menu_id    int not null,
    formula_id int not null,
    primary key (menu_id, formula_id),
    constraint FK_EFEA453FA50A6386
        foreign key (formula_id) references formula (id)
            on delete cascade,
    constraint FK_EFEA453FCCD7E912
        foreign key (menu_id) references menu (id)
            on delete cascade
)
    collate = utf8mb4_unicode_ci;

create index IDX_EFEA453FA50A6386
    on menu_formula (formula_id);

create index IDX_EFEA453FCCD7E912
    on menu_formula (menu_id);

create table restaurant
(
    id           int auto_increment
        primary key,
    max_capacity smallint not null
)
    collate = utf8mb4_unicode_ci;

create table business_hours
(
    id            int auto_increment
        primary key,
    weekday       varchar(255) not null,
    opening_hour  time         null,
    closing_hour  time         null,
    restaurant_id int          null,
    constraint FK_F4FB5A32B1E7706E
        foreign key (restaurant_id) references restaurant (id)
)
    collate = utf8mb4_unicode_ci;

create index IDX_F4FB5A32B1E7706E
    on business_hours (restaurant_id);

create table reservation
(
    id            int auto_increment
        primary key,
    restaurant_id int          not null,
    client_id     binary(16)   null comment '(DC2Type:uuid)',
    date          datetime     not null,
    email         varchar(255) not null,
    seats_number  smallint     not null,
    comment       varchar(500) null,
    constraint FK_42C8495519EB6921
        foreign key (client_id) references client (id),
    constraint FK_42C84955B1E7706E
        foreign key (restaurant_id) references restaurant (id)
)
    collate = utf8mb4_unicode_ci;

create index IDX_42C8495519EB6921
    on reservation (client_id);

create index IDX_42C84955B1E7706E
    on reservation (restaurant_id);

create table reservation_allergen
(
    reservation_id int not null,
    allergen_id    int not null,
    primary key (reservation_id, allergen_id),
    constraint FK_B80AEADA6E775A4A
        foreign key (allergen_id) references allergen (id)
            on delete cascade,
    constraint FK_B80AEADAB83297E7
        foreign key (reservation_id) references reservation (id)
            on delete cascade
)
    collate = utf8mb4_unicode_ci;

create index IDX_B80AEADA6E775A4A
    on reservation_allergen (allergen_id);

create index IDX_B80AEADAB83297E7
    on reservation_allergen (reservation_id);