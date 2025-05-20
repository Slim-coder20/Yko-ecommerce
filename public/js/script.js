// JS 
// Affiche les messages flash pendant 3 secondes avant de les faire disparaître//

    document.addEventListener('DOMContentLoaded', function () {
        const flashMessages = document.querySelectorAll('.flash-message');

        flashMessages.forEach(function (message) {
            setTimeout(function () {
                message.style.transition = "opacity 0.5s ease-out";
                message.style.opacity = '0';

                // Supprime l'élément après le fondu
                setTimeout(function () {
                    message.remove();
                }, 500);
            }, 3000); // Disparaît après 3 secondes
        });
    });
