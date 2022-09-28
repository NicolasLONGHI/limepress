<?php
    /**
     * @package LimePress
     * @version 1.0.0
     */
    /*
    Plugin Name: LimePress
    Plugin URI: https://groupe9.btssiolerebours.org/wordpress/
    Description: LimePress permet de récupérer les profils de LimeSurvey.
    Author: Maxime DUBOSCQ, Nicolas LONGHI
    Version: 1.0.0
    */
    $nomBDD;
    $login;
    $mdp;
    include('fonctions.php');


/*** Utilisation des méthodes ***/


    add_shortcode('limepress','reponse'); //Ajout du shortcode
    add_action('admin_menu', 'ajoutMenu'); //Ajout du menu


/*** Fonctions ***/


    function ajoutMenu () {
        add_menu_page('Forms', 'LimePress', 'manage_options','josh-admin-menu', 'menuConfig', 'dashicons-admin-generic', 1);
    }

    function menuConfig() { //Contenu de la page 
        ?>
        <h1>LimePress :</h1>
        <br/><br/><br/>
        Pour utiliser LimePress, vous devez ajouter sur l'une de vos pages un code court. Dans celui-ci, vous devez inscrire entre crochet LimePress.<br/>
        Le module va alors ajouter automatiquement les réponses des utilisateurs de tous les questionnaires.
        <?php
    }

    function reponse() { //Affiche les réponses lorsque le shortcode est utilisé
        $questionnaires = recupereLesQuestionnaires();
        foreach ($questionnaires as $questionnaire) {
            echo '<b>Questionnaire : ' . $questionnaire['sid'] . '</b><br/>';
            $infos = recupereInfosQuestionnaire($questionnaire['sid']);
            $colonnes = recupereColonnes($questionnaire['sid']);
            $nbReponse = 1;
            foreach($colonnes as $colonne) {
                foreach ($infos as $info) {
                    if ($colonne["Field"] == "id" or $colonne["Field"] == "token" or $colonne["Field"] == "submitdate" or $colonne["Field"] == "lastpage" or $colonne["Field"] == "startlanguage"  or $colonne["Field"] == "seed") {
                        
                    }
                    else {
                        echo '&emsp;•&nbsp;' . $info[$colonne["Field"]] . '&emsp;&emsp;&emsp; → Personne ' . $info['id'] . '<br/>';
                    }
                }
            }
            echo '<br/>';
            
        }
    }

?>