
// Modèle de requete AJAX:

let requeteAjaxIndex = (form) => {
    $.ajax({
        type: 'POST',
        url: 'routes.php',
        data: form,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: (reponse) => {
            actionsVuesIndex(form.get('action'), reponse);
        },
        error: function (xhr, status, error) {
            console.log(error);
            console.log(form.get('action'));
            alert('Erreur de requête : ' + status + ' - ' + error);
        }
    });
};

// Fonctions:

let remplirBd = () => {
    let form = new FormData();
    form.append('action', 'remplirBd');
    form.append('route', 'country');
    $.ajax({
        type: 'POST',
        url: 'routes.php',
        data: form,
        dataType: 'text',
        contentType: false,
        processData: false,
        success: (reponse) => {
        },
        error: function (xhr, status, error) {
            console.log(error);
            console.log(form.get('action'));
            alert('Erreur de requête : ' + status + ' - ' + error);
        }
    });
}

let afficherCountries = () => {
    let form = new FormData();
    form.append('action', 'afficherCountries');
    form.append('route', 'country');
    $.ajax({
        type: 'POST',
        url: 'routes.php',
        data: form,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: (reponse) => {
            actionsVuesIndex(form.get('action'), reponse);
        },
        error: function (xhr, status, error) {
            console.log(error);
            console.log(form.get('action'));
            alert('Erreur de requête : ' + status + ' - ' + error);
        }
    });
}

let pagePrecedente = () => {
    let form = new FormData();
    form.append('action', 'carrouselPrecedent');
    form.append('route', 'article');
    requeteAjaxIndex(form);
};

let pageSuivante = () => {
    let form = new FormData();
    form.append('action', 'carrouselSuivant');
    form.append('route', 'article');
    requeteAjaxIndex(form);
};