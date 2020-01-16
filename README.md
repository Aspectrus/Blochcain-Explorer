# Blockchain Explorer

## Realizavimas

Blockchain naršyklė,  padaryta naudojant PHP ir XAMPP web serverį. SSH jungimuisi prie blockchain node naudojama phpseclib biblioteka.
Pradiniame lange matoma 15 naujausių blokų, jų aukštis, hash, iškasimo laikas ir dydis.
Yra paieškos langas kuriame galima ieškoti tranzakcijas, blokus pagal aukštį arba hash.
Ieškant arba paspaudžiant vieną iš 15 blokų, matoma detalesnė informacija, jų tranzakcijos.

## Naudojimui

Reikia turėti instaliavus PHP, tada reikia pasileisti ant php palaikančio web serverio, kaip XAMPP.
Naudoant XAMPP sukurkite instaliacijos direktojijoje  `xampp\htdocs` folderį su norimu, bet kokiu pavadinimu ir įkelkite github
atsisiųstus failus. Serveris pasiekamas per `http://localhost/sukurto folderio pavadinimas/`

![alt text](https://i.imgur.com/XYlJwln.png)