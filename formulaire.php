<main class="main-contact">
      <h2>Formulaire de contact</h2>
      <form method="post">
        <label for="prenom">Votre prénom* : </label> <br />
        <input type="text" id="prenom" name="prenom" required /><br />
        <label for="nom">Votre nom* :</label><br />
        <input type="text" id="nom" name="nom" required /><br />
        <label for="tel">Votre numéro de téléphone :</label><br />
        <input type="tel" name="tel" id="tel" /><br />
        <label for="entreprise">Le nom de votre entreprise :</label><br>
        <input type="text" id="entreprise" name="entreprise"><br>
        <label for="mail">Votre adresse email* :</label><br />
        <input type="email" name="mail" id="mail" required /><br />      
        <label for="message">Votre message :</label><br />
        <textarea name="message" id="message" cols="50" rows="25"></textarea
        ><br />
        <button type="submit" class="bouton-submit">Envoyer</button>
        <button type="reset" class="bouton-reset">Effacer</button>
      </form>
      <?php 
      if (isset($_POST['message'])) {
          $message = "Ce message vous a été envoyé à partir du formulaire de contact du site entreprise par " . $_POST["prenom"] . " " . $_POST["nom"] . ", travaillant pour l'entreprise " . $_POST["entreprise"] . ". Son numéro de téléphone est " . $_POST["tel"] . " et son adresse mail est " . $_POST ["mail"] ."\r\n" . $_POST["message"];

          $retour = mail ("adresse@mail.com", "contact  distrisign", $message, "From:contact@entreprise.fr" . "\r\n" . "Reply-to:" . $_POST["mail"]);

          if($retour) {
            echo "<p>Votre message a bien été envoyé</p>";
          }
      }
      ?>