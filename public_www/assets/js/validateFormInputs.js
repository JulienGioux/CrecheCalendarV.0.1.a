
// Fonction updateHelperInput()
// vérifie la validité des champs et
// met à jour l'affichage des helpers
// en fonction de leur statut.
// A appeler dans un EventListener sur un élément de type input
// quand la fonction est appelé avec un evenListener sur un input
// this fait référence à l'élément input
function updateHelperInput() {

  // On réinitialise le message d'erreur
  this.setCustomValidity("");
  // récupère le helper dans le parent
  let helper = this.parentNode.getElementsByClassName('form-helper');
  // si au moins 1 helper existe dans le parent du input
  if (helper.length > 0) {
    // On ne considère que le premier helper retourné et on lui attribu une class pour modifier l'apparence du texte 
    helper[0].classList.add('txt-dark-2');
    // On vérifie que les contrôle javascript/html
    // sur l'input sont ok
    if (this.reportValidity()) { 
      // On met à jour l'affichage avec des classes
      // et on insert un message indiquant la validation
      helper[0].innerText = 'Format valide \u2714';
      helper[0].classList.remove('txt-red');
      helper[0].classList.add('txt-green');
      // Vérifie et traite le cas des input optionnels
      // pour éviter un message de validation quand
      // l'input est vide.
      if (!this.hasAttribute('required') && this.value == '') {
        helper[0].innerText = 'Entrée optionnelle';
        helper[0].classList.remove('txt-red');
        helper[0].classList.remove('txt-green');
      }
    // Affiche le message d'erreur et met à jour
    // l'affichage pour les cas non valides
    } else {
      helper[0].innerText = this.validationMessage;
      helper[0].classList.remove('txt-green');
      helper[0].classList.add('txt-red');
    }
  }
};


// initialise les inputs au chargement de la page et actualise l'affichage
// en fonction des réponses du serveur en vérifiant la class du helper
let formControl = document.getElementsByClassName('form-control');
let msg;
let helper;
for (var i = 0; i < formControl.length; i++) {
    helper = formControl[i].parentNode.getElementsByClassName('form-helper');     
    if (helper.length > 0) {
      if (helper[0].classList.contains('txt-red')) {
          msg = helper[0].innerText;
          formControl[i].setCustomValidity(msg);
      } else {
        msg = formControl[i].validationMessage;
        helper[0].innerText = msg;
      };
      if (formControl[i].validationMessage == '' && formControl[i].hasAttribute('required')) {
        helper[0].innerText = 'Format valide \u2714';
        helper[0].classList.remove('txt-red');
        helper[0].classList.add('txt-green');
        helper[0].classList.add('txt-dark-2');
      };
      if (!formControl[i].hasAttribute('required') && formControl[i].value == '') {
        helper[0].innerText = '(Facultatif)';
        helper[0].classList.remove('txt-red');
        helper[0].classList.remove('txt-green');
      };

      //ajoute évènement 'oninput' sur chaque champs à vérifier
      // et appel la fonction updateHelperInput
      formControl[i].addEventListener('input', updateHelperInput, false);
    };
}
