-- A5_M3
-- 1) Alle Daten aller Gerichte.
select * from gericht;

-- 2) Das Erfassungsdatum aller Gerichte.
select erfasst_am from gericht;

-- 3) Das Erfassungsdatum sowie
-- den Namen (als Attributname Gerichtname) aller Gerichte
-- absteigend sortiert nach Gerichtname.
-- select name erfasst_am from gericht order by name asc;
select name, erfasst_am from gericht order by name desc;

-- 4) Den Namen sowie die Beschreibung der Gerichte
-- aufsteigend sortiert nach Name, wobei nur 5
-- Datensätze dargestellt werden sollen.
select name, beschreibung from gericht
    order by name asc limit 5;

-- 5) Ändern Sie die vorherige Abfrage so ab,
-- so dass 10 Datensätze dargestellt werden,
-- die nach den ersten 5 Datensätzen folgen.
-- (Die ersten 5 Datensätze werden übersprungen)
select name, beschreibung from gericht
order by name asc
limit 10 offset 5;

-- 6) Zeigen Sie alle möglichen Allergen-Typen (typ),
-- wobei Sie keine doppelten Einträge darstellen.
select distinct typ from allergen;

-- 7) Namen von Gerichten, deren Name mit einem „K“ beginnt.
-- select name from gericht where name = 'K%';
select name from gericht where name like 'K%';


-- 8) Ids und Namen von Gerichten,
-- deren Namen ein „suppe“ an beliebiger Stelle enthält.
select id, name from gericht where name like '%suppe%';

-- 9) Alle Kategorien, die keine Elterneinträge besitzen.
select * from kategorie where eltern_id is null;

-- 10)Alle Gerichte mit allen zugehörigen Allergenen.
select g.name as Gericht, a.name as Allergen from gericht g join gericht_hat_allergen gha on g.id = gha.gericht_id
join allergen a on gha.code = a.code;

-- 11)Ändern Sie die vorherige Abfrage so ab,
-- dass alle existierenden Gerichte dargestellt
-- werden (auch wenn keine Allergene enthalten sind).
select g.name as Gericht, a.name as Allergen from gericht g left join gericht_hat_allergen gha on g.id = gha.gericht_id
                                                            left join allergen a on gha.code = a.code;

-- 12)Ändern Sie die vorherige Abfrage so ab,
-- so dass im Ergebnis alle existierenden Allergene
-- dargestellt werden (auch wenn diese nicht einem Gericht zugeordnet sind).
select g.name as Gericht, a.name as Allergen from allergen a left join gericht_hat_allergen gha on a.code = gha.code
left join gericht g on gha.gericht_id = g.id; -- group by a.code

-- 13)Die Anzahl der Gerichte pro Kategorie aufsteigend sortiert nach Anzahl.
select k.name as Kategorie, count(ghk.gericht_id) as NumbersOfGericht from kategorie k
    join gericht_hat_kategorie ghk on k.id = ghk.kategorie_id
group by k.name
order by NumbersOfGericht asc;

-- 14)Ändern Sie die vorherige Abfrage so ab, dass dabei nur die Kategorien
-- dargestellt werden, die mehr als 2 Gerichte besitzen.
select k.name as Kategorie, count(ghk.gericht_id) as NumbersOfGericht from kategorie k
join gericht_hat_kategorie ghk on k.id = ghk.kategorie_id
group by k.name
having NumbersOfGericht > 2
order by NumbersOfGericht asc;

-- 15)Korrigieren Sie den Wert „Dinkel“ in der
-- Tabelle allergen mit dem code a6 zu „Kamut“.
update allergen
set name = 'Kamut'
where code = 'a6';

-- 16)Fügen Sie das Gericht „Currywurst mit Pommes“ hinzu
-- und tragen Sie es in der Kategorie „Hauptspeise“ ein.
insert into gericht(id,name,beschreibung,erfasst_am,preis_intern,preis_extern)
values(21, 'Currywurst mit Pommes', 'es gefällt mir nicht', '2020-11-22', 2.90, 3.50 );

insert into gericht_hat_kategorie(gericht_id, kategorie_id)
values(21, 3);

-- 17)(optional) Alle Gerichte, die vier oder mehr Allergene aufweisen.
select g.name, count(a.code) from gericht g join gericht_hat_allergen gha on g.id = gha.gericht_id
join allergen a on gha.code = a.code
group by g.name
having count(a.code) > 3;