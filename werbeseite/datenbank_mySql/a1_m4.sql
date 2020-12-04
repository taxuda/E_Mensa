use emensawerbeseite;

create table wunschgericht(
    id int(8) primary key auto_increment,
    name varchar(80) not null ,
    beschreibung varchar(800) not null ,
    erstellt_datum date not null ,
    erstellerIn_name varchar(80) default 'anonym',
    erstellerIn_email varchar(320)
);

insert into wunschgericht(name, beschreibung, erstellerIn_name,erstellerIn_email,erstellt_datum) values(
    'dat','dat khong ngon','dat','dat@gmail.com',now());

delete from wunschgericht where id > 4;

-- A1.6 M4
-- Erstellen Sie eine SQL-Abfrage, welche die neuesten 5 Einträge vollständig darstellt.
select * from (select * from wunschgericht order by id desc limit 5 ) sub order by id asc ;