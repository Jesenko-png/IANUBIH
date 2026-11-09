# CMS: O akademiji

Nova stavka u postojećem administratorskom panelu: `/admin/academy`.
Pristup imaju postojeće uloge `admin` i `super_admin`.

## Uređivanje

- Glavna stranica: postojeći tekstovi i dodatni naslov/tekst na kraju stranice.
- Podstranice: misija i vizija, poruka predsjednika, pravilnici, statut, izvještaji, planovi rada i historija.
- Bosanski i engleski sadržaj čuvaju se zasebno, zajedno u jednoj transakciji.
- Dugme „Sačuvaj sadržaj“ odmah mijenja javni prikaz u tom okruženju.
- Tekst je običan tekst; HTML se ne izvršava. Novi redovi prikazuju se u tekstu podstranica i dodatnom tekstu glavne stranice.
- Ovo ne dodaje nove URL adrese ili stavke menija, upload dokumenata/slika niti uređivanje drugih sekcija.

## Objavljivanje na serveru — tek uz odobrenje vlasnika

1. Napraviti backup baze i trenutne verzije koda te potvrditi proceduru vraćanja.
2. Provjeriti izmjene u testnom okruženju.
3. Postaviti novu verziju koda prema postojećoj proceduri hostinga.
4. Pokrenuti `php artisan migrate --force`. Nova migracija samo dodaje tabelu `academy_pages`; ne mijenja postojeće tabele niti postojeći sadržaj.
5. Osvježiti Laravel cache prema postojećoj proceduri hostinga.
6. Provjeriti `/bs/about`, `/en/about`, podstranice i pristup administratora.

Prije migracije javne stranice koriste postojeći sadržaj iz jezičkih datoteka, a panel prikazuje obavijest da CMS treba pripremiti. Nakon migracije početni prikaz ostaje isti dok administrator ne sačuva izmjene. Nazivi stavki menija ostaju postojeći; CMS naslov mijenja naslov same podstranice.

Za povratak na prethodni kod može se ostaviti nova tabela u bazi. Ne pokretati rollback migracije bez backupa: rollback briše tabelu i sve tekstove sačuvane kroz ovaj CMS.

## Lokalna provjera

`php vendor/phpunit/phpunit/phpunit` koristi SQLite bazu u memoriji prema `phpunit.xml`, bez pristupa produkcijskoj bazi. Za pokretanje bez lokalne `.env` datoteke postaviti testni `APP_KEY` u procesu.
