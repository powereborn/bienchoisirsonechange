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
              $nb = $selectionPrepa->rowCount();
              
              if(!empty($nb))
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
                    $message .= 'http://bienchoisirsonechange.fr/member/confirm/login/' . $login . '/key/' . $security_confirmation . '\n\n';
                    $message .= 'Si vous n\'êtes pas l\'auteur de cette demande, vous pouvez annuler cette demande avec le lien ci-dessous\n';
                    $message .= 'http://bienchoisirsonechange.fr/member/cancel/login/' . $login . '/key/' . $security_confirmation . '\n\n';
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
    
    function confirmSubscribe()
    {
        global $_URL;
        
        $result = array();
        $result['error'] = array();
        
        if(!isset($_URL['login']) || !isset($_URL['key']))
        {
            $result['error']['confirm'] = "Il manque des informations pour confirmer votre compte.";
        }

        if(empty($result['error']))
        {
            $login = $_URL['login'];
            $key = $_URL['key'];

            $selectionPrepa = $this->connection->prepare('SELECT login_utc FROM members WHERE login_utc = :login AND security_confirmation = :key AND is_activated = 0');
            try 
            {
                // On envois la requète
                $selectionPrepa->execute(array('login' => $login,
                                               'key' => $key));

                $nb = $selectionPrepa->rowCount();
                
                if ($nb == 1) 
                {
                    
                    $selectionPrepa = $this->connection->prepare('UPDATE members SET is_activated = 1 WHERE login_utc = :login AND security_confirmation = :key AND is_activated = 0');
                    try 
                    {
                        // On envois la requète
                        $selectionPrepa->execute(array('login' => $login,
                                                       'key' => $key));
                        
                        $nb = $selectionPrepa->rowCount();
                        
                        if($nb == 1)
                        {
                            $result['ok']['confirm'] = "Votre compte viens d'être activé, vous pouvez maintenant vous connecter";
                        }
                        else
                        {
                            $result['error']['confirm'] = "Echec lors de l'activation de votre compte, veuillez réessayer.";
                        }
                    } catch (Exception $e) {
                        echo 'Erreur de requète : ', $e->getMessage();
                        die();
                    }
                }
                else
                {
                    $result['error']['confirm'] = "Votre compte ne peut pas être activé, vérifiez que les informations soient correctes ou que votre compte ne soit pas déjà activé";
                }
            } 
            catch (Exception $e) 
            {
                echo 'Erreur de requète : ', $e->getMessage();
                die();
            }
        }
        
        return $result;
    }
    
    function cancelSubscribe()
    {
        global $_URL;
        
        $result = array();
        $result['error'] = array();
        
        if(!isset($_URL['login']) || !isset($_URL['key']))
        {
            $result['error']['confirm'] = "Il manque des informations pour annuler l'activation de ce compte.";
        }

        if(empty($result['error']))
        {
            $login = $_URL['login'];
            $key = $_URL['key'];

            $selectionPrepa = $this->connection->prepare('SELECT login_utc FROM members WHERE login_utc = :login AND security_confirmation = :key AND is_activated = 0');
            try 
            {
                // On envois la requète
                $selectionPrepa->execute(array('login' => $login,
                                               'key' => $key));

                $nb = $selectionPrepa->rowCount();
                
                if ($nb == 1) 
                {
                    
                    $selectionPrepa = $this->connection->prepare('DELETE FROM members WHERE login_utc = :login AND security_confirmation = :key AND is_activated = 0');
                    try 
                    {
                        // On envois la requète
                        $selectionPrepa->execute(array('login' => $login,
                                                       'key' => $key));
                        
                        $nb = $selectionPrepa->rowCount();
                        
                        if($nb == 1)
                        {
                            $result['ok']['confirm'] = "L'activation de votre compte viens d'être annulée";
                        }
                        else
                        {
                            $result['error']['confirm'] = "Echec lors de l'annulation l'activation de votre compte, veuillez réessayer.";
                        }
                    } catch (Exception $e) {
                        echo 'Erreur de requète : ', $e->getMessage();
                        die();
                    }
                }
                else
                {
                    $result['error']['confirm'] = "L'activation de votre compte ne peut pas être annulée, vérifiez que les informations soient correctes ou que votre compte ne soit pas déjà activé";
                }
            } 
            catch (Exception $e) 
            {
                echo 'Erreur de requète : ', $e->getMessage();
                die();
            }
        }
        
        return $result;
    }
    
    function connexion()
    {
        $result = array();
        $result['error'] = array();
        
        if(!isset($_SESSION['login']))
        {
            
            if(!isset($_POST['login']) || empty($_POST['login']))
            {
                $result['error']['login'] = "Veuillez saisir un login.";
            }
            if(!isset($_POST['password']) || empty($_POST['password']))
            {
                $result['error']['password'] = "Veuillez saisir un password.";
            }
            
            if(empty($result['error']))
            {
                $login = $_POST['login'];
                $password = sha1($_POST['password']);
                
                $selectionPrepa = $this->connection->prepare('SELECT login_utc, is_activated FROM members WHERE login_utc = :login AND password = :password');
                try 
                {
                    // On envois la requète
                    $selectionPrepa->execute(array('login' => $login,
                                                   'password' => $password));

                    $data = $selectionPrepa->fetch();
                    $nb = $selectionPrepa->rowCount();

                    if($nb == 1 && $data['is_activated'] == 1)
                    {
                        $_SESSION['login'] = $data['login_utc'];
                    }
                    else if ($nb == 1 && $data['is_activated'] == 0) 
                    {
                        $result['error']['connexion'] = "Votre compte n'est pas encore activé.";
                    } 
                    else if($nb == 0)
                    {
                        $result['error']['connexion'] = "Mauvais identifiants, veuillez réessayer.";
                    }
                } 
                catch (Exception $e) 
                {
                    echo 'Erreur de requète : ', $e->getMessage();
                    die();
                }
            }
        }
        
        return $result;
    }
    
    function disconnexion()
    {
        if(isset($_SESSION['login']))
        {
            unset($_SESSION['login']);
            session_destroy();
        }
    }
}