var page = 1;
const ARTICLESPARPAGE = 4;

// Repartiteur d'actions:

var actionsVuesIndex = (action, reponse) => {

	switch(action){
		case "afficherCountries" :
            console.log(reponse);
			afficherTableauCountries(page, reponse.listeCountries)
		break;
        case "carrouselPrecedent":
            afficherPagePrecedente(reponse.listeArticles);
        break;
        case "carrouselSuivant":
            afficherPageSuivante(reponse.listeArticles);
        break;
        case "enregistrerMembre" :
            alert(reponse);  
        break;   
	}
}

function afficherTableauCountries(page, listeCountries) {
    var contenu = $('#vueCountries');
    contenu.empty();
    var tab = '<table id="tableauCountries" class="table table-striped table-hover">';
    tab += '<thead>';
    tab += '<tr>';
    tab += '<th scope="col">Country ID</th>';
    tab += '<th scope="col">Name</th>';
    tab += '<th scope="col">Capital</th>';
    tab += '<th scope="col">Region</th>';
    tab += '</tr>';
    tab += '</thead>';
    tab += '<tbody>';

    listeCountries.forEach(function (country) {
        tab += remplirTableauCountry(country);
    });

    tab += '</tbody>';
    tab += '</table>';

    contenu.append(tab);
}

function remplirTableauCountry(country){
    var ligne = '<tr>';
    ligne += '<th scope="row">' + country.idCountry + '</th>';
    ligne += '<td>' + country.name + '</td>';
    ligne += '<td>' + country.capital + '</td>';
    ligne += '<td>' + country.region + '</td>';
    ligne += '</tr>';

    return ligne;
}

function afficherPageSuivante(listeArticles) {
    if (page < Math.ceil(listeArticles.length / ARTICLESPARPAGE)) {
        page++;
        afficherArticles(page, listeArticles);
    }
}

function afficherPagePrecedente(listeArticles) {
    if (page > 1) {
        page--;
        afficherArticles(page, listeArticles);
    }
}