<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Đăng video mới</title>
</head>

<body>
    <h1>Đăng video mới</h1>
    <form>
        <div>
            <label for="password">Mật khẩu mới:</label>
            <input type="password" name="password" id="password">
        </div>
        <button type="button" onclick="resetPassword()">Đăng</button>
    </form>
    <script>
        function resetPassword() {
            const password = document.querySelector('#password').value;
            fetch('http://127.0.0.1:8000/api/update/password', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        password: password,
                    })
                })
                .then(response => response.text())
                .then(data => console.log(JSON.parse(data)))
                .catch(error => console.error(error));
        }
    </script>
</body>

</html>
