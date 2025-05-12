<?php
session_start();
$hashedPassword = password_hash('1234', PASSWORD_DEFAULT); // Store this hash securely
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Resources</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            height: 100vh;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .container {
            background-color: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 600px;
            box-sizing: border-box;
            margin-top: 20px;
        }

        .search-bar, .password-bar {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 25px;
            outline: none;
            font-size: 16px;
            box-sizing: border-box;
        }

        .search-bar:focus, .password-bar:focus {
            border-color: #aaa;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 25px;
            background-color: #007BFF;
            color: white;
            font-size: 16px;
            cursor: pointer;
            box-sizing: border-box;
        }

        button:hover {
            background-color: #0056b3;
        }

        .result-list {
            list-style-type: none;
            padding: 0;
            margin: 20px 0 0 0;
        }

        .result-list li {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .result-list li:last-child {
            border-bottom: none;
        }

        .result-list li a {
            text-decoration: none;
            color: #007BFF;
            transition: color 0.3s;
        }

        .result-list li a:hover {
            color: #0056b3;
        }

        .footer {
            margin-top: 20px;
            font-size: 14px;
            text-align: center;
            color: #888;
            width: 100%;
            box-sizing: border-box;
        }

        @media (max-width: 600px) {
            .container {
                padding: 15px;
            }

            .search-bar, .password-bar, button {
                padding: 10px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        // Authenticate the user with a password
        if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
                if (password_verify($_POST['password'], $hashedPassword)) {
                    $_SESSION['authenticated'] = true;
                } else {
                    echo '<p style="color:red;">Incorrect password!</p>';
                }
            }

            if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
                echo '
                <form method="POST">
                    <input type="password" name="password" class="password-bar" placeholder="Enter password...">
                    <button type="submit">Submit</button>
                </form>';
                exit;
            }
        }

        // Function to search files and exclude specified folders
        function searchFiles($dir, $searchQuery) {
            $result = [];
            $files = scandir($dir);
            $excludedFiles = ['.htaccess', '.htpasswd', 'config.php', 'settings.php', 'database.php', '.private', '.archive']; // Excluding sensitive files and folders

            foreach ($files as $file) {
                if ($file === '.' || $file === '..' || in_array($file, $excludedFiles)) continue;

                $filePath = $dir . DIRECTORY_SEPARATOR . $file;

                if (is_dir($filePath) && !in_array($file, ['.private', '.archive'])) {
                    $result = array_merge($result, searchFiles($filePath, $searchQuery));
                } else {
                    if (stripos($file, $searchQuery) !== false) {
                        $result[] = $filePath;
                    }
                }
            }
            return $result;
        }

        // Function to get a relative path for display
        function getRelativePath($absolutePath) {
            $rootPath = realpath($_SERVER['DOCUMENT_ROOT']);
            return str_replace($rootPath, '', $absolutePath);
        }
        ?>

        <form method="POST" onsubmit="return validateSearch()">
            <input type="text" id="search-bar" name="search" class="search-bar" placeholder="Search files...">
            <button type="submit">Search</button>
        </form>
        <ul class="result-list">
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
                $searchQuery = $_POST['search'];
                $directory = __DIR__;  // Search in the root directory of the website

                $results = searchFiles($directory, $searchQuery);

                if (empty($results)) {
                    echo '<li>No files or folders found!</li>';
                } else {
                    foreach ($results as $result) {
                        $relativePath = getRelativePath($result);
                        $url = 'http://' . $_SERVER['HTTP_HOST'] . $relativePath;
                        echo '<li><a href="' . htmlspecialchars($url) . '" target="_blank">' . htmlspecialchars(basename($relativePath)) . '</a></li>';
                    }
                }
            }
            ?>
        </ul>
    </div>
    <div class="footer">
        &copy; <?php echo date("Y"); ?> S. Vasu
    </div>
    <script>
        function validateSearch() {
            var searchBar = document.getElementById('search-bar');
            if (searchBar.value.length < 3) {
                alert('Please enter at least 3 characters.');
                return false;
            }
            return true;
        }
    </script>
</body>
</html>

