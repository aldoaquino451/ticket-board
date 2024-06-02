Ticket Board
===

Questo progetto è un sistema di gestione dei ticket progettato per semplificare il processo di gestione dei problemi e delle richieste di supporto dei clienti. Il sistema supporta vari ruoli utente, inclusi operatori e amministratori, e fornisce un set completo di funzionalità per gestire i ticket in modo efficiente.


## Funzionalità

### Ticket
- **Creazione Ticket**: Gli utenti non autenticati possono aprire un ticket per risolvere i loro problemi assegnando un titolo, una descrizione e una categoria.
- **Status Ticket** Il sistema inserisce i nuovi ticket in una coda o li assegna direttamente a un operatore disponibile.

### Autenticazione
- **Registrazione**: I nuovi utenti possono registrarsi nel ruolo di admin inserendo nome e cognome, nome utente, email e password.
- **Login**: Gli utenti registrati possono effettuare il login per accedere al sistema.
- **Password dimenticata**: Gli utenti che hanno perso la propria password possono accedere soltanto assegnandone una nuova. 
All'indirizzo mail fornito, verrrà inviato un link che permetterà di accedere ad una pagina dove si potrà inserire la nuova password.
- **Modifica Dati Personali**: Gli utenti possono aggiornare le loro informazioni personali, compresa la password.
- **Cancellazione Profilo**: Gli utenti che decidono di non usufruire più del servizio possono decidere di cancellare il proprio profilo.

### Admin
- **Accesso a Liste**: Gli amministratori possono visualizzare l'elenco degli operatori e dei ticket.
- **Modifica Entità**: Gli amministratori possono eseguire varie modifiche, come cambiare lo stato di un ticket o riassegnarlo ad un nuovo operatore.

### Operatore
- **Ricezione Email**: Gli operatori ricevono una notifica via email quando un ticket viene loro assegnato.
- **Visualizzazione Ticket**: Gli operatori possono visualizzare e gestire il ticket a loro assegnato.
- **Gestione Disponibilità**: Gli operatori possono impostare il loro stato come disponibile o non disponibile.

### Note
- **Aggiunta Nota**: Gli operatori possono aggiungere note a un ticket.
- **Modifica e Cancellazione Nota**: Le note possono essere modificate o cancellate direttamente nella pagina di visualizzazione del ticket.

### Interfaccia Utente
- **Modalità Chiara/Scura**: In base alle impostazioni del browser verrà assegnata la modalità chiara o la modalità scura, in alternativa l'utente può passare dall'una all'altra tramite un pulsante.
- **Paginazione**: Le lunghe liste di ticket o operatori sono paginate per una navigazione più semplice.
- **Filtri**: Gli utenti possono filtrare i risultati per trovare rapidamente specifici ticket o operatori.

### Email
- **Notifiche**: Il sistema invia notifiche via email agli operatori quando viene loro assegnato un ticket o quando l'utente che l'ha creato decide di chiuderlo. Queste email possono essere visualizzate su Mailtrap.


## Installazione

Per eseguire localmente il progetto, segui questi passaggi:

1. Clona il repository:
    ```bash
    git clone -b dev https://github.com/aldoaquino451/ticket-board
    cd ticket-board
    ```

2. Installa le dipendenze:
    ```bash
    npm install
    composer install
    ```

3. Crea il file .env e assegna un valore alla key:
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. Nel file .env modifica o aggiorna la seguenti costanti:
    ```bash
    APP_NAME='Ticket Board'

    DB_DATABASE
    DB_PASSWORD

    MAIL_HOST=sandbox.smtp.mailtrap.io
    MAIL_FROM_ADDRESS="noreply@ticketboard.com"

    MAIL_PORT
    MAIL_USERNAME
    MAIL_PASSWORD
    ```

5. Avvia il server di sviluppo:
    ```bash
    npm run dev
    php artisan serve
    ```

5. Apri il browser e clicca sul seguente [link](http://127.0.0.1:8000/) per vedere l'applicazione in esecuzione.


## Licenza

Questo progetto è distribuito sotto la licenza MIT. Vedi il file [LICENSE](LICENSE) per maggiori dettagli.

## Contatti

Per qualsiasi domanda o feedback, puoi contattarci all'indirizzo email [aldo.aquino2909@gmail.com](mailto:aldo.aquino2909@gmail.com) e [michele.arcopinto@outlook.it](mailto:michele.arcopinto@outlook.it) o attraverso i profili LinkedIn [Aldo Aquino](https://www.linkedin.com/in/aldo-aquino-dev/) e [Michele Arcopinto](https://www.linkedin.com/in/michele-arcopinto/) 


