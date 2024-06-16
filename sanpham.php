<?php
session_start();

// Autoload các lớp
spl_autoload_register(function ($class_name) {
    $paths = [
        __DIR__ . '/Models/' . $class_name . '.php',
        __DIR__ . '/Controllers/' . $class_name . '.php'
    ];

    foreach ($paths as $path) {
        if (file_exists($path)) {
            include $path;
        }
    }
});

// Bộ định tuyến đơn giản
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'Product';
$action = isset($_GET['action']) ? $_GET['action'] : 'list';

// Tạo tên lớp controller
$controllerName = $controller . 'Controller';

// Kiểm tra xem lớp controller có tồn tại không
if(class_exists($controllerName)) {
    $controllerInstance = new $controllerName();
    
    // Kiểm tra xem phương thức (hành động) có tồn tại không
    if(method_exists($controllerInstance, $action)) {
        $controllerInstance->$action();
    } else {
        echo "Hành động '$action' không tồn tại trong '$controllerName'.";
    }
} else {
    echo "Controller '$controllerName' không tồn tại.";
}
?>