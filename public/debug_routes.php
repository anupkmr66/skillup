<?php
require __DIR__ . '/../config/constants.php';
require __DIR__ . '/../core/Router.php';

$router = new Router();
require __DIR__ . '/../routes/web.php';

echo "<h1>Registered Routes</h1>";
echo "<table border='1'><tr><th>Method</th><th>Path</th><th>Handler</th></tr>";

// Access the routes via reflection since they're private
$reflection = new ReflectionClass($router);
$property = $reflection->getProperty('routes');
$property->setAccessible(true);
$routes = $property->getValue($router);

foreach ($routes as $route) {
    echo "<tr>";
    echo "<td>" . $route['method'] . "</td>";
    echo "<td>" . $route['path'] . "</td>";
    echo "<td>" . $route['handler'] . "</td>";
    echo "</tr>";
}
echo "</table>";
