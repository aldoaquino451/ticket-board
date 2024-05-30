Ticket Board
===

### How to install the project on the local server
1. `composer install`
2. `npm install`
3. `cp .env.example .env`
4. `php artisan key:generate`
3. `php artisan serve`
4. `npm run dev`


## to do list
michele:
- bug delle note:
  - perchè cambiano i colori
  - se si modifica una nota si cancella 
- creare api che permettono di filtrare:
  - senza ricarico della pagina
  - con paginazione

aldo:
- crud categorie:
  - crea aggiorna e elimina
- documentazione: funzionalità del sito web:
  - flusso ticket: crea ticket, cosa succede? coda o assegnato, mnadare mail
  - flusso operatore: riceve mail, diventa non dispobile, visulizza ticket
  - flusso note: aggiunta, modifica, cancellazione direttamente nella pagina di visualizzazione del ticket
  - flusso autenticazione: registrazione, login, modifica dati personali
  - flusso admin: accedere a lista operatori, ticket e varie modifiche
  - light/dark mode: toogle bottone (oppure in base alla mode del browser??)
  - paginazione di diversi liste
  - filtraggio risultati
  - su mailtrap si visualizza la mail che viene mandata dal sistema all'operatore quando gli viene assegnato un ticket o quando lo user non autenticato chiude il ticket


per ultimo
- crud degli operatori ?? dobbiamo creare un nuovo operatore?
  - udpate: l'operatore deve avere un flag per segnalare la sua disponibilità
- input di ricerca per nome??
- clicco su nome colonna della tabella e applico order by asc e desc