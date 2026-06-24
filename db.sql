CREATE DATABASE IF NOT EXISTS viesu_gramata;
USE viesu_gramata;

CREATE TABLE IF NOT EXISTS viesu_gramata (
    id INT AUTO_INCREMENT PRIMARY KEY,
    vards VARCHAR(100),
    zina TEXT
);


CREATE TABLE IF NOT EXISTS lietotaji (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lietotajvards VARCHAR(20) UNIQUE NOT NULL,
    parole_hash VARCHAR(255) NOT NULL,
    loma VARCHAR(20) NOT NULL
);

