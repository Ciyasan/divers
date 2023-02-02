<?php

/**
 * Plugin Name: numero_chance
 * Description: Choisir un numéro entre 1 et 9 pour tester sa chance.
 * Author: Coralie Dubreuil
 * Version: 0.1
 */


// Enregistrement des fonctions sur les hooks 
 
register_activation_hook(__FILE__, 'chance_enable');

register_deactivation_hook(__FILE__, 'chance_disable');

register_uninstall_hook(__FILE__, 'chance_uninstall');

// Fonction d'activation du plugin
 
function chance_enable()
{   
  add_option('numero_chance', 8);
}

// Fonction de désactivation du plugin
 
function chance_disable(){}

// Fonction de désintallation du plugin
 
function chance_uninstall()
{
  //  Suppression inconditionnelle de la 'WP option' de la base de données
   
  delete_option('numero_chance');
}

// Check admin mode
if (is_admin()) {

  //Enregistrement du callback sur le hook 'ajout du menu d'admin'
  
  add_action('admin_menu', 'chance_add_menu');

  // Fonction de création de menu du plugin
   
  function chance_add_menu()
  {
    // Ajout d'une page d'admin dans le dashboard
    
    add_menu_page(
      'Configuration du jeu de la chance', // Nom de la page
      'Jeu de la chance', // Nom du menu
      'edit_plugins', // WP capabilites
      'chance_admin',  // Menu URL slug
      'chance_show_panel', // Callback de gestion de la page      
    );
  }

  // Fonction d'affichage de la page d'admin du plugin
   
  function chance_show_panel()
  {
    // Flag de conexte de mise à jour
    $updated = false;

    // Controller de la page d'admin
     
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {

      // Vérification du nonce
      
      if (isset($_POST['jeton']) && wp_verify_nonce($_POST['jeton'], 'chance_admin_nonce')) {

        // Vérification du la présence de l'attribut de la requête
        if (isset($_POST['numero']) && !empty($_POST['numero'])) {

          // Récupération du message d'avertissement
          $numero = $_POST['numero'];

          // Mise à jour du message d'avertissement dans la table de données
           
          $updated = update_option('numero_chance', $numero);
        }
      }
    } else {

      // Récupération du message d'avertissement depuis la table de données
       
      $warning = get_option('numero_chance');
    }

    // Formulaire HTML 
    echo '<div>
          <h1>Configuration du jeu de la Chance</h1>
          <form action="' . menu_page_url('chance_admin', false) . '" method="post">
          <label for="numero">Choississez votre numéro chance :</label>
          <select name="numero" id="numero">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
          </select>
              <input type="submit" value="Enregistrer" name="submit">'
      . wp_nonce_field('chance_admin_nonce', 'jeton') .
      '</form>          
      </div>';

    if ($updated) {
      echo '<p>Le nouveau numéro chance a bien été enregistré</p>';
    }
  }
} else {

 // Enregistrement d'une fonction sur le hook 'balise HTML ouvrante body'
     
 add_action('wp_body_open', 'chance_print_modal');
 
 
 // Fonction d'affichage de la fenêtre modale
 
 function chance_print_modal()
 {
   // Limitation de la fenêtre modale à la homepage
      
      if (is_front_page()){
        
        //Récupération du numéro chance depuis la table de données
      
        $numero = get_option('numero_chance');

      // Code HTML de la fenêtre modal
       
      echo '
      
        <div id="divchance">
            <input id="vrai_numero" value="' . $numero . '"></input>
              <label for="choix-numero">Choisissez un chiffre :</label>
              <select name="numero" id="numero">
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
              </select>
            <div>
              <button class="btn" onclick="jouer()">Jouer</button>
              <button class="btn" onclick="fermer()">Ne pas jouer</button>
            </div>
          </div>
        ';
      }
  }

    //Enregistrement d'une fonction sur le hook 'balise HTML footer'   
    
    add_action('wp_footer', 'chance_footer');

    // Fonction de désintallation du plugin
     
    function chance_footer()
    {
      // Injection du JS en externe dans le footer car il est prioritaire sur tout autre chargement (bloquant)
      echo '<script src="' . plugin_dir_url(__FILE__) . 'chance.js"></script>';

      // Injection du style en CSS interne
      echo '<style title="chance_css">
        body {
          overflow: hidden;
        }
        #divchance {
          position: absolute;
          left: 50%;
          top: 50%;
          transform: translate(-50%, -50%);
          width: auto;
          display: inline-flex;
          flex-direction: column;
          align-items: center;
          padding: 1.6rem 3rem;
          border: 3px solid black;
          border-radius: 5px;
          background: white;
          box-shadow: 8px 8px 0 rgba(0, 0, 0, 0.2);
        }       
        #chance.btn {
          color:inherit;
            font-family:inherit;
          font-size: inherit;
          background: white;
          padding: 0.3rem 3.4rem;
          border: 3px solid black;
          margin-right: 2.6rem;
          box-shadow: 0 0 0 black;
          transition: all 0.2s;
        } 
        #vrai_numero{
          display: none;
        }
      </style>';
    }
}

