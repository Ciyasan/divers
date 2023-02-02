// Fonction pour fermer la fenêtre modale

function fermer() {
  // Suppression de la fenêtre modale
  document.getElementById("divchance").remove();
  document.querySelector("style[title='chance_css']").remove();
}

// Fonction pour le jeu

function jouer() {
  let essai = document.getElementById("numero").value;
  let numeroChance = document.getElementById("vrai_numero").value;
  let selection = document.getElementById("divchance");

  if (essai == numeroChance) {
    // Le jeu est gagné
    selection.innerHTML =
      "<p>C’est votre jour de chance !</p><button class='btn' onclick='fermer()'>Fermer</button>";
  } else {
    // Le jeu est perdu
    selection.innerHTML =
      "<p>Dommage, la chance n’était pas loin...</p><button class='btn' onclick='fermer()'>Fermer</button>";
  }
}
