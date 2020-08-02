//récupérer les paragraphes ayant une id commençant par "variableAPasser" (utilisation d'une regex)
function getElementsByRegexId(regexParam, tagParam) {
    tagParam = (tagParam === undefined) ? '*' : tagParam;
    var elementsTable = new Array();
    for(let i = 0; i<document.getElementsByTagName(tagParam).length; i++) {
        if(document.getElementsByTagName(tagParam)[i].id && document.getElementsByTagName(tagParam)[i].id.match(regexParam)) {
            elementsTable.push(document.getElementsByTagName(tagParam)[i]);
        }
    }
    return elementsTable;
}
//ajoute la couleur dans le html avec la balise "style"
//ATTENTION: ceci oblige à modifier le fichier js à chaque nouvelle catégorie.
function getCategoriesColors(category) {
    switch (category) {
        case 'conception UML':
            classe = "red";
            break;

        case 'javascript':
            classe = "#f1e05a";
            break;

        case 'php':
            classe = "#4F5D95";
            break;

        case 'css':
            classe = "#563d7c";
            break;

        case 'html':
            classe = "#e34c26";
            break;

        case 'bootstrap':
            classe = "#7952b3";
            break;

        case 'wordpress':
            classe = "#003c56";
            break;

        default:
            classe = "green";
            break;
    }
    return  classe;
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

        default:
            classe = "green";
            break;
    }
    return  classe;
}
//tableau DOM des paragraphes commençant par l'id "variableAPasser"
let paragraphOfCategoriesArray = getElementsByRegexId(/^variableAPasser/, "p");
for (let i = 0; i < getElementsByRegexId(/^variableAPasser/, "p").length; i++) {
    //Convertit les paragraphes de catégories
    let paragraphOfCategories = Object.values(paragraphOfCategoriesArray)[i];

    //Récupère la valeur contenu dans les paragraphes
    let categories = paragraphOfCategories.textContent;

    //créer un tableau des catégories
    let categoriesArray = categories.split('-').map(function (item) {
        return item.trim();
    });

    //nouvelle boucle pour ajouter le sticker
    for (let i = 0; i < categoriesArray.length; i++) {
        let styleBalise = "style=\"color:" + getCategoriesColors(categoriesArray[i]) + "\"";
        let sticker = '<i class=\"fas fa-circle "' + getClassCategoryColor(categoriesArray[i]) + '\" ' + styleBalise + '"></i>';
        var newCategoriesArray = sticker + " " + categoriesArray[i];
    }
    paragraphOfCategories.remove();
    let c = document.getElementsByClassName("categories");
    /*c.append(newCategoriesArray);
    categoriesArray.length--;*/
}
