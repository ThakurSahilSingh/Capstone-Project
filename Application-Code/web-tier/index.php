<?php
$apiUrl = 'http://app-service/';
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
 
    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query(['name' => $name])
        ]
    ];
    $context = stream_context_create($options);
    file_get_contents($apiUrl, false, $context);
 
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
 
$response = file_get_contents($apiUrl);
$users = json_decode($response, true);
?>
 
<!DOCTYPE html>
<html>
<head>
    <title>User Journal</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@600&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Open Sans', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }
 
        header {
            background-color: #20263a;
            color: #ffffff;
            padding: 28px 0;
            text-align: center;
            font-family: 'Roboto Mono', monospace;
            letter-spacing: 1px;
            font-size: 24px;
        }
 
        .wrapper {
            max-width: 700px;
            margin: 40px auto;
            padding: 30px;
            background-color: #ffffff;
            box-shadow: 0 0 0 4px #e4e4e4 inset, 0 8px 20px rgba(0,0,0,0.05);
        }
 
        h2 {
            font-weight: 600;
            margin-bottom: 20px;
            color: #1a1a1a;
        }
 
        form {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
 
        textarea {
            font-size: 16px;
            padding: 16px;
            border: 1px solid #ccc;
            border-left: 6px solid #20263a;
            resize: vertical;
            min-height: 100px;
            font-family: 'Open Sans', sans-serif;
            background-color: #fdfdfd;
        }
 
        textarea:focus {
            outline: none;
            border-color: #20263a;
            box-shadow: 0 0 0 3px rgba(32, 38, 58, 0.1);
        }
 
        input[type="submit"] {
            padding: 12px 22px;
            background-color: #20263a;
            color: white;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            align-self: flex-start;
        }
 
        input[type="submit"]:hover {
            background-color: #0d111e;
        }
 
        ul {
            list-style-type: square;
            padding-left: 20px;
            margin-top: 30px;
        }
 
        li {
            margin-bottom: 12px;
            background-color: #f2f2f2;
            padding: 10px 14px;
            border-left: 4px solid #20263a;
        }
 
        @media (max-width: 600px) {
            .wrapper {
                margin: 20px 12px;
                padding: 20px;
            }
 
            header {
                font-size: 20px;
                padding: 18px 0;
            }
 
            input[type="submit"] {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <header>Keep Notes</header>
    <div class="wrapper">
        <h2>Add a Note</h2>
        <form method="post">
            <textarea name="name" placeholder="Write a name or a note..." required></textarea>
            <input type="submit" value="Add Note">
        </form>
 
        <h2>Saved Notes</h2>
        <ul>
            <?php foreach ($users as $user): ?>
                <li><?= htmlspecialchars($user['name']) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
