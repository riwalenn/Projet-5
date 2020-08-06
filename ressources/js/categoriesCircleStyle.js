//récupérer les paragraphes ayant une id commençant par "variableAPasser" (utilisation d'une regex)
function getElementsByRegexId(regexParam, tagParam) {
    tagParam = (tagParam === undefined) ? '*' : tagParam;
    var elementsTable = new Array();
    for (let i = 0; i < document.getElementsByTagName(tagParam).length; i++) {
        if (document.getElementsByTagName(tagParam)[i].id && document.getElementsByTagName(tagParam)[i].id.match(regexParam)) {
            elementsTable.push(document.getElementsByTagName(tagParam)[i]);
        }
    }
    return elementsTable;
}

//ajoute la couleur dans le html via une classe !
//ATTENTION: ceci oblige à modifier le fichier css à chaque nouvelle catégorie.
function getClassCategoryColor(category) {
    switch (category) {
        case 'conception UML':
            classe = "umlCategory";
            break;

        case 'javascript':
            classe = "jsCategory";
            break;

        case 'php':
            classe = "phpCategory";
            break;

        case 'css':
            classe = "cssCategory";
            break;

        case 'html':
            classe = "htmlCategory";
            break;

        case 'bootstrap':
            classe = "bootstrapCategory";
            break;

        case 'wordpress':
            classe = "wordpressCategory";
            break;

        case 'python':
            classe = "pythonCategory";
            break;

        case 'vue':
            classe = "vueCategory";
            break;

        case 'typeScript':
            classe = "typeScriptCategory";
            break;

        case 'java':
            classe = "javaCategory";
            break;

        case 'swift':
            classe = "swiftCategory";
            break;

        case 'c':
            classe = "cCategory";
            break;

        default:
            classe = "green";
            break;
    }
    return classe;
}

//tableau DOM des paragraphes commençant par l'id "variableAPasser"
let paragraphOfCategoriesArray = getElementsByRegexId(/^variableAPasser/, "p");
let nbElem = getElementsByRegexId(/^variableAPasser/, "p").length;
for (let i = 0; i < nbElem; i++) {
    //Convertit les paragraphes de catégories
    let paragraphOfCategories = Object.values(paragraphOfCategoriesArray)[i];

    //Récupère la valeur contenu dans les paragraphes
    let categories = paragraphOfCategories.textContent;

    //créer un tableau des catégories
    let categoriesArray = categories.split('-').map(function (item) {
        return item.trim();
    });


    //nouvelle boucle pour ajouter le sticker
    for (let j = 0; j < categoriesArray.length; j++) {
        //création du sticker avec récupération de la couleur correspondante en classe
        let categoryNode = document.createElement('i');
        categoryNode.setAttribute("class", "fas fa-circle portfolio " + getClassCategoryColor(categoriesArray[j]));
        c = paragraphOfCategories.parentNode;
        c.append(categoryNode);

        //récupération et intégration des catégories
        let spanNode = document.createElement('p');
        spanNode.textContent = categoriesArray[j];
        c.append(spanNode);
    }

    paragraphOfCategories.remove();
}
