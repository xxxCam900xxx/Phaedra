const questions = [{
    name: "website_name",
    text: "Wie heisst ihre Webseite?",
    type: "text"
},
{
    name: "website_logo",
    text: "Laden Sie ein Logo hoch oder drücken Sie 'Enter'!",
    type: "file"
},
{
    name: "website_user",
    text: "Wer betreibt diese Webseite?",
    type: "text"
},
{
    name: "website_contact",
    text: "Geben Sie eine Email an!",
    type: "email"
},
{
    name: "website_pwd",
    text: "Definieren Sie ein Passwort für ihren admin-Benutzer:",
    type: "text"
},
{
    name: "website_pwd_confirm",
    text: "Passwort bestätigen:",
    type: "text"
}
];

let currentQuestion = 0;
const answers = [];

const terminal = document.getElementById("terminal");
const hiddenInput = document.getElementById("hidden-input");

let inputLine = null;
let inputTextSpan = null;
let fileInput = null;

let tempPassword = null;

window.addEventListener("click", () => hiddenInput.focus());
window.addEventListener("keydown", () => hiddenInput.focus());

function appendLine(text) {
    const div = document.createElement("div");
    div.textContent = ">> " + text;
    terminal.appendChild(div);
    terminal.scrollTop = terminal.scrollHeight;
    return div;
}

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email.toLowerCase());
}

function typeLine(text, callback) {
    if (!text) {
        // Nur Präfix ohne Text animieren
        appendLine(">> ");
        if (callback) callback();
        return;
    }

    let i = 0;
    const div = appendLine("");
    const interval = setInterval(() => {
        div.textContent = ">> " + text.slice(0, i);
        i++;
        if (i > text.length) {
            clearInterval(interval);
            if (callback) callback();
        }
    }, 20);
}


function appendInputLine() {
    if (fileInput) {
        fileInput.remove();
        fileInput = null;
    }
    inputLine = document.createElement("div");
    inputLine.textContent = ">> ";
    inputTextSpan = document.createElement("span");
    inputTextSpan.className = "blink-cursor";
    inputLine.appendChild(inputTextSpan);
    terminal.appendChild(inputLine);
    terminal.scrollTop = terminal.scrollHeight;
    hiddenInput.value = "";
    hiddenInput.disabled = false;
    hiddenInput.focus();
}

function appendFileInput() {
    hiddenInput.disabled = true;
    hiddenInput.value = "";

    fileInput = document.createElement("input");
    fileInput.type = "file";
    fileInput.accept = "image/*";

    const wrapper = document.createElement("div");
    wrapper.textContent = ">> ";
    wrapper.appendChild(fileInput);
    terminal.appendChild(wrapper);
    terminal.scrollTop = terminal.scrollHeight;
    fileInput.focus();

    // Datei wurde ausgewählt
    fileInput.onchange = () => {
        if (fileInput.files.length > 0) {
            const file = fileInput.files[0];
            wrapper.textContent = ">> " + file.name;
            fileInput.remove();
            answers.push(file);
            currentQuestion++;
            typeLine();
            askQuestion();
        }
    };

    // ENTER ohne Datei -> weiter ohne Auswahl
    fileInput.addEventListener("keydown", (e) => {
        if (e.key === "Enter") {
            e.preventDefault();
            wrapper.textContent = ">> (keine Datei ausgewählt)";
            fileInput.remove();
            answers.push(""); // Oder "" falls Sie leeren String bevorzugen
            currentQuestion++;
            typeLine();
            askQuestion();
        }
    });
}

function askQuestion() {
    if (currentQuestion < questions.length) {
        typeLine(questions[currentQuestion].text, () => {
            if (questions[currentQuestion].type === "file") {
                appendFileInput();
            } else {
                appendInputLine();
            }
        });
    } else {
        showLoadingProgress();
    }
}

function clearTerminal() {
    terminal.innerHTML = "";
}

function showLoadingProgress() {
    clearTerminal();
    typeLine("Vielen Dank für Ihre Antworten.");
    typeLine("Wir bereit alles für Sie vor", () => {
        const progressBarLength = 10;
        const packages = [
            "chalk", "webpack", "express", "react", "lodash", "typescript",
            "eslint", "prettier", "jest", "axios", "moment", "redux"
        ];

        function getProgressBar(pos) {
            let bar = "";
            for (let i = 0; i < progressBarLength; i++) {
                bar += (i === pos) ? "#" : "-";
            }
            return "[" + bar + "]";
        }

        function getRandomPackageStatus() {
            const pkg = packages[Math.floor(Math.random() * packages.length)];
            const percent = Math.floor(Math.random() * 100) + 1;
            return pkg + " " + percent + "%";
        }

        const loadingLines = [];
        for (let i = 0; i < 3; i++) {
            loadingLines.push(appendLine(""));
        }

        const positions = [0, 0, 0];
        const directions = [1, 1, 1];

        const interval = setInterval(() => {
            for (let i = 0; i < 3; i++) {
                positions[i] += directions[i];
                if (positions[i] === progressBarLength - 1 || positions[i] === 0) {
                    directions[i] *= -1;
                }
                const bar = getProgressBar(positions[i]);
                const pkgStatus1 = getRandomPackageStatus();
                const pkgStatus2 = getRandomPackageStatus();
                loadingLines[i].textContent = `>> ${bar}  ${pkgStatus1}  ${pkgStatus2}`;
            }
            terminal.scrollTop = terminal.scrollHeight;
        }, 100);

        setTimeout(() => {
            clearInterval(interval);
            for (let i = 0; i < 3; i++) {
                loadingLines[i].textContent = ">> [##########]  Installation complete";
            }
            typeLine("Sie werden gleich weitergeleitet. :D", () => {
                setTimeout(() => {
                    submitForm();
                }, 1500);
            });
        }, 5000);
    });
}

function submitForm() {
    const formData = new FormData();

    questions.forEach((q, index) => {
        const answer = answers[index];
        if (q.type === "file") {
            if (answer instanceof File) {
                formData.append(q.name, answer, answer.name);
            }
        } else {
            formData.append(q.name, answer);
        }
    });

    console.log("FormData-Inhalte:");
    for (const pair of formData.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }

    fetch("/api/launcher/index.php", {
        method: "POST",
        body: formData
    })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => {
                    throw new Error(`Server antwortete mit Status ${response.status}: ${text}`);
                });
            }
            return response.text();
        })
        .then(data => {
            console.log("Erfolgreich gesendet:", data);
            window.location.href = "/admin/login";
        })
        .catch(error => {
            console.error("Fehler beim Absenden des Formulars:", error);
            alert("Fehler beim Absenden des Formulars: " + error.message);
        });
}

function validatePassword(pwd) {
    const minLength = 8;
    const hasNumber = /\d/;
    if (pwd.length < minLength) return false;
    if (!hasNumber.test(pwd)) return false;
    return true;
}

hiddenInput.addEventListener("input", () => {
    if (!inputTextSpan) return;

    const currentQ = questions[currentQuestion];
    if (currentQ && (currentQ.name === "website_pwd" || currentQ.name === "website_pwd_confirm")) {
        inputTextSpan.textContent = "*".repeat(hiddenInput.value.length);
    } else {
        inputTextSpan.textContent = hiddenInput.value;
    }
});

hiddenInput.addEventListener("keydown", (e) => {
    if (e.key === "Enter") {
        e.preventDefault();
        const answer = hiddenInput.value.trim();
        if (answer === "") return;

        const currentQ = questions[currentQuestion];

        // Passwortvalidierung
        if (currentQ.name === "website_pwd") {
            if (!validatePassword(answer)) {
                appendLine(">> ERROR: Passwort zu schwach. Es muss mindestens 8 Zeichen lang sein und eine Zahl enthalten!");
                hiddenInput.value = "";
                inputTextSpan.textContent = "";
                return;
            }
            tempPassword = answer;
            answers.push(answer);
            inputLine.textContent = ">> " + "*".repeat(answer.length);
            hiddenInput.value = "";
            currentQuestion++;
            typeLine();
            askQuestion();
            return;
        }

        // Passwortbestätigung
        if (currentQ.name === "website_pwd_confirm") {
            if (answer !== tempPassword) {
                appendLine(">> ERROR: Passwörter stimmen nicht überein!");
                hiddenInput.value = "";
                inputTextSpan.textContent = "";
                return;
            }
            answers.push(answer);
            inputLine.textContent = ">> " + "*".repeat(answer.length);
            hiddenInput.value = "";
            currentQuestion++;
            typeLine();
            askQuestion();
            return;
        }

        // E-Mail-Validierung
        if (currentQ.name === "website_contact") {
            if (!validateEmail(answer)) {
                appendLine(">> ERROR: Ungültige E-Mail-Adresse!");
                hiddenInput.value = "";
                inputTextSpan.textContent = "";
                return;
            }
        }

        // Standard-Verarbeitung
        answers.push(answer);
        inputLine.textContent = ">> " + answer;
        hiddenInput.value = "";
        currentQuestion++;
        typeLine();
        askQuestion();
    }
});

typeLine("Willkommen beim MythosMorph Launcher Terminal.", () => {
    typeLine("Dies hier ist der Startlauncher, sie werden den nur einmalig ausführen müssen,", () => { });
    typeLine("Danach wird die Webseite für Sie völlig eingerichtet sein, sodass Sie einfach und gemütlich starten können.", () => {
        typeLine("Fangen wir an!", () => {
            typeLine("", () => {
                askQuestion();
            });
        });
    });
});