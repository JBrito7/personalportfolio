// Função executada quando o usuário envia o Form.
document.getElementById("contactForm")
        .addEventListener("submit", function (event) {
        event.preventDefault();

    // Valores a ser usados.
    const userName = document.getElementById("userName").value.trim();
    const phoneNumber = document.getElementById("phoneNumber").value.trim();
    const emailAddress = document.getElementById("emailAddress").value.trim();
    const messageArea = document.getElementById("messageArea").value.trim();
    const feedbackDiv = document.getElementById("formFeedback");

    // Funçao que mostra mensagem de sucesso ou de erro após o envio do formulário
    function showFeedback(message, type = "error") {
        feedbackDiv.textContent = message;
        feedbackDiv.className = `feedback-message ${type}`;
        feedbackDiv.classList.remove("d-none");

      //Mensagem desaparece após 5 segundos
        setTimeout(() => {
        feedbackDiv.classList.add("d-none");
        }, 5000);
    }

    // Validação de todos os campos obrigátoria.
    if (!userName || !phoneNumber || !emailAddress || !messageArea) {
        showFeedback("Todos os campos são obrigatórios!");
        return;
    }

    // Validação do número de telefone e do e-mail do usuário com Regex.
    var phoneNumberRegex = /^\+?\d{9,15}$/;
    var emailAddressRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!phoneNumberRegex.test(phoneNumber)) {
        showFeedback(
        'Telefone inválido! Digite 9 a 15 dígitos (pode começar com "+").'
        );
        return;
    }

    // Validaçao do e-mail
    if (!emailAddressRegex.test(emailAddress)) {
        showFeedback("E-mail inválido! Por favor, insira um e-mail válido.");
        return;
    }

    // Confirma o envio do formulário com sucesso.
    showFeedback(
        "Obrigado pelo seu contacto! Responderei em breve.",
        "success"
    );
    document.getElementById("contactForm").reset();
});

// Localizaçao e mapa

document.addEventListener("DOMContentLoaded", function () {
    const fixedLocation = L.latLng(49.6117, 6.13);
    const map = L.map("map").setView(fixedLocation, 13);
    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution: "© OpenStreetMap contributors",
    }).addTo(map);
    const marker = L.marker(fixedLocation).addTo(map);

    window.calculateRoute = function () {
    const destination = encodeURIComponent(
        document.getElementById("destination").value
    );
    const url =
        "https://nominatim.openstreetmap.org/search?format=json&q=" + destination;

    fetch(url)
        .then((response) => response.json())
        .then((json) => {
        if (json.length > 0) {
            const lat = json[0].lat;
            const lon = json[0].lon;
            const routeUrl =
            "https://www.openstreetmap.org/directions?engine=graphhopper_car&route=" +
            fixedLocation.lat +
            "," +
            fixedLocation.lng +
            ";" +
            lat +
            "," +
            lon;
            window.open(routeUrl, "_blank");
        } else {
            alert("Destino não encontrado!");
        }
    })

    .catch((error) => {
        console.error("Erro na procura da localização: ", error);
        alert("Erro na procura da localização!");
    });
    };
});

// Actualizar o ano do Copyright automaticamente

document.getElementById("year").textContent = new Date().getFullYear();
