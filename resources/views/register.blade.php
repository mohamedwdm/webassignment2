<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h1>Registration Form</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('register.submit') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label>Full Name:</label>
        <input type="text" name="full_name" required>
        <br>

        <label>Username:</label>
        <input type="text" name="user_name" id="user_name" required>
        <span id="username-check"></span>
        <br>

        <label>Phone:</label>
        <input type="text" name="phone" required>
        <br>

        <label>WhatsApp Number:</label>
        <input type="text" name="whatsapp" required>
        <button type="button" id="check-whatsapp">Check</button>
        <span id="whatsapp-check"></span>
        <br>

        <label>Address:</label>
        <input type="text" name="address" required>
        <br>

        <label>Email:</label>
        <input type="email" name="email" required>
        <br>

        <label>Password:</label>
        <input type="password" name="password" required>
        <br>

        <label>Confirm Password:</label>
        <input type="password" name="password_confirmation" required>
        <br>

        <label>User Image:</label>
        <input type="file" name="user_image" required>
        <br><br>

        <button type="submit">Register</button>
    </form>

    <!-- AJAX for username check -->
    <script>
    document.getElementById('user_name').addEventListener('input', function () {
        fetch("{{ route('check.username') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ user_name: this.value })
        })
        .then(res => res.json())
        .then(data => {
            const span = document.getElementById('username-check');
            span.textContent = data.exists ? "Username taken" : "Username available";
            span.style.color = data.exists ? "red" : "green";
        });
    });
    </script>
</body>
</html>
