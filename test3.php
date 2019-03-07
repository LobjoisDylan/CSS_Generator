<?php 

function modifie_la_variable_copie($maVariable)
{
    //Il ny as pas de &, on fera donc un copie de la variable que l'on passera en parametre !
    //une copie n'est pas la vrai variable, c'est une autre variable qui copie seulement son contenu
    $maVariable = 15;
}

function modifie_la_variable_par_reference(&$maVariable)
{
    //On a ajouter le &, on pointe donc directement sur la variable que lon passera en parametre
    //Aucune copie ne sera faite, on agira directement dessus
    $maVariable = 15;
}

$maVariable = 10;
modifie_la_variable_copie($maVariable);
//Apres lappel de la fonction, $maVariable est toujours egale à 10, elle n'a pas bougé

//en gros quand on declare la fonction : function modifie_la_variable_copie($maVariable)
                                        {
                                            //$maVariable = 15;
                                        } 
//C'est comme quand on fait $variable_une = 10;
//                          $variable_deux = 20;
//                          $variable_une = $variable_deux;

//$variable_une vaut maintenant 20, car on a copie la valeur de $variable_deux
//mais si on mondifie $variable_une on ne modifira pas $variable_deux, psk ce son deux variable differente
//il se passe la meme chose dans la fonction copie, quand on ne met pas de &

//Par contre si on fait
modifie_la_variable_par_reference($maVariable);
//$maVariable vaut maintenant 15, car on a modifier directement la vrai variable, sans faire de copie