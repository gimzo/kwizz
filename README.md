kwizz
=====
Requirements:
- http server (testirano na apache2)
- php 5
- php mysqli
- MySQL

Instalacija:
- cijeli direktorij iskrcati negdje unutar webRoota servera
- kreirati bazu i usera s pristupom toj bazi
- kreirati db shemu i example podatke koristeći prilozenu sql skriptu
- konfigurirati podatke za pristup bazi u resources/config.php


Live
====
- dodatak osnovnoj aplikaciji za igranje 2 igraca uzivo
- optional instalacija

Requirements:
- Python 2
- Autobahn Python
- Twisted
- instaliran i funkcionalan kwizz

Instalacija
- instalirati potrebne requiremente
- iskrcati live direktorij negdje (po mogućnosti NE unutar web servera)
- iskonfigurirati URL do kwizz-a u live.py
- pokrenuti live.py (python live.py na unix-like sustavima)

Ostalo
- Live koristi port 9000 za spajanje s klijentima, potrebno je da bude otvoren od klijenata prema serveru
- 
