create database uber;
\c uber;
create table producentAuta
(
	id_producenta serial primary key,
	nazwa varchar(30) not null unique 
);

create table samochod
(
	id_samochodu serial primary key,
	rejestracja varchar(15) not null unique,
	producent int references producentAuta(id_producenta) not null,
	model varchar(30) not null
);

create table kierowca
(
	kierowca_id serial primary key,
	imie varchar(20) not null,
	nazwisko varchar(20) not null,
	id_auta int references samochod(id_samochodu) not null
);

create table klient
(
	id_klienta serial primary key,
	imie varchar(20),
	nazwisko varchar(20),
	telefon varchar(12) not null
);

create table adres
(
	id_adresu serial primary key,
	wojewodztwo varchar(50) not null,
	miejscowosc varchar(50) not null,
	ulica varchar(80) not null,
	numer_domu varchar(5) not null
);

create table zamowienie
(
	id_zamowienia serial primary key,
	kierowca_id int references kierowca(kierowca_id) default 1,
	data_rozpoczencia timestamp default CURRENT_TIMESTAMP,
	miejsce_startu int references adres(id_adresu) not null,
	data_zakonczenia timestamp ,
	miejsce_docelowe int references adres(id_adresu),
	klient_id int references klient(id_klienta) not null,
	constraint contraint_daty check(data_zakonczenia>=data_rozpoczencia)
);

create table konto
(
	login text primary key,
	haslo text not null unique,
	rola varchar(10) not null
);


create procedure nowe_zamowienie(zKierowca_id int ,
								zMiejsce_startu int,
								zData_zakonczenia timestamp,
								zMiejsce_docelowe int,
								zKlient_id int)
language plpgsql								
as $$
begin
	insert into zamowienie(kierowca_id,miejsce_startu,data_zakonczenia,miejsce_docelowe, klient_id)
	values (zKierowca_id, zMiejsce_startu, zData_zakonczenia, zMiejsce_docelowe, zKlient_id);
	select * from Zamowienie;
	commit;
end; $$;

---tabela Producent auta
insert into producentAuta(nazwa) values('BMW');
insert into producentAuta(nazwa) values('Volkswagen');
insert into producentAuta(nazwa) values('Audi');
insert into producentAuta(nazwa) values('Ford');
insert into producentAuta(nazwa) values('Opel');

--wstawianie samchody
insert into samochod(rejestracja, model, producent) values('SG63901', '5GT', 1);
insert into samochod(rejestracja, model, producent) values('WSZ5421', 'M8', 1);
insert into samochod(rejestracja, model, producent) values('RP92152', 'Amarok', 2);
insert into samochod(rejestracja, model, producent) values('TJE1490', 'Bora', 2);
insert into samochod(rejestracja, model, producent) values('WPN9641', 'Quattro', 3);
insert into samochod(rejestracja, model, producent) values('SLU2287', 'SQ5', 3);
insert into samochod(rejestracja, model, producent) values('WSE8743', 'Bronco', 4);
insert into samochod(rejestracja, model, producent) values('WOT5942', 'EDGE', 4);
insert into samochod(rejestracja, model, producent) values('FSL7072', 'Antara', 5);
insert into samochod(rejestracja, model, producent) values('DPL0208', 'Corsa', 5);

--wstawianie kierowcow
insert into kierowca(imie, nazwisko, id_auta) values('Leszek', 'Szela',1);
insert into kierowca(imie, nazwisko, id_auta) values('Karol', 'Kulis',2);
insert into kierowca(imie, nazwisko, id_auta) values('Sebastian', 'Brzek',3);
insert into kierowca(imie, nazwisko, id_auta) values('Alfred', 'Dulak',4);
insert into kierowca(imie, nazwisko, id_auta) values('Natalia', 'Tyburska',5);
insert into kierowca(imie, nazwisko, id_auta) values('Gertruda', 'Pacak',6);
insert into kierowca(imie, nazwisko, id_auta) values('Gra�yna', 'Sylwestrzak',7);
insert into kierowca(imie, nazwisko, id_auta) values('Matylda', 'Sak',8);
insert into kierowca(imie, nazwisko, id_auta) values('Kazimiera', 'Mielcarz',9);
insert into kierowca(imie, nazwisko, id_auta) values('Alojzy', 'Tereszkiewicz',10);

--wstawianie adresow
insert into adres(wojewodztwo, miejscowosc, ulica, numer_domu) values('lodzkie', 'Lod�', 'Jarzynowa', '62');
insert into adres(wojewodztwo, miejscowosc, ulica, numer_domu) values('mazowieckie', 'Warszawa', 'Semaforowa', '65');
insert into adres(wojewodztwo, miejscowosc, ulica, numer_domu) values('zachodniopomorskie', 'Koszalin', 'Mirtowa', '55');
insert into adres(wojewodztwo, miejscowosc, ulica, numer_domu) values('sl�skie', 'Chorzow', 'Maronia Jo�efa', '111');
insert into adres(wojewodztwo, miejscowosc, ulica, numer_domu) values('malopolskie', 'Krakow', 'Skladowa', '32');
insert into adres(wojewodztwo, miejscowosc, ulica, numer_domu) values('warmi�sko-mazurskie', 'Olsztyn', 'Linki Bogumila', '56');

--Wstawianie Klientow

insert into klient(imie, nazwisko, telefon) values('Sylwia','Tluczek', '788300370');
insert into klient(imie, nazwisko, telefon) values('Daniela','Szajkowska', '888770780');
insert into klient(imie, nazwisko, telefon) values('Izabella','Sobieska', '734440573');
insert into klient(imie, nazwisko, telefon) values('Artur','Idzikowski', '665631956');
insert into klient(imie, nazwisko, telefon) values('Teodor','Oczkowicz', '538865581');
insert into klient(imie, nazwisko, telefon) values('Gracjan','Sek', '609505056');

--realizacja zamowie�
insert into zamowienie(kierowca_id,data_rozpoczencia,miejsce_startu,data_zakonczenia,miejsce_docelowe,klient_id) values(7, '2024-01-16',1,'2024-05-10',2,3);
insert into zamowienie(kierowca_id,data_rozpoczencia,miejsce_startu,data_zakonczenia,miejsce_docelowe,klient_id) values(3, '2023-01-16',2,'2023-06-22',1,4);
insert into zamowienie(kierowca_id,data_rozpoczencia,miejsce_startu,data_zakonczenia,miejsce_docelowe,klient_id) values(4, '2011-01-16',3,'2011-01-22',1,2);

