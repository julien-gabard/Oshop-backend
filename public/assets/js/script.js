var app = {
    init: function() {
        // init est exécuté au moment où le DOM est finir dêtre chargé
        // On souhaite intercepter l'envoi du formulaire de sélection des catégories mises en avant
        document.getElementById("homeOrderForm").addEventListener("submit", app.handleSubmitHomeOrder);
    },
    handleSubmitHomeOrder: function(event) {
        // On souhaite vérifier les données dans les SELECT
        // On peut créer une variable qui contient ces élément du DOM
        var selectElements = document.querySelectorAll("select");

        // Tentons un équivalent du foreach en JS, le .forEach()
        selectElements.forEach(function (singleSelectElement, index) {
            var idToTest = singleSelectElement.value;

            // On vérifie que le champs a bien une catégorie de sélectionné
            if (idToTest == "") {
                alert('Veuillez sélectionner une catégorie dans tous les champs');
                event.preventDefault();
            } else {
                console.log('SELECT ok');
            }

            // On vérifie que ce champs n'a pas de doublon parmi les autres SELECT
            selectElements.forEach(function(duplicateToTest, duplicateIndex) {
                // On compare la variable idToTest avec la value dans duplicateToTest
                if (idToTest == duplicateToTest.value && index != duplicateIndex) {
                    alert('Veuillez sélectionner une catégorie une seule fois');
                    event.preventDefault();
                } else {
                    console.log('SELECT sans doublon');
                }
            });

        });
    }
};

document.addEventListener("DOMContentLoaded", app.init); 