create table Wunschgerichte(
    id int primary key auto_increment,
    name varchar(80) not null,
    beschreibung varchar(800) not null
);

create table Ersteller(
    id int primary key auto_increment,
    name varchar(80) default 'anonym',
    email varchar(320) not null
);

create table verfasst(
    id_wunsch int references Wunschgerichte(id) on update cascade ,
    id_ersteller int references Ersteller(id) on update cascade ,
    erstellt_am date not null
)

-- A1.6 Erstellen Sie eine SQL-Abfrage, welche die neuesten 5 Einträge vollständig darstellt.
select neu5.id as id, neu5.name as name, neu5.beschreibung as beschreibung,
       E.name as Ersteller, E.email as Ersteller_email, verfasst.erstellt_am as erstellt_am
       from (select * from Wunschgerichte order by id desc limit 5) neu5
    join verfasst on neu5.id = verfasst.id_wunsch
    join Ersteller E on verfasst.id_ersteller = E.id;