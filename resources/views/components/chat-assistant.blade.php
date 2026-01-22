
@php
    $roleName = $role ?? (Auth::user()->role ?? 'utilisateur');
    $quickPrompts = match ($roleName) {
        'admin' => [
            "Combien de paiements en attente ?",
            "Top collecteurs ?",
            "Montant encaissé ce mois-ci ?",
            "Combien de clients actifs ?",
        ],
        'collecteur' => [
            "Montant encaissé ce mois-ci ?",
            "Combien de paiements en attente ?",
            "Dernière transaction ?",
            "Combien de clients suivis ?",
        ],
        'client' => [
            "Quel est mon solde ?",
            "Dernière transaction ?",
            "Dernier paiement ?",
            "Comment contacter le support ?",
        ],
        default => [
            "Bonjour !",
            "Que peux-tu faire ?",
        ],
    };
@endphp

@once
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .assistant-widget {
            position: fixed;
            right: 20px;
            bottom: 20px;
            z-index: 1200;
        }
        .assistant-toggle {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #0E8D4D;
            color: #fff;
            border: none;
            border-radius: 999px;
            padding: 10px 14px;
            box-shadow: 0 10px 30px rgba(14, 141, 77, 0.25);
            font-weight: 600;
            cursor: pointer;
        }
        .assistant-panel {
            width: 340px;
            max-height: 520px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.18);
            overflow: hidden;
            display: none;
            flex-direction: column;
        }
        .assistant-panel.active { display: flex; }
        .assistant-header {
            background: #0E8D4D;
            color: #fff;
            padding: 14px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .assistant-title { font-weight: 700; }
        .assistant-close {
            background: transparent;
            border: none;
            color: #fff;
            font-size: 20px;
            cursor: pointer;
        }
        .assistant-body { padding: 12px 14px; display: flex; flex-direction: column; gap: 10px; }
        .assistant-messages {
            flex: 1;
            overflow-y: auto;
            max-height: 320px;
            padding-right: 4px;
        }
        .assistant-msg {
            margin-bottom: 10px;
            padding: 10px 12px;
            border-radius: 12px;
            background: #f7f9fb;
            font-size: 14px;
        }
        .assistant-msg.user { background: #e8f5ff; border: 1px solid #cde7ff; }
        .assistant-msg.bot { background: #f4f9f6; border: 1px solid #d8efe3; }
        .assistant-quick { display: flex; flex-wrap: wrap; gap: 6px; }
        .assistant-chip {
            border: 1px solid #dfe7ee;
            background: #f7f9fb;
            border-radius: 999px;
            padding: 6px 10px;
            cursor: pointer;
            font-size: 12px;
        }
        .assistant-input {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        .assistant-input input {
            flex: 1;
            border: 1px solid #dfe3e8;
            border-radius: 10px;
            padding: 10px 12px;
        }
        .assistant-send {
            background: #0E8D4D;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 12px;
            cursor: pointer;
        }
        .assistant-status { font-size: 12px; color: #6b7280; padding-left: 4px; }
    </style>
@endonce

<div class="assistant-widget">
    <button class="assistant-toggle" id="assistant-toggle">
        🤖 Assistant IA
    </button>
    <div class="assistant-panel" id="assistant-panel" data-prompts='@json($quickPrompts)'>
        <div class="assistant-header">
            <div>
                <div class="assistant-title">Assistant IA</div>
                <small>Profil : {{ ucfirst($roleName) }}</small>
            </div>
            <button class="assistant-close" id="assistant-close" aria-label="Fermer le chat">×</button>
        </div>
        <div class="assistant-body">
            <div class="assistant-messages" id="assistant-messages">
                <div class="assistant-msg bot">👋 Bonjour, je connais vos données (clients, paiements, transactions). Posez votre question ou utilisez un raccourci ci-dessous.</div>
            </div>
            <div class="assistant-quick" id="assistant-quick"></div>
            <div class="assistant-status" id="assistant-status"></div>
            <div class="assistant-input">
                <input type="text" id="assistant-input" placeholder="Posez votre question...">
                <button class="assistant-send" id="assistant-send">Envoyer</button>
            </div>
        </div>
    </div>
</div>

@once
    <script>
        (() => {
            const panel = document.getElementById('assistant-panel');
            const toggle = document.getElementById('assistant-toggle');
            const closeBtn = document.getElementById('assistant-close');
            const messages = document.getElementById('assistant-messages');
            const input = document.getElementById('assistant-input');
            const sendBtn = document.getElementById('assistant-send');
            const quick = document.getElementById('assistant-quick');
            const status = document.getElementById('assistant-status');
            const prompts = JSON.parse(panel.dataset.prompts || '[]');

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            const appendMessage = (text, type = 'bot') => {
                const div = document.createElement('div');
                div.className = `assistant-msg ${type}`;
                div.textContent = text;
                messages.appendChild(div);
                messages.scrollTop = messages.scrollHeight;
            };

            const setStatus = (text) => {
                status.textContent = text;
            };

            const sendMessage = async () => {
                const value = input.value.trim();
                if (!value) return;

                appendMessage(value, 'user');
                input.value = '';
                setStatus('Réflexion en cours...');

                try {
                    const response = await fetch('/assistant/chat', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken || '',
                        },
                        body: JSON.stringify({ message: value }),
                    });

                    const data = await response.json();
                    appendMessage(data.reply ?? "Je n'ai pas pu formuler de réponse.");
                } catch (e) {
                    appendMessage("Une erreur est survenue. Veuillez réessayer.");
                } finally {
                    setStatus('');
                }
            };

            prompts.forEach((prompt) => {
                const btn = document.createElement('button');
                btn.className = 'assistant-chip';
                btn.type = 'button';
                btn.textContent = prompt;
                btn.addEventListener('click', () => {
                    input.value = prompt;
                    sendMessage();
                });
                quick.appendChild(btn);
            });

            toggle.addEventListener('click', () => {
                panel.classList.toggle('active');
            });

            closeBtn.addEventListener('click', () => {
                panel.classList.remove('active');
            });

            sendBtn.addEventListener('click', sendMessage);
            input.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    sendMessage();
                }
            });
        })();
    </script>
@endonce
