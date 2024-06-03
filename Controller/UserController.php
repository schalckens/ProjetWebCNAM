<?php

namespace Controller;

use DateTime;
use Model\UserModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class UserController
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
                // Vérifie si l'username ou l'email existent déjà
                if ($this->userModel->usernameExists($username)) {
                    $_SESSION['error'] = "Ce nom d'utilisateur est déjà pris.";
                    header("Location: /register");
                    exit;
                }
                if ($this->userModel->emailExists($mail)) {
                    $_SESSION['error'] = "Un compte avec cette adresse email existe déjà.";
                    header("Location: /register");
                    exit;
                }
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

                    $_SESSION['success'] = "Veuillez vérifier votre email pour activer votre compte.";
                    header("Location: /register");
                    exit();
                } else {
                    $_SESSION['error'] = "Erreur lors de la création du compte.";
                    header("Location: /register");
                    exit;
                }
            } else {
                $_SESSION['error'] = "Veuillez remplir tous les champs.";
                header("Location: /register");
                exit;
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
            echo "Votre email a été vérifié avec succès. Vous allez être redirigé dans quelques secondes...";
            echo "<script>setTimeout(function() { window.location.href = '/login'; }, 5000);</script>";
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
            $mail->Host = 'smtp-detective-du-cinema.alwaysdata.net'; // à remplacer
            $mail->SMTPAuth = true;
            $mail->Username = 'detective-du-cinema@alwaysdata.net'; // À remplacer par nom d'utilisateur SMTP
            $mail->Password = 'Azerty123456789$'; // À remplacer par mot de passe SMTP
            //$mail->SMTPSecure = false;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Destinataires
            $mail->setFrom('detective-du-cinema@alwaysdata.net', 'Mailer');
            $mail->addAddress($email);

            // Contenu de l'email
            $mail->isHTML(true);
            $mail->Subject = 'Vérifiez votre adresse email';
            $verificationLink = 'http://detective-du-cinema.alwaysdata.net/verify/' . $verificationToken;
            $mail->Body = 'Veuillez cliquer sur ce lien pour vérifier votre adresse email: <a href="' . $verificationLink . '">' . $verificationLink . '</a>';

            $mail->send();
            $_SESSION['success'] = "Le message de vérification a été envoyé.";
            header("Location: /register");
            exit();
        } catch (Exception $e) {
            $_SESSION['error'] = "Le message n'a pas pu être envoyé. Mailer Error: {$mail->ErrorInfo}";
            header("Location: /forgotPassword");
            exit;
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
            $_SESSION['error'] = "Le message n'a pas pu être envoyé";
            header("Location: /forgotPassword");
            exit;
        }
    }

    protected function sendResetEmail($email, $token)
    {
        $mail = new PHPMailer(true);
        try {
            // Paramètres du serveur d'envoi
            $mail->isSMTP();
            $mail->Host = 'smtp-detective-du-cinema.alwaysdata.net'; // à remplacer
            $mail->SMTPAuth = true;
            $mail->Username = 'detective-du-cinema@alwaysdata.net'; // À remplacer par nom d'utilisateur SMTP
            $mail->Password = 'Azerty123456789$'; // À remplacer par mot de passe SMTP
            //$mail->SMTPSecure = false;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Destinataires
            $mail->setFrom('detective-du-cinema@alwaysdata.net', 'Mailer');
            $mail->addAddress($email);

            // Contenu de l'email
            $mail->isHTML(true);
            $mail->Subject = 'Vérifiez votre adresse email';
            $resetLink = "http://detective-du-cinema.alwaysdata.net/resetPassword/" . $token;
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
            $user = $this->userModel->getUserByEmail($resetRecord['email']);
            if ($user) {
                // Vérifie que le nouveau mot de passe n'est pas identique à l'ancien
                if (password_verify($newPassword, $user['password'])) {
                    $_SESSION['error'] = "Le nouveau mot de passe ne peut pas être identique à l'ancien mot de passe.";
                    header("Location: /resetPassword/" . $token);
                    exit;
                }

                $currentTime = new DateTime();
                $expireTime = new DateTime($resetRecord['created_at']);
                $expireTime->modify('+1 hour');

                if ($currentTime <= $expireTime) {
                    $this->userModel->updateUserPassword($resetRecord['email'], $newPassword);
                    $this->userModel->invalidateResetToken($token);
                    $_SESSION['success'] = "Votre mot de passe a été réinitialisé avec succès.";
                    echo "<script>setTimeout(function() { window.location.href = '/login'; }, 2000);</script>";
                    exit;
                } else {
                    $_SESSION['error'] = "Le token a expiré";
                    header("Location: /resetPassword");
                    exit;
                }
            }
        } else {
            $_SESSION['error'] = "Token invalide";
            header("Location: /resetPassword");
            exit;
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
                        $_SESSION['error'] = "Votre compte n'a pas été vérifié. Veuillez vérifier votre email.";
                        header("Location: /login");
                        exit;
                    }
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['is_admin'] = $user['isAdmin'];
                    $_SESSION["logged_in"] = true;

                    // Vérifier si l'utilisateur est un administrateur
                    if ($user['isAdmin']) {
                        // Redirige vers le back office pour les administrateurs
                        header('Location: /backoffice');
                    } else {
                        // Redirige vers la page d'accueil pour les utilisateurs
                        header('Location: /game');
                    }
                    exit(); // bonne pratique après un header
                } else {
                    $_SESSION['error'] = "Identifiants incorrects.";
                    header("Location: /login");
                    exit;
                }
            } else {
                $_SESSION['error'] = "Veuillez remplir tous les champs.";
                header("Location: /login");
                exit;
            }
        } else {
            include 'View/login.php';
        }
    }

    public function logout()
    {
        // Efface toutes les données de session
        $_SESSION = array();

        // Efface le cookie de session.
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        // Finalement, détruit la session.
        session_destroy();

        // Redirige l'utilisateur vers la page d'accueil
        header('Location: /accueil');
        exit;
    }


    public function addUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? null;
            $mail = $_POST['mail'] ?? null;
            if (($_POST['isAdmin']) == 1){
                $isAdmin = 1;
            } else{
                $isAdmin = 0;
            }
            
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
            $isAdmin = isset ($_POST['isAdmin']) ? 1 : 0;
            $password = $_POST['password'] ?? null;
            $isVerified = isset ($_POST['is_verified']) ? 1 : 0;
            $this->userModel->update($id, $username, $mail, $isAdmin, $password, $isVerified);

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

    public function getAllUsers()
    {
        $users = $this->userModel->getAllUsers();
        header('Content-Type: application/json');
        echo json_encode($users);
    }

    public function getUserById($id)
    {
        $user = $this->userModel->read($id);
        if ($user) {
            header('Content-Type: application/json');
            echo json_encode($user);
        } else {
            header('HTTP/1.1 404 Not Found');
            echo json_encode(['message' => 'Utilisateur non trouvé']);
        }
    }

}