<?php

namespace Controler;

use DateTime;
use Model\UserModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class UserC
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? null;
            $mail = $_POST['mail'] ?? null;
            $password = $_POST['password'] ?? null;

            if ($username && $mail && $password) {
                $isAdmin = false; // Par défaut, l'utilisateur n'est pas un administrateur.
                $this->userModel->create($username, $mail, $isAdmin, $password);
                // Récupère l'utilisateur par email pour obtenir l'ID
                $user = $this->userModel->getUserByEmail($mail);
                if ($user) {
                    $userId = $user['id'];
                    // Génère un token de vérification
                    $verificationToken = bin2hex(random_bytes(16));
                    // Enregistre le token dans la base de données pour cet utilisateur
                    $this->userModel->saveVerificationToken($userId, $verificationToken);

                    // Envoie l'email de vérification
                    $this->sendVerificationEmail($mail, $verificationToken);

                    echo "Compte créé avec succès. Veuillez vérifier votre email pour activer votre compte.";
                    //header('Location: /accueil'); // Redirige vers la page d'accueil avec un message
                    //exit();
                } else {
                    echo "Erreur lors de la création du compte.";
                }
            } else {
                echo "Veuillez remplir tous les champs.";
            }
        } else {
            include 'View/register.php';
        }
    }

    public function verifyEmail($token)
    {
        $user = $this->userModel->getUserByToken($token);
        if ($user) {
            $this->userModel->markEmailAsVerified($user['id']);
            echo "Votre email a été vérifié avec succès.";
        } else {
            echo "Le lien de vérification est invalide ou expiré.";
        }
    }

    public function sendVerificationEmail($email, $verificationToken)
    {
        $mail = new PHPMailer(true);

        try {
            // Paramètres du serveur d'envoi
            $mail->isSMTP();
            $mail->Host = 'localhost'; // à remplacer
            $mail->SMTPAuth = false;
            // $mail->Username = ''; // À remplacer par nom d'utilisateur SMTP
            // $mail->Password = ''; // À remplacer par mot de passe SMTP
            $mail->SMTPSecure = false;
            //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 25;

            // Destinataires
            $mail->setFrom('a@changer.com', 'Mailer');
            $mail->addAddress($email);

            // Contenu de l'email
            $mail->isHTML(true);
            $mail->Subject = 'Vérifiez votre adresse email';
            $verificationLink = 'http://projetwebcnam/verify/' . $verificationToken;
            $mail->Body = 'Veuillez cliquer sur ce lien pour vérifier votre adresse email: <a href="' . $verificationLink . '">' . $verificationLink . '</a>';

            $mail->send();
            echo 'Le message de vérification a été envoyé';
        } catch (Exception $e) {
            echo "Le message n'a pas pu être envoyé. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function sendPasswordResetEmail($email)
    {

        $user = $this->userModel->getUserByEmail($email);
        if ($user) {
            $token = bin2hex(random_bytes(32));
            $this->userModel->savePasswordResetToken($email, $token);

            // Envoie l'email avec le token
            $this->sendResetEmail($email, $token);
        } else {
            echo "Le message n'a pas pu être envoyé";
        }
    }

    protected function sendResetEmail($email, $token)
    {
        $mail = new PHPMailer(true);
        try {
            // Paramètres du serveur d'envoi
            $mail->isSMTP();
            $mail->Host = 'localhost'; // à remplacer
            $mail->SMTPAuth = false;
            // $mail->Username = ''; // À remplacer par nom d'utilisateur SMTP
            // $mail->Password = ''; // À remplacer par mot de passe SMTP
            $mail->SMTPSecure = false;
            //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 25;

            // Destinataires
            $mail->setFrom('a@changer.com', 'Mailer');
            $mail->addAddress($email);

            // Contenu de l'email
            $mail->isHTML(true);
            $mail->Subject = 'Vérifiez votre adresse email';
            $resetLink = "http://projetwebcnam/resetPassword/" . $token;
            $mail->Body = 'Veuillez cliquer sur ce lien pour définir votre nouveau mot de passe: <a href="' . $resetLink . '">' . $resetLink . '</a>';

            $mail->send();
            echo 'Le message de vérification a été envoyé';
        } catch (Exception $e) {
            echo "Le message n'a pas pu être envoyé. Mailer Error: {$mail->ErrorInfo}";
        }
    }
    public function resetPassword($token, $newPassword)
    {
        $resetRecord = $this->userModel->getPasswordResetByToken($token);

        if ($resetRecord) {
            $currentTime = new DateTime();
            $expireTime = new DateTime($resetRecord['created_at']);
            $expireTime->modify('+1 hour');

            if($currentTime <= $expireTime){
                $this->userModel->updateUserPassword($resetRecord['email'], $newPassword);
                $this->userModel->invalidateResetToken($token);
                echo'Mot de passe mis à jour';
            } else{
                echo'Le token a expiré';
            }
        } else {
            echo "Token invalide";
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? null;
            $password = $_POST['password'] ?? null;

            if ($username && $password) {
                $user = $this->userModel->findByUsername($username);
                if ($user && password_verify($password, $user['password'])) {
                    // Ajoute une vérification pour voir si l'utilisateur est vérifié
                    if ($user['is_verified'] == 0) {
                        echo "Votre compte n'a pas été vérifié. Veuillez vérifier votre email.";
                        return; // Arrête l'exécution de la fonction ici
                    }
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['is_admin'] = $user['isAdmin'];

                    // Vérifier si l'utilisateur est un administrateur
                    if ($user['isAdmin']) {
                        // Redirige vers le back office pour les administrateurs
                        header('Location: /backoffice');
                    } else {
                        // Redirige vers la page d'accueil pour les utilisateurs
                        header('Location: /accueil');
                    }
                    exit(); // bonne pratique après un header
                } else {
                    echo "Identifiants incorrects.";
                }
            } else {
                echo "Veuillez remplir tous les champs.";
            }
        } else {
            include 'View/login.php';
        }
    }

    public function addUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? null;
            $mail = $_POST['mail'] ?? null;
            $isAdmin = isset($_POST['isAdmin']) ? 1 : 0;
            $password = $_POST['password'] ?? null;

            // Peut-être checker le format des données ici

            $success = $this->userModel->create($username, $mail, $isAdmin, $password);

            if ($success) {
                $_SESSION['success_message'] = 'Utilisateur ajouté avec succès.';
                header('Location: /manageUser');
                exit();
            } else {
                $_SESSION['error_message'] = 'Échec de l\'ajout de l\'utilisateur. Veuillez réessayer.';
            }
        }
    }

    public function manageUsers()
    {
        $users = $this->userModel->getAllUsers();

        include 'View/manageUser.php';
    }

    public function editUser($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? null;
            $mail = $_POST['mail'] ?? null;
            $isAdmin = isset($_POST['isAdmin']) ? 1 : 0;
            $password = $_POST['password'] ?? null;

            $this->userModel->update($id, $username, $mail, $isAdmin, $password);

            header('Location: /manageUser');
            exit();
        } else {
            // Si le formulaire n'a pas été soumis, récupérer les informations de l'utilisateur pour pré-remplir le formulaire
            $user = $this->userModel->read($id);

            include 'View/editUser.php';
        }
    }

    public function deleteUser($id)
    {
        $this->userModel->delete($id);

        header('Location: /manageUser');
        exit();
    }

}