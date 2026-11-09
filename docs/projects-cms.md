# CMS: Projekti

Administratorski modul `/admin/projects` dodaje kartice u postojeći registar projekata na javnoj stranici `/bs/projects` i `/en/projects`.

Modul uređuje samo projekte u gridu. Ostatak stranice Projekti ostaje u postojećim jezičkim datotekama. Postojeće statične kartice, uključujući NANO-THINK i Budućnost Bosanske Posavine, ostaju prikazane.

Svaki projekat sadrži:

- bosanski i engleski naslov, vrstu, program i opis;
- status projekta (aktivan ili završen);
- do četiri reda informacija na oba jezika;
- nacrt ili javnu objavu;
- redoslijed među projektima dodanim kroz CMS.

Nova tabela `projects` može se pripremiti dugmetom u panelu koje je dostupno glavnom administratoru. Za ručni phpMyAdmin postupak postoji `deploy/projects-cms-phpmyadmin.sql`.
