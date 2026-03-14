# 🌍 SISTEM ZA EVIDENCIJU PUTNIČKIH REZERVACIJA

Aplikacija za upravljanje putovanjima i rezervacijama. Gosti mogu da pregledaju putovanja i rezervišu ih bez logovanja, dok administratori imaju pristup celokupnom sistemu za upravljanje.

## 📋 SADRŽAJ

- [Funkcionalnosti](#funkcionalnosti)
- [Tehnologije](#tehnologije)
- [Instalacija](#instalacija)
- [Korišćenje](#korišćenje)
- [Struktura projekta](#struktura-projekta)

---

## ✨ FUNKCIONALNOSTI

### 🌐 JAVNA STRANA (bez logovanja)
- ✅ Pregled svih dostupnih putovanja
- ✅ Detaljan prikaz pojedinačnog putovanja
  - Program putovanja
  - Fakultativni izleti
  - Pravila otkazivanja
  - Informacije o hotelu i prevozu
- ✅ **Rezervacija putovanja** direktno sa detalja
  - Unos ličnih podataka
  - Izbor broja odraslih i dece
  - Automatski proračun ukupne cene
  - Email potvrda (TODO: implementirati)

### 🔐 ADMIN PANEL (sa logom)
- ✅ **Upravljanje putovanjima**
  - CRUD operacije (Create, Read, Update, Delete)
  - DataTable sa pretraživanjem i sortiranjem
  - Validacija podataka
  - Praćenje broja rezervacija
  
- ✅ **Upravljanje rezervacijama**
  - Pregled svih rezervacija
  - Detalji rezervacije (putnik, putovanje, cena)
  - Izmena statusa (nova, potvrđena, otkazana)
  - Brisanje rezervacija
  - Automatsko ažuriranje broja rezervacija

- ✅ **Upravljanje hotelima**
  - CRUD operacije
  - Povezivanje sa putovanjima

---

## 🛠 TEHNOLOGIJE

- **Backend:** Laravel 11
- **Frontend:** Blade, Bootstrap 5
- **JavaScript:** jQuery, DataTables, Axios
- **Baza podataka:** MySQL/MariaDB
- **Autentifikacija:** Laravel Auth

---

## 📦 INSTALACIJA

### Preduslovi
- PHP >= 8.2
- Composer
- MySQL/MariaDB
- Node.js & npm (opciono)

### Koraci

1. **Kloniraj repozitorijum**
```bash
cd c:\projekti\travel-agency
```

2. **Instaliraj zavisnosti**
```bash
composer install
```

3. **Kopiraj `.env` fajl**
```bash
cp .env.example .env
```

4. **Generiši ključ aplikacije**
```bash
php artisan key:generate
```

5. **Konfiguracija baze podataka**
Otvori `.env` fajl i podesi:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=travel_agency
DB_USERNAME=root
DB_PASSWORD=
```

6. **Kreiraj bazu podataka**
```sql
CREATE DATABASE travel_agency CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

7. **Pokreni migracije**
```bash
php artisan migrate
```

8. **Pokreni seeder-e (opciono - test podaci)**
```bash
php artisan db:seed
```

9. **Pokreni aplikaciju**
```bash
php artisan serve
```

Aplikacija će biti dostupna na: `http://localhost:8000`

---

## 🎯 KORIŠĆENJE

### Pristup javnoj strani
- Otvori browser: `http://localhost:8000`
- Pregledaj putovanja
- Klikni na "Detalji" za konkretno putovanje
- Popuni formu za rezervaciju
- Klikni "Rezerviši"

### Pristup admin panelu
1. Registruj nalog: `http://localhost:8000/register`
2. Logovanjem se automatski dobija pristup admin panelu
3. Koristi sidebar navigaciju:
   - **Putovanja** → Unos / Lista
   - **Rezervacije** → Unos / Lista
   - **Hoteli** → Unos / Lista

### Osnovne akcije

**Kreiranje putovanja:**
1. Admin panel → Putovanja → Unos
2. Popuni obavezna polja (naziv, država, grad, datum, cena...)
3. Unesi program putovanja
4. Sačuvaj

**Pregled rezervacija:**
1. Admin panel → Rezervacije → Lista
2. Pregledaj sve rezervacije u DataTable formatu
3. Klikni na "Prikaži" za detalje
4. Izmeni status rezervacije (nova → potvrđena/otkazana)

---

## 📁 STRUKTURA PROJEKTA

### Ključni fajlovi i folderi

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── PutovanjeController.php      # Upravljanje putovanjima
│   │   ├── RezervacijeController.php    # Upravljanje rezervacijama
│   │   ├── HotelController.php          # Upravljanje hotelima
│   │   └── HomeController.php           # Javna početna strana
│   └── Requests/
│       ├── StoreRezervacijaRequest.php  # Validacija rezervacija
│       └── StorePutovanjeRequest.php    # Validacija putovanja
├── Models/
│   ├── Putovanje.php                    # Model putovanja (sa relacijama)
│   ├── Rezervacije.php                  # Model rezervacija (sa relacijama)
│   ├── Hotel.php
│   ├── Drzava.php
│   ├── TipSobe.php
│   └── TipPrevoza.php

database/
├── migrations/                          # Struktura baze podataka
└── seeders/                             # Test podaci

resources/
├── views/
│   ├── pocetna.blade.php               # Javna početna strana
│   ├── putovanje/
│   │   ├── lista.blade.php             # Admin lista putovanja
│   │   ├── forma.blade.php             # Forma za putovanja
│   │   └── prikaz.blade.php            # Javni detalji + rezervacija
│   └── rezervacije/
│       ├── lista.blade.php             # Admin lista rezervacija
│       ├── forma.blade.php             # Forma za rezervacije
│       └── prikaz.blade.php            # Detalji rezervacije

routes/
└── web.php                              # Definicija svih ruta

public/
└── js/
    └── app/
        ├── putovanje/
        │   └── datatable.js             # DataTable za putovanja
        └── rezervacije/
            └── datatable.js             # DataTable za rezervacije
```

---

## 🔗 RELACIJE U BAZI PODATAKA

```
Putovanje
├── belongsTo → Drzava
├── belongsTo → Hotel
├── belongsTo → TipSobe
├── belongsTo → TipPrevoza
└── hasMany → Rezervacije

Rezervacije
├── belongsTo → Putovanje
├── belongsTo → Hotel
└── belongsTo → TipSobe

Hotel
└── belongsTo → Drzava
```

---

## 📝 TODO (Budući razvoj)

- [ ] Implementacija slanja email potvrde rezervacije
- [ ] Upload slika za putovanja (baner i galerija)
- [ ] Dashboard sa statistikama
- [ ] Filteri i pretraga na javnoj strani
- [ ] Export rezervacija u PDF/Excel
- [ ] Kalendar dostupnih termina
- [ ] QR kod za potvrdu rezervacije
- [ ] Online plaćanje

---

## 👤 ADMIN PRISTUP

Za testiranje admin funkcionalnosti:
1. Registruj se na `/register`
2. Ili koristi test nalog (ako je seedovan):
   - Email: `admin@example.com`
   - Password: `password`

---

## 🐛 REŠAVANJE PROBLEMA

**Problem:** Greška prilikom migracije
```bash
php artisan migrate:fresh --seed
```

**Problem:** Nedostaju seederi
```bash
php artisan db:seed --class=DrzaveSeeder
php artisan db:seed --class=TipSobeSeeder
php artisan db:seed --class=TipPrevozaSeeder
```

**Problem:** Cache problem
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

---

## 📞 KONTAKT

Za pitanja i podršku oko projekta.

---

## 📄 LICENCA

Seminarski rad - Sva prava zadržana.
