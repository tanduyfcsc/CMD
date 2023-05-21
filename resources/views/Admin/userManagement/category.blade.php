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
            <label for="email">Email:</label>
            <input type="text" name="email" id="email">
        </div>
        <button type="button" onclick="resetPassword()">Đăng</button>
    </form>
    <script>
        function resetPassword() {
            const email = document.querySelector('#email').value;
            fetch('https://doan-production-0b9f.up.railway.app/api/reset/password', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        email: email
                    })
                })
                .then(response => response.json())
                .then(data => console.log(data))
                .catch(error => console.error(error));
        }
    </script>
</body>

</html>
