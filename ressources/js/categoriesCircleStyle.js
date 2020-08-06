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

        case 'python':
            classe = "#3572A5";
            break;

        case 'vue':
            classe = "#2c3e50";
            break;

        case 'typeScript':
            classe = "#2b7489";
            break;

        case 'java':
            classe = "#b07219";
            break;

        case 'swift':
            classe = "#ffac45";
            break;

        case 'c':
            classe = "#178600";
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
    return  classe;
}
//tableau DOM des paragraphes commençant par l'id "variableAPasser"
let paragraphOfCategoriesArray = getElementsByRegexId(/^variableAPasser/, "p");
//console.log(paragraphOfCategoriesArray.length);
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
        //console.log(categoriesArray.length);
        /*
        //création du sticker avec une balise style
        let styleBalise = "style=\"color:" + getCategoriesColors(categoriesArray[i]) + "\"";
        let sticker = '<i class=\"fas fa-circle "' + getClassCategoryColor(categoriesArray[i]) + '\" ' + styleBalise + '></i>';
        */

        //création du sticker avec récupération de la couleur correspondante en classe
        let sticker = '<i class=\"fas fa-circle ' + getClassCategoryColor(categoriesArray[i]) + '\"></i>';
        var newCategoriesArray = sticker + " " + categoriesArray[i];

        //console.log(sticker);
        console.log(paragraphOfCategories);
        paragraphOfCategories.remove();
        let c = document.getElementsByClassName("categories");
        //console.log(newCategoriesArray);
        /*c.append(newCategoriesArray);*/
    }
}
