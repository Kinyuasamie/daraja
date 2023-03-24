<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="mpesa.css">
    </head>
    <body>
        <div class="main">
            <h1>lipa na mpesa</h1><br/>
        <form action="stk_initiate.php" method="post" name="mpesa">
            <table>
                <tr><td>Enter amount</td></tr>
                <tr><td><input type="text" name="amount" placeholder="enter amount"></td></tr>
                <tr><td>Enter phone</td></tr>
                <tr><td><input type="text" name="phone" placeholder="enter phone"></td></tr>
                <tr><td><input type="submit" name="submit" value="Send" class="btn"></td></tr>
            </table>
</form>
        </div>
    </body>
</html>
