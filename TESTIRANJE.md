# 🚀 BRZA UPUTSTVA ZA POKRETANJE

## 1️⃣ POKRETANJE APLIKACIJE

Otvori terminal u folderu projekta i pokreni:

```bash
# 1. Pokreni migracije (kreira tabele u bazi)
php artisan migrate

# 2. Napuni bazu test podacima (opciono)
php artisan db:seed

# 3. Pokreni aplikaciju
php artisan serve
```

Aplikacija će biti dostupna na: **http://localhost:8000**

---

## 2️⃣ TESTIRANJE JAVNE STRANE (bez logovanja)

### ✅ Scenario 1: Pregled putovanja
1. Otvori: `http://localhost:8000`
2. Trebalo bi da vidiš kartice sa dostupnim putovanjima
3. Svaka kartica ima dugme "Detalji"

### ✅ Scenario 2: Rezervacija putovanja
1. Klikni na "Detalji" bilo kog putovanja
2. Na desnoj strani vidiš cenu i rezervacionu formu
3. Popuni sva obavezna polja:
   - Ime i prezime
   - Email
   - Telefon
   - Broj odraslih (minimum 1)
   - Broj dece (opciono)
4. Klikni "Rezerviši"
5. **Očekivani rezultat:** Poruka uspešnosti i povratak na početnu

---

## 3️⃣ TESTIRANJE ADMIN PANELA (sa logom)

### ✅ Scenario 1: Registracija/Login
1. Idi na: `http://localhost:8000/register`
2. Registruj nalog sa bilo kojim email-om i lozinkom
3. Automatski ćeš biti ulogovan

**ILI** ako imaš seedovan test nalog:
- Email: `admin@example.com`
- Password: `password`

### ✅ Scenario 2: Kreiranje putovanja
1. Klikni na sidebar: **Putovanja → Unos**
2. Popuni formu:
   - Naziv (npr. "Pariz 2026")
   - Država (izaberi iz dropdown-a)
   - Grad (npr. "Pariz")
   - Mesto polaska (npr. "Beograd")
   - Datum od/do
   - Broj dana i noćenja
   - Cena (npr. 599.99)
   - Dostupna mesta (npr. 40)
   - Tip prevoza (bus/avion)
   - Program putovanja (tekstualno polje)
3. Klikni "Sačuvaj"
4. **Očekivani rezultat:** Poruka uspešnosti i prikaz u listi

### ✅ Scenario 3: Pregled rezervacija
1. Sidebar: **Rezervacije → Lista**
2. Trebalo bi da vidiš DataTable sa svim rezervacijama
3. Možeš:
   - Pretraživati po bilo kom polju
   - Sortirati kolone
   - Menjati broj prikaza po stranici

### ✅ Scenario 4: Izmena rezervacije
1. U listi rezervacija klikni na dugme **Edit** (žuto)
2. Izmeni neko polje (npr. status iz "nova" u "potvrđena")
3. Klikni "Sačuvaj"
4. **Očekivani rezultat:** Ažurirana rezervacija u listi

### ✅ Scenario 5: Brisanje rezervacije
1. U listi rezervacija klikni na **Obriši** (crveno)
2. Potvrdi brisanje
3. **Očekivani rezultat:** Rezervacija nestaje iz tabele

### ✅ Scenario 6: Izmena putovanja
1. Sidebar: **Putovanja → Lista**
2. Klikni na **Edit** bilo kog putovanja
3. Izmeni neki podatak (npr. cenu)
4. Klikni "Sačuvaj"
5. **Očekivani rezultat:** Putovanje ažurirano

### ✅ Scenario 7: Pokušaj brisanja putovanja sa rezervacijama
1. U listi putovanja pronađi putovanje koje ima rezervacije (kolona "Rezervacije" > 0)
2. Klikni na **Obriši**
3. **Očekivani rezultat:** Greška - "Ne možete obrisati putovanje koje ima rezervacije!"

---

## 4️⃣ PROVERA U BAZI PODATAKA

Otvori phpMyAdmin ili MySQL Workbench i proveri:

### Tabela `rezervacija`
```sql
SELECT * FROM rezervacija;
```
**Trebalo bi da vidiš:**
- Sve kreirane rezervacije
- `ukupna_cena` automatski izračunata
- `status` postavljen na "nova" (ili kako si izmenio)

### Tabela `putovanje`
```sql
SELECT naziv, broj_rezervacija FROM putovanje;
```
**Trebalo bi da vidiš:**
- `broj_rezervacija` ažuriran automatski
- Inkrementuje se pri kreiranju, dekrementuje pri brisanju

---

## 5️⃣ MOGUĆE GREŠKE I REŠENJA

### ❌ Greška: "SQLSTATE[42S02]: Base table or view not found"
**Rešenje:**
```bash
php artisan migrate:fresh --seed
```

### ❌ Greška: "Class 'Drzava' not found" ili slično
**Rešenje:**
```bash
composer dump-autoload
```

### ❌ Ne vidiš podatke na početnoj strani
**Proveri:**
1. Da li su tabele seedovane?
```bash
php artisan db:seed
```
2. Proveri u HomeController da li preuzima putovanja

### ❌ DataTable ne radi
**Proveri:**
1. Da li postoji JS fajl u `public/js/app/rezervacije/datatable.js`
2. Da li je axios učitan?
3. Proveri browser konzolu (F12) za JS greške

### ❌ Forma za rezervaciju ne šalje podatke
**Proveri:**
1. Da li je CSRF token u formi (`@csrf`)
2. Proveri browser Network tab (F12) da vidiš šta se šalje
3. Proveri validaciju u Request klasi

---

## 6️⃣ TESTIRANJE FUNKCIONALNOSTI

### ✅ Test 1: Automatski proračun cene
1. Kreiraj putovanje sa cenom 100€
2. Na javnoj strani rezerviši sa:
   - 2 odrasla
   - 1 dete
3. U bazi proveri `ukupna_cena` - trebalo bi da bude **250€**
   - Odrasli: 2 × 100 = 200
   - Dete: 1 × 50 = 50
   - **Ukupno: 250€**

### ✅ Test 2: Brojač rezervacija
1. Proveri broj rezervacija za putovanje (npr. 3)
2. Kreiraj novu rezervaciju za to putovanje
3. Proveri ponovo - trebalo bi da bude **4**
4. Obriši jednu rezervaciju
5. Proveri ponovo - trebalo bi da bude **3**

### ✅ Test 3: Zaštita od brisanja
1. Kreiraj putovanje
2. Kreiraj rezervaciju za to putovanje
3. Pokušaj da obrišeš putovanje
4. **Očekivano:** Greška poruka

---

## 7️⃣ NAPREDNE PROVERE (opciono)

### Test relacija u bazi
```sql
-- Proveri sve rezervacije sa nazivom putovanja
SELECT r.*, p.naziv as putovanje_naziv 
FROM rezervacija r 
LEFT JOIN putovanje p ON r.id_putovanja = p.id;

-- Proveri putovanja sa brojem rezervacija
SELECT p.naziv, p.broj_rezervacija, COUNT(r.id) as stvarne_rezervacije
FROM putovanje p
LEFT JOIN rezervacija r ON r.id_putovanja = p.id
GROUP BY p.id;
```

---

## 🎉 GOTOVO!

Ako svi testovi prolaze, aplikacija je **potpuno funkcionalna** i spremna za prezentaciju/ocenjivanje!

**Srećno! 🚀**
