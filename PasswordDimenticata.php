<html>
    <?php
    $_SESSION['title'] = "Recupero Password";
    include("head.php");
    ?>

    <body onUnLoad="window.alert('Mail Inviata')">
        <div align="center">Recupero Password Dimenticata</div>		
        <p>
        <form method="post" action="">
            <ul align="center">
                <li>Email: <input type = "email" name = "nome"/></li>
                <li><button class="button button" input type= "submit" onclick="myFunction()">OK</button></li>
                <script>
                    function myFunction() {
                        alert("La mail e' stata inviata!");
                    }
                </script>
                <li><a href="Login.html">Torna</a></li>
            </ul>	
        </form>
    </p>		

</body>
</html>