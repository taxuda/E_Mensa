create database emensawerbeseite
character set UTF8mb4
collate utf8mb4_unicode_ci;

use emensawerbeseite;
create table gericht (
    id int(8) primary key,
    name varchar(80) not null unique,
    beschreibung varchar(800) not null ,
    erfasst_am date not null ,
    vegetarish boolean not null default false,
    vegan boolean not null default false ,
    preis_intern double not null,
    preis_extern double not null,
    constraint preis_gericht check(preis_intern > 0 and preis_extern <= preis_intern)
);
-- vergetarisch falsche name eingegeben
alter table gericht
    change column  vegetarish vegetarisch boolean not null  default false
        after erfasst_am;

alter table gericht
    drop constraint preis_gericht;
-- constraint preis_gericht falsch eingegeben
alter table gericht
    add constraint preis_gericht
        check(preis_intern > 0 and preis_intern <= preis_extern);

create table allergen(
    code char(4) primary key ,
    name varchar(300) not null ,
    typ varchar(20) not null default 'allergen'
);

create table kategorie (
    id int(8) primary key ,
    name varchar(80) not null ,
    eltern_id int(8),
    bildname varchar(200),
    foreign key (eltern_id) references kategorie(id)
);

create table gericht_hat_allergen (
    code char(4) references allergen(code) ,
    gericht_id int(8) not null references gericht(id)
);

create table gericht_hat_kategorie (
    gericht_id int(8) not null references gericht(id),
    kategorie_id int(8) not null references kategorie(id)
);

-- a4_5 count data records
select count(*) from gericht;
select count(*) from allergen;
select count(*) from kategorie;
select count(*) from gericht_hat_allergen;
select count(*) from gericht_hat_kategorie;
-- Allergen Datei 21 21
-- Gericht Datei 19 19
-- Gericht_hat_allergen Datei 31 31
-- Kategorie Datei 7 7
-- gericht_hat_kategorie 13 13