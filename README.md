# Integrare Magento 1

 * [Introducere](#introducere)
 * [Functionalitati](#functionalitati)
 * [Instalare](#instalare)
 * [Configurare](#configurare)
 * [Support](#support)
 * [License](#license)

## Introducere

SMSO va ofera un modul destinat pentru pentru Magento versiunea 1. 
Modulul ne ofera o integrare simpla si rapida intre platforma SMSO si un magazin online dezvoltat pe baza plataformei Magento 1.
Pentru functionarea corecta a acestui modul va rog sa luati in calcul urmataorea informatie:
- Textul sablon
	- Mărimea maximă a unui mesaj SMS standard este de 160 caractere.
	- SMS concatenat:  Dacă mesajul depășeste 160 caractere se trimit 2 sau mai multe mesaje, destinatarul receptionand un singur mesaj.
	- Dacă mesajul depășeste 160 caractere sau are caractere speciale (diacritice, emoji), atunci mărimea maximă scade la 153 caractere sau 63 caractere / mesaj după cum urmează:
		- Dacă mesajul nu are caractere specale și este mai mic sau egal cu 160 caractere este considerat ca 1 mesaj.
		- Dacă mesajul depășește 160 caractere, devine mesaj multiplu format din mesaje a caror dimensiune maximă este de 153 caractere.
		- Dacă mesajul are caractere specale și este mai mic sau egal cu 70 caractere este considerat ca 1 mesaj. 
		- Dacă mesajul are caractere speciale, devine mesaj multiplu format din mesaje a căror dimensiune maximă este de 63 caractere.

- Expeditori
	- 18xx - Sender numar scurt shared, valabil in toate retelele nationale. Permite trimiterea de mesaje SMS unidirectional.
	- 17xx - Sender numar scurt dedicat. Expeditor numar scurt 17xx valabil in toate retelele nationale. Mesajele trimise cu acest expeditor sunt bidirecționale, destinatarul mesajului poate răspunde celui care a initiat trimiterea SMS-ului
	- Eeticheta personalizată: Expeditor personalizat cu numele brandului tau - pana la 11 caractere alfanumerice (exemplu: Blackfriday, Notify, Verify). Mesajele trimise astfel sunt mesaje unidirecționale.
	- 07xxxxxxxx: Expeditor numar lung, pentru costuri mai mici. Permite comunicatie bidirectionala.
	- Solutie personalizată - Dacă aveți nevoie de o solutie personalizata, [ne puteti contacta.](http://smso.ro)
	
## Functionalitati

Modulul ofera urmatoarele functionalitati:
 - Trimite un SMS catre client in urma urmatoarelor actiuni:
 	- Comanda a fost plasata cu succes.
 	- Comanada a fost platita.
 	- Comanda a fost predata catre curier.
 	- Comanda a fost finisata cu success.
 	- Comanda a fost anulata.
 	- Comanda a fost returnata.
 - Pentru fiecare tip de mesaj este posibil de a defeni cite un sablon text.
 - Instalare rapida.
 - O interfata simpla de configurare.
 - Dezinstalare rapida.

## Instalare

- Instalare modulul cu instrumentul [modman](https://github.com/colinmollenhour/modman).
```bash
modman clone {{git-url}}
```

## Configurare

Dupa ce s-a instalat modulul este nevoie sa va autentificati pe pagina de administrare.
Pluginul se va gasit la pe urmatorul path:
```
System -> Configuration -> (Sales) SMSO Settings
```
Pentru configurare urmariti urmatorii pasi de configurare:
 - Activarea modului
 - Introduceti API Key pe care il gasiți in secțiunea Tools pe platforma SMSO. [Link](https://app.smso.ro/developers/api)
 - Salvati Configurariile
 - Selectati un Expeditor din lista incarcata.
 - Setați textul mesajului in functie de statusul comenzii folosind niste variabile simple.

## Support

In cazul ca aveti nevoie de ajutor va rugam sa contactati echipa [SMSO](http://smso.ro)
sau [puteti adauga un issue aici](https://github.com/smso/magento1-module/issues)

## License

The code is licensed under [MIT](https://opensource.org/licenses/MIT).
