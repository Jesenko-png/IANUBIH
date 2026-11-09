# CMS: Organizacija

Sekcija je dostupna administratorima na `/admin/organization` i koristi postojeću tabelu `academy_pages`. Nije potrebna nova migracija niti promjena baze.

U panelu se odvojeno uređuju bosanska i engleska verzija:

- glavna stranica Organizacije;
- Uprava, Predsjedništvo, Skupština, Povjerenstva i Stručne službe;
- pregled razreda i svaka stranica razreda;
- pregled ogranaka i svaka stranica ogranka;
- profil, biografija i fotografija predsjednika.

Naziv sačuvan za pojedinu stranicu automatski se koristi i na karticama pregleda. Novi sadržaj je običan tekst i HTML se ne izvršava.

Kod ručnog postavljanja na podijeljeni hosting, aplikacijski fajlovi idu u `ianubih_app`, a izmijenjeni CSS fajlovi iz lokalnog `public` foldera idu u `public_html`.
