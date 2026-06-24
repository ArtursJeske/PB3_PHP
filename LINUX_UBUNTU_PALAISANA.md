# Projekta palaišana uz Linux Ubuntu (PHP + MariaDB)

## Pārbaudam vai viss ir uzinstalēts un strādā

Pārbaudi, vai ir uzstādīts PHP un MariaDB:

```bash
php -v
which mariadb
systemctl is-active mariadb
```

Ja MariaDB nav aktīvs, palaid to ar:

```bash
sudo systemctl start mariadb
```

## 1. Datubāzes izveide

Pieslēdzies MariaDB ar `root` lietotāju (ievadīsi savu MariaDB root paroli):

```bash
mariadb -u root -p
```

## 2. Tabulu ielādēšana

Ielādē projekta `db.sql` failu, kas izveido datubāzi `viesu_gramata` un tabulas `viesu_gramata` un `lietotaji`:

```bash
mariadb -u root -p viesu_gramata < db.sql
```

Pārbaudi, ka tabulas izveidotas:

```bash
mariadb -u root -p viesu_gramata -e "SHOW TABLES;"
```

## 3. Savienojuma konfigurācija (db.php)

Failā `db.php` ir norādīti pieslēgšanās dati uz datubāzi:

```php
$conn = new mysqli("localhost", "root", "TAVA_PAROLE", "viesu_gramata");
```

Pārliecinies, ka trešais parametrs ir tava reālā MariaDB `root` lietotāja parole.

## 4. PHP servera palaišana

Projekta mapē palaid iebūvēto PHP serveri:

```bash
cd /home/laptops/Desktop/PB3_PHP
php -S localhost:8000
```

Atstāj šo terminālu atvērtu — serveris darbojas, kamēr logs nav aizvērts.

## 5. Atvērt pārlūkā

```
http://localhost:8000/index.php
```

## Piezīmes

- Ja redzi kļūdu "Access denied for user 'root'@'localhost'", pārbaudi, vai `db.php` failā ievadītā parole sakrīt ar reālo MariaDB root paroli.
