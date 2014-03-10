<?php

require_once 'Model/Model.php';

class ModelMember extends Model
{
    function subscribe() 
    {
        $result = array();
        $result['error'] = array();
        
        $login = $_POST['login'];
        $pseudonyme = $_POST['pseudonyme'];
        $password = $_POST['password'];
        $password_confirmed = $_POST['password_confirmed'];
        
        if(empty($login))
        {
            $result['error']['login'] = "Veuillez saisir un login";
        }
        else
        {
            $selectionPrepa = $this->connection->prepare('SELECT login_utc FROM members WHERE login_utc = :login');
            try {
              // On envois la requète
              $selectionPrepa->execute(array('login'=>$login));

              $nb = count($selectionPrepa);
              
              if(empty($nb))
              {
                  $result['error']['login'] = "Ce login est déjà utilisé";
              }

            } catch( Exception $e ){
              echo 'Erreur de requète : ', $e->getMessage();
              die();
            }  
        }
        
        if(empty($pseudonyme))
        {
            $result['error']['pseudonyme'] = "Veuillez saisir un pseunonyme";
        }
         else
        {
            $selectionPrepa = $this->connection->prepare('SELECT pseudo_member FROM members WHERE pseudo_member = :pseudonyme');
            try {
              // On envois la requète
              $selectionPrepa->execute(array('pseudonyme'=>$pseudonyme));

              //$nb = $selectionPrepa->fetch(PDO::FETCH_OBJ)->fetchColumn();
              $nb = count($selectionPrepa);
              
              if(empty($nb))
              {
                  $result['error']['login'] = "Ce pseudonyme est déjà utilisé";
              }

            } catch( Exception $e ){
              echo 'Erreur de requète : ', $e->getMessage();
              die();
            }  
        }
        
        if(empty($password))
        {
            $result['error']['password'] = "Veuillez saisir un mot de passe";
        }
        
        if(empty($password_confirmed))
        {
            $result['error']['password_confirmed'] = "Veuillez confirmer le mot de passe";
        }
        else
        {
             if($password != $password_confirmed)
             {
                 $result['error']['password_confirmed'] = "Le mot de passe n'est pas identique";
             }
        }
        
        if(count($result['error']) == 0)
        {
           $insert = $this->connection->prepare('INSERT INTO members VALUES(:pseudonyme, :login, :password, default, default, default, :security_confirmation, default)');
            try {
                
              $security_confirmation = sha1($login.uniqid());
              // On envois la requète
              $success = $insert->execute(array(
                'pseudonyme'=>$pseudonyme,
                'login'=>$login,
                'password'=>sha1($password),
                'security_confirmation'=>$security_confirmation
              ));

              if( $success ) {
                echo "Enregistrement réussi";
                    $to      = $login.'@etu.utc.fr';
                    $subject = 'Bienchoisirsonechange';
                    $message = 'Bonjour utcéen !\n';
                    $message .= 'Dans quelques instants, tu pourras désormais poster des commentaires sur bienchoisirsonechange.fr\n';
                    $message .= 'Pour ce faire, il te suffit de confirmer ton inscription en cliquant sur le lien ci-dessous :\n';
                    $message .= 'http://bienchoisirsonechange.fr/member/confirm/pseudo/' . $pseudonyme . '/key/' . $security_confirmation . '\n\n';
                    $message .= 'Si vous n\'êtes pas l\'auteur de cette demande, vous pouvez annuler cette demande avec le lien ci-dessous\n';
                    $message .= 'http://bienchoisirsonechange.fr/member/cancel/pseudo/' . $pseudonyme . '/key/' . $security_confirmation . '\n\n';
                    $headers = 'From: contact@bienchoisirsonechange.fr' . "\r\n" .
                    'Reply-To: contact@bienchoisirsonechange.fr' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

                    mail($to, $subject, $message, $headers);
              }  
            } catch( Exception $e ){
              $result['error']['request'] = 'Erreur de requète : ' . $e->getMessage();
            }
        }
        
        return $result;
    }
}