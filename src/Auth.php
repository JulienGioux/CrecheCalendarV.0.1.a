<?php
namespace CrecheCalendar {


    use Exception;
    use PDO;

    class Auth {

        private ConnectBdd $DBase;
        private PDO $bdd;
        private $router;

        /**
         * Constructeur défini la connection à la base de donnée
         *
         * @param $router Instance du routeur pour générer dynamiquement liens
         * et redirections au sein de la class
         */
        public function __construct($router)
        {
            try {
                $this->DBase = new ConnectBdd();
                $this->bdd = $this->DBase->connexion();
                $this->router = $router;
            } catch (Exception $e) {
                die('Erreur de connection à la base de donnée : ' . $e->getMessage());
            }
        }


        public function requireRole(string ...$role): void
        {
            $user = $this->user();
            if ($user === null ||  !in_array($user->role, $role)) {
                header('Location: ' . $this->router->generate('noAuth'));
                exit();
            }
        }

        public function user(): ?User {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $id = $_SESSION['auth']['id'] ?? null;
            $userEmail = $_SESSION['auth']['userEmail'] ?? null;
            $role = $_SESSION['auth']['role'] ?? null;
            if ($id === null || $userEmail === null || $role === null) {
                return null;
            }

            if ($role === 'Responsable Légal') {
                $user = new RespLegal();

                $userInfo = $user->getRespLegalInfos($userEmail);
                $userInfo->role = $role;
            } else if ($role === 'Modérateur' || $role === 'Employé') {
                $user = new Employee();
                $userInfo = $user->getEmployeeInfo($userEmail);

            }
                return $userInfo ?? null;
        }

        public function login(string $username, string $password, bool $isEmployee): ?User {
            if ($isEmployee) {
                $user = new Employee();
                $testLogin = $user->VerifyLogin($username, $password, $isEmployee);
                if ($testLogin) {
                    $userInfo = $user->getEmployeeInfo($username);
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }
                    $_SESSION['auth'] = ['id' => $userInfo->userId, 'userEmail' => $userInfo->userEmail, 'role' => $userInfo->role];
                    return $userInfo;
                } else {
                    return null;
                };
            } else {
                $user = new RespLegal();
                $testLogin = $user->VerifyLogin($username, $password, $isEmployee);
                if ($testLogin) {
                    $userInfo = $user->getRespLegalInfos($username);
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }

                    $_SESSION['auth'] = ['id' => $userInfo->userId, 'userEmail' => $userInfo->userEmail, 'role' => 'Responsable Légal'];

                    return $userInfo;
                } else {
                    return null;
                }
            }

        }
    }
}
