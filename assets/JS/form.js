function get(id) {
    return document.getElementById(id);
}

function sauvegarderDansSessionStorage(formID) {
    // Récupérer le formulaire
    let form = document.getElementById(formID);

    // Ajouter un événement de soumission au formulaire
    form.addEventListener("submit", function (event) {
        // Empêcher le comportement par défaut du formulaire (rechargement de la page)
        event.preventDefault();

        // Sérialiser les données du formulaire en JSON et les sauvegarder dans le sessionStorage
        let formData = {};
        let inputs = this.getElementsByTagName("input");
        for (let i = 0; i < inputs.length; i++) {
            if (inputs[i].type === 'checkbox') {
                formData[inputs[i].name] = inputs[i].checked.toString(); // Stocker la valeur booléenne en tant que chaîne de caractères
            } else {
                formData[inputs[i].name] = inputs[i].value;
            }
        }
        let selects = this.getElementsByTagName("select");
        for (let j = 0; j < selects.length; j++) {
            formData[selects[j].name] = selects[j].value;
        }

        // Sauvegarder les données dans le sessionStorage
        sessionStorage.setItem(formID + "-formData", JSON.stringify(formData));

        // Soumettre le formulaire
        this.submit();
    });

    // Récupérer les données sauvegardées depuis le sessionStorage
    let savedFormData = sessionStorage.getItem(formID + "-formData");

    // Si des données sont présentes dans le sessionStorage, les utiliser
    if (savedFormData) {
        savedFormData = JSON.parse(savedFormData);
        // Parcourir les champs du formulaire pour mettre à jour leurs valeurs
        for (let field in savedFormData) {
            if (savedFormData.hasOwnProperty(field)) {
                let element = form.elements[field];
                if (element) {
                    if (element.type === 'checkbox') {
                        // Si c'est une case à cocher, vérifier si elle doit être cochée
                        if (savedFormData[field] === 'true') {
                            element.checked = true;
                        } else {
                            element.checked = false;
                        }
                    } else {
                        // Sinon, mettre à jour la valeur normalement
                        element.value = savedFormData[field];
                    }
                }
            }
        }
    }
}

// Appeler la fonction pour chaque formulaire que vous souhaitez traiter
sauvegarderDansSessionStorage("filter_sortie");

function reAfficherDonneesSauvegardees(formID) {
    // Récupérer le formulaire
    let form = document.getElementById(formID);

    // Récupérer les données sauvegardées depuis le sessionStorage
    let savedFormData = sessionStorage.getItem(formID + "-formData");

    // Si des données sont présentes dans le sessionStorage, les utiliser
    if (savedFormData) {
        savedFormData = JSON.parse(savedFormData);
        // Parcourir les champs du formulaire pour mettre à jour leurs valeurs
        for (let field in savedFormData) {
            if (savedFormData.hasOwnProperty(field)) {
                let element = form.elements[field];
                if (element) {
                    if (element.type === 'checkbox') {
                        // Si c'est une case à cocher, vérifier si elle doit être cochée
                        if (savedFormData[field] === 'true') {
                            element.checked = true;
                        } else {
                            element.checked = false;
                        }
                    } else {
                        // Sinon, mettre à jour la valeur normalement
                        element.value = savedFormData[field];
                    }
                }
            }
        }
    }
}

// Appeler la fonction pour chaque formulaire que vous souhaitez re-afficher les données sauvegardées
reAfficherDonneesSauvegardees("filter_sortie");

let currentPage = window.location.href;
let previousPage = document.referrer;

if (currentPage !== previousPage) {
        loader();
    document.addEventListener("DOMContentLoaded", function () {
        let urlParams = new URLSearchParams(window.location.search);
        let submitted = urlParams.get('submitted');
        if (!submitted) {
            document.getElementById("filter_sortie").submit();
        }
    });
} else {
}

function loader() {
    // Afficher le loader lorsque la page commence à se charger
    document.addEventListener("DOMContentLoaded", function () {
        let loader = document.querySelector('.loader');
        loader.style.display = 'block'; // Afficher le loader
    });

    // Masquer le loader lorsque la page est complètement chargée
    window.addEventListener('load', function () {
        let loader = document.querySelector('.loader');
        loader.style.display = 'none'; // Masquer le loader
    });
}

function exclusiveFilters(registered) {
    if(registered) {
        get("filter_sortie_checkboxNotRegistered").checked = false;
    } else {
        get("filter_sortie_checkboxRegistered").checked = false;
    }
}