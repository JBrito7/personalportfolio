// Serviços
document.addEventListener("DOMContentLoaded", function () {
  const servicesMenu = document.getElementById("services-menu");
  const servicesDetails = document.getElementById("services-details");

  // Function para carregar os serviços do arquivo JSON
  function loadServices() {
    fetch("../json/services.json")
      .then((response) => response.json())
      .then((services) => {
        servicesMenu.innerHTML = "";

        // Add os serviços ao menu
        services.forEach((service) => {
          const item = document.createElement("li");
          item.className = "list-group-item";
          item.textContent = service.title;
          item.dataset.id = service.id;

          //Evento de clique para carregar os detalhes
          item.addEventListener("click", () => loadDetails(service));
          servicesMenu.appendChild(item);
        });

        //Iniciar com os detalhes do primeiro serviço AUTO
        if (services.length > 0) {
          loadDetails(services[0]);
        }
      })

      .catch((error) => console.log("Erro ao carregar os serviços:", error));
  }

  //Function para carregar os detalhes do serviço
  function loadDetails(service) {
    servicesDetails.innerHTML = `
            <h2>${service.title}</h2>
            <img src="${service.image}" alt="${service.title}">
            <p>${service.description}</p>
        `;
  }

  // Carrega os serviços qnd a página é carregada
  loadServices();
});

// Buget
// Botão de enviar o formulário
const sendFormBtn = document.getElementById("budget-form");

sendFormBtn.addEventListener("submit", function (event) {
  event.preventDefault();

  // Valores dos obtidos do usuário
  const name = document.getElementById("name").value;
  const email = document.getElementById("email").value;
  const projectType = document.getElementById("project-type").value;
  const projectSize = parseFloat(document.getElementById("project-size").value);
  const description = document.getElementById("description").value;

  // Validaçõ de todos os campos obrigatória
  if (!name || !email || !projectType || !projectSize || !description) {
    alert("Por favor, preencha todos os campos.");
    return;
  }

  // Definição do preço por página
  let priceForPage;
  switch (projectType) {
    case "webdesign":
      priceForPage = 200;
      break;

    case "webdevelopment":
      priceForPage = 400;
      break;

    case "uxui":
      priceForPage = 150;
      break;

    default:
      priceForPage = 0;
  }

  // Calcúlos para o orçamento
  const budget = priceForPage * projectSize;
  const budgetResult = document.getElementById("budget-result");

  budgetResult.innerHTML = `<h3>Preço estimado do seu orçamento</h3>
          <p>Nome: ${name}</p>
          <p>E-mail: ${email}</p>
          <p>Tipo de Projeto: ${projectType}</p>
          <p>Tamanho do projeto: ${projectSize}</p>
          <p>Descrição do projeto: ${description}</p>
          <p><strong>Orçamento Estimado: ${budget.toFixed(2)}€</strong></p>`;

  budgetResult.style.display = "flex"; // Add a div com resultado
});

// FAQ Accordion jQuery
$(document).ready(function () {
  $(".faq-question").on("click", function () {
    $(this).next(".faq-answer").slideToggle();
    $(this).parent().siblings().find(".faq-answer").slideUp();
  });
});
