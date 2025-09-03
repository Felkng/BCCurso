/**
 * Scripts para gerenciar mensagens de alerta
 */
document.addEventListener("DOMContentLoaded", function () {
  // Criar o container de alertas se não existir
  if (!document.querySelector(".alert-container")) {
    const alertContainer = document.createElement("div");
    alertContainer.className = "alert-container";
    document.body.appendChild(alertContainer);
  }

  // Auto-fechar alertas após 5 segundos
  const alerts = document.querySelectorAll(".alert");

  alerts.forEach((alert) => {
    setTimeout(() => {
      alert.classList.add("alert-fade-out");
      setTimeout(() => {
        if (alert.parentNode) {
          alert.parentNode.removeChild(alert);
        }
      }, 500);
    }, 5000);
  });

  // Fechar alerta ao clicar no botão de fechar
  document.addEventListener("click", function (event) {
    if (event.target.closest(".btn-close")) {
      const alert = event.target.closest(".alert");
      alert.classList.add("alert-fade-out");
      setTimeout(() => {
        if (alert.parentNode) {
          alert.parentNode.removeChild(alert);
        }
      }, 500);
    }
  });
});

/**
 * Função para mostrar mensagem de sucesso
 */
function showSuccessMessage(message, title = "Sucesso!") {
  // Garantir que o container existe
  let alertContainer = document.querySelector(".alert-container");
  if (!alertContainer) {
    alertContainer = document.createElement("div");
    alertContainer.className = "alert-container";
    document.body.appendChild(alertContainer);
  }

  const alertHtml = `
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <div class="alert-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="alert-content">
                <div class="alert-title">${title}</div>
                <p class="alert-message">${message}</p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;

  alertContainer.insertAdjacentHTML("afterbegin", alertHtml);

  // Auto-fechar após 5 segundos
  const alert = alertContainer.querySelector(".alert:first-child");
  setTimeout(() => {
    alert.classList.add("alert-fade-out");
    setTimeout(() => {
      if (alert.parentNode) {
        alert.parentNode.removeChild(alert);
      }
    }, 500);
  }, 5000);
}

/**
 * Função para mostrar mensagem de erro
 */
function showErrorMessage(message, title = "Erro!") {
  // Garantir que o container existe
  let alertContainer = document.querySelector(".alert-container");
  if (!alertContainer) {
    alertContainer = document.createElement("div");
    alertContainer.className = "alert-container";
    document.body.appendChild(alertContainer);
  }

  const alertHtml = `
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <div class="alert-icon">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div class="alert-content">
                <div class="alert-title">${title}</div>
                <p class="alert-message">${message}</p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;

  alertContainer.insertAdjacentHTML("afterbegin", alertHtml);

  // Auto-fechar após 5 segundos
  const alert = alertContainer.querySelector(".alert:first-child");
  setTimeout(() => {
    alert.classList.add("alert-fade-out");
    setTimeout(() => {
      if (alert.parentNode) {
        alert.parentNode.removeChild(alert);
      }
    }, 500);
  }, 5000);
}

/**
 * Função para mostrar mensagem de aviso
 */
function showWarningMessage(message, title = "Atenção!") {
  // Garantir que o container existe
  let alertContainer = document.querySelector(".alert-container");
  if (!alertContainer) {
    alertContainer = document.createElement("div");
    alertContainer.className = "alert-container";
    document.body.appendChild(alertContainer);
  }

  const alertHtml = `
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <div class="alert-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="alert-content">
                <div class="alert-title">${title}</div>
                <p class="alert-message">${message}</p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;

  alertContainer.insertAdjacentHTML("afterbegin", alertHtml);

  // Auto-fechar após 5 segundos
  const alert = alertContainer.querySelector(".alert:first-child");
  setTimeout(() => {
    alert.classList.add("alert-fade-out");
    setTimeout(() => {
      if (alert.parentNode) {
        alert.parentNode.removeChild(alert);
      }
    }, 500);
  }, 5000);
}

/**
 * Função para mostrar mensagem informativa
 */
function showInfoMessage(message, title = "Informação") {
  // Garantir que o container existe
  let alertContainer = document.querySelector(".alert-container");
  if (!alertContainer) {
    alertContainer = document.createElement("div");
    alertContainer.className = "alert-container";
    document.body.appendChild(alertContainer);
  }

  const alertHtml = `
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <div class="alert-icon">
                <i class="fas fa-info-circle"></i>
            </div>
            <div class="alert-content">
                <div class="alert-title">${title}</div>
                <p class="alert-message">${message}</p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;

  alertContainer.insertAdjacentHTML("afterbegin", alertHtml);

  // Auto-fechar após 5 segundos
  const alert = alertContainer.querySelector(".alert:first-child");
  setTimeout(() => {
    alert.classList.add("alert-fade-out");
    setTimeout(() => {
      if (alert.parentNode) {
        alert.parentNode.removeChild(alert);
      }
    }, 500);
  }, 5000);
}
