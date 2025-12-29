<?php
/**
 * Base Controller Class
 * Handles view rendering and request/response
 */
abstract class Controller
{

    /**
     * Render view
     */
    protected function view($view, $data = [], $layout = 'layouts/main', $returnAsString = false)
    {
        // Extract data to variables
        extract($data);

        // Start output buffering
        ob_start();

        // Include view file
        $viewFile = __DIR__ . '/../views/' . $view . '.php';
        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            die("View not found: {$view}");
        }

        // Get view content
        $content = ob_get_clean();

        // If layout is specified, wrap content in layout
        if ($layout) {
            $layoutFile = __DIR__ . '/../views/' . $layout . '.php';
            if (file_exists($layoutFile)) {
                // If returning as string, we can't easily capture layout unless we do nested buffering
                // But typically for AJAX partials ($returnAsString=true), we pass $layout=null
                // So this logic holds for normal pages.

                // If returning string with layout, we need to capture that too.
                if ($returnAsString) {
                    ob_start();
                    require $layoutFile;
                    return ob_get_clean();
                }

                require $layoutFile;
            } else {
                if ($returnAsString) {
                    return $content;
                }
                echo $content;
            }
        } else {
            if ($returnAsString) {
                return $content;
            }
            echo $content;
        }
    }

    /**
     * Return JSON response
     */
    protected function json($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Redirect to URL
     */
    protected function redirect($url)
    {
        header("Location: " . url($url));
        exit;
    }

    /**
     * Get POST data
     */
    protected function post($key = null, $default = null)
    {
        if ($key === null) {
            return $_POST;
        }
        return $_POST[$key] ?? $default;
    }

    /**
     * Get GET data
     */
    protected function get($key = null, $default = null)
    {
        if ($key === null) {
            return $_GET;
        }
        return $_GET[$key] ?? $default;
    }

    /**
     * Get REQUEST data
     */
    protected function input($key, $default = null)
    {
        return $_REQUEST[$key] ?? $default;
    }

    /**
     * Check if request is POST
     */
    protected function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    /**
     * Check if request is AJAX
     */
    protected function isAjax()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    /**
     * Validate input
     */
    protected function validate($data, $rules)
    {
        $errors = [];

        foreach ($rules as $field => $rule) {
            $ruleArray = explode('|', $rule);

            foreach ($ruleArray as $r) {
                // Required rule
                if ($r === 'required' && empty($data[$field])) {
                    $errors[$field] = ucfirst($field) . ' is required';
                    break;
                }

                // Email rule
                if ($r === 'email' && !empty($data[$field]) && !filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
                    $errors[$field] = ucfirst($field) . ' must be a valid email';
                    break;
                }

                // Min length rule
                if (strpos($r, 'min:') === 0) {
                    $min = (int) substr($r, 4);
                    if (!empty($data[$field]) && strlen($data[$field]) < $min) {
                        $errors[$field] = ucfirst($field) . " must be at least {$min} characters";
                        break;
                    }
                }

                // Max length rule
                if (strpos($r, 'max:') === 0) {
                    $max = (int) substr($r, 4);
                    if (!empty($data[$field]) && strlen($data[$field]) > $max) {
                        $errors[$field] = ucfirst($field) . " must not exceed {$max} characters";
                        break;
                    }
                }

                // Numeric rule
                if ($r === 'numeric' && !empty($data[$field]) && !is_numeric($data[$field])) {
                    $errors[$field] = ucfirst($field) . ' must be a number';
                    break;
                }
            }
        }

        return empty($errors) ? true : $errors;
    }

    /**
     * Upload file
     */
    protected function uploadFile($file, $directory = 'uploads', $allowedTypes = ['jpg', 'jpeg', 'png', 'pdf'])
    {
        if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'message' => 'No file uploaded or upload error'];
        }

        // Validate file type
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, $allowedTypes)) {
            return ['success' => false, 'message' => 'Invalid file type'];
        }

        // Generate unique filename
        $filename = uniqid() . '_' . time() . '.' . $extension;
        $uploadPath = PUBLIC_PATH . '/uploads/' . $directory . '/';

        // Create directory if not exists
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Move file
        if (move_uploaded_file($file['tmp_name'], $uploadPath . $filename)) {
            return [
                'success' => true,
                'filename' => $filename,
                'path' => 'uploads/' . $directory . '/' . $filename
            ];
        }

        return ['success' => false, 'message' => 'Failed to move uploaded file'];
    }

    /**
     * Sanitize input
     */
    protected function sanitize($data)
    {
        if (is_array($data)) {
            return array_map([$this, 'sanitize'], $data);
        }
        return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Log user activity
     */
    protected function logActivity($userId, $action, $module = 'General', $description = null)
    {
        try {
            $db = Database::getInstance();
            $db->insert('activity_logs', [
                'user_id' => $userId,
                'action' => $action,
                'module' => $module,
                'description' => $description,
                'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'Unknown',
                'created_at' => date('Y-m-d H:i:s')
            ]);
        } catch (Exception $e) {
            error_log('Activity log error: ' . $e->getMessage());
        }
    }
}
