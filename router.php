<?php

// Définition d'une classe nommée Router
class Router
{
    // Propriété protégée $routes qui contiendra toutes les routes enregistrées
    protected $routes = [];

    // Méthode publique addRoute permettant d'ajouter une nouvelle route au routeur
    public function addRoute(string $method, string $url, Closure $target)
    {
        // Enregistre la cible (fonction à exécuter) pour la combinaison méthode HTTP et URL spécifiées
        $this->routes[$method][$url] = $target;
    }

    // Méthode publique matchRoute pour trouver et exécuter la cible d'une route correspondant à la requête actuelle
    public function matchRoute()
    {
        // Récupération de la méthode HTTP et de l'URL de la requête actuelle
        $method = $_SERVER['REQUEST_METHOD'];
        $url = $_SERVER['REQUEST_URI'];

        // Vérification si des routes existent pour la méthode HTTP utilisée
        if (isset($this->routes[$method])) {
            // Itération sur toutes les routes enregistrées pour cette méthode
            foreach ($this->routes[$method] as $routeUrl => $target) {
                // Préparation du motif de l'expression régulière pour capturer les paramètres dynamiques dans l'URL
                $pattern = preg_replace('/\/:([^\/]+)/', '/(?P<$1>[^/]+)', $routeUrl);
                // Vérification si l'URL de la requête correspond à la route en cours
                if (preg_match('#^' . $pattern . '$#', $url, $matches)) {
                    // Filtre les éléments capturés pour ne garder que ceux ayant des clés string (noms de paramètres)
                    $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                    // Appel de la fonction cible de la route avec les paramètres filtrés
                    call_user_func_array($target, $params);
                    // Arrêt de la méthode après avoir trouvé et exécuté une route correspondante
                    return;
                }
            }
        }
        // Levée d'une exception si aucune route correspondante n'a été trouvée
        throw new Exception('Route not found');
    }
}
