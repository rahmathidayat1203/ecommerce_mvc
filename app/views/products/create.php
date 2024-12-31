<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Product</title>
</head>
<body>
    <form action="/ecommerce_mvc/products/store" method="post">
        <label for="name">Name</label>
        <input type="text" placeholder="name" name="name">
        <button type="submit">send</button>
    </form>
</body>
</html>