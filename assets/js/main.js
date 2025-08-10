$(document).ready(function () {
  initializeApp();

  $("#client-select").on("change", function () {
    changeClient($(this).val());
  });

  $("#module-select").on("change", function () {
    changeModule($(this).val());
  });
});

function initializeApp() {
  let currentClient = localStorage.getItem("selectedClient") || "clienta";
  $("#client-select").val(currentClient);

  $(".dynamic-div").attr("data-client", currentClient);

  updateModuleSelector(currentClient);

  authenticateClient(currentClient, function () {
    loadModule("cars", "list");
  });
}

function changeClient(clientId) {
  authenticateClient(clientId, function () {
    $(".dynamic-div").attr("data-client", clientId);

    updateModuleSelector(clientId);

    let currentModule = $("#module-select").val() || "cars";
    loadModule(currentModule, "list");
  });
}

function authenticateClient(clientId, callback = null) {
  localStorage.setItem("selectedClient", clientId);

  $.ajax({
    url: "auth.php",
    method: "POST",
    contentType: "application/json",
    data: JSON.stringify({ client: clientId }),
    success: function (response) {
      if (response.success) {
        console.log("Authentification réussie pour:", clientId);

        if (callback && typeof callback === "function") {
          callback();
        }
      } else {
        console.error("Erreur d'authentification:", response.error);
      }
    },
    error: function (xhr, status, error) {
      console.error("Erreur de connexion lors de l'authentification:", error);
    },
  });
}

function changeModule(moduleName) {
  $(".dynamic-div").attr("data-module", moduleName);

  loadModule(moduleName, "list");
}

function updateModuleSelector(clientId) {
  if (clientId === "clientb") {
    $(".module-selector").show();
    $('#module-select option[value="garage"]').show();
  } else {
    $(".module-selector").hide();
    $('#module-select option[value="garage"]').hide();
    $("#module-select").val("cars");
  }
}

function loadModule(module, script, additionalParams = {}) {
  let params = {
    module: module,
    script: script,
    ...additionalParams,
  };

  $(".dynamic-div").html('<div class="loading">Chargement en cours...</div>');

  $.ajax({
    url: "ajax.php",
    method: "GET",
    data: params,
    dataType: "json",
    success: function (response) {
      if (response.success) {
        $(".dynamic-div").html(response.content);

        $(".dynamic-div").attr("data-module", module);
        $(".dynamic-div").attr("data-script", script);

        addDynamicEventHandlers();
      } else {
        $(".dynamic-div").html(
          '<div class="error">Erreur lors du chargement</div>'
        );
      }
    },
    error: function (xhr) {
      if (xhr.status === 401) {
        let currentClient = localStorage.getItem("selectedClient");
        if (currentClient) {
          authenticateClient(currentClient);
          setTimeout(() => loadModule(module, script, additionalParams), 1000);
        } else {
          $(".dynamic-div").html(
            '<div class="error">Session expirée. Veuillez recharger la page.</div>'
          );
        }
      } else {
        $(".dynamic-div").html('<div class="error">Erreur de connexion</div>');
      }
    },
  });
}

function addDynamicEventHandlers() {
  console.log("addDynamicEventHandlers() called");

  $(".cars-table tbody tr")
    .off("click")
    .on("click", function () {
      let carId = $(this).data("car-id");
      console.log("carId =", carId, "Element:", this);
      if (carId) {
        loadModule("cars", "edit", { car_id: carId });
      } else {
        console.warn("Pas de voiture trouvé pour la ligne cliquée");
      }
    });

  $(".garages-table tbody tr")
    .off("click")
    .on("click", function () {
      let garageId = $(this).data("garage-id");
      console.log("garageId =", garageId, "Element:", this);
      if (garageId) {
        loadModule("garage", "edit", { garage_id: garageId });
      } else {
        console.warn("garage id manquant");
      }
    });

  $(".cars-table tbody tr, .garages-table tbody tr").css("cursor", "pointer");
  console.log("Event handlers attached and cursors set to pointer");
}
