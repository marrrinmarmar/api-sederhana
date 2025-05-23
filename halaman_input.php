<!DOCTYPE html>
<html>
<head>
    <title>Input Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 300px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            flex: 1;
        }
        .submit-btn {
            background-color: #4CAF50;
            color: white;
        }
        .input-btn {
            background-color: #2196F3;
            color: white;
        }
        button:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <form method="POST" action="http://localhost/api-mapelsiryoni/belajarAPI.php">
    <div class="login-container">
        <h2 style="text-align: center; margin-bottom: 20px;">Input Data</h2>
        <div class="form-group">
            <input name="id" type="text" placeholder="ID" required>
        </div>
        <div class="form-group">
            <input name="nama" type="text" placeholder="Nama" required>
        </div>
        <div class="button-group">
            <button name="command" type="submit" class="submit-btn">Setup</button>
            <button name="test" type="submit" class="input-btn">Submit</button>
        </div>
        </form>
    </div>
</body>
</html>