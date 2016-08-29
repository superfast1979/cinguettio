<?php
$_SESSION['title'] = "Recupero Password";
include("head.php");
?>

<body onUnLoad="window.alert('Mail Inviata')">
    <div class="col-md-4"></div>
    <div class="col-md-4 text-center">
        <h2>Recupero Password Dimenticata</h2><br>
        <form name="myForm" action="Login.php" class="form-horizontal">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10">
                    <input type = "text" name="email" class="form-control" id="inputEmail3" placeholder="Email">
                </div>
            </div>
            <div class="form-group text-center">
                <button type="submit" name="ok" class="btn btn-primary" onclick="myFunction()">Manda</button>
                <script>
                    function myFunction() {
                        alert("La mail e' stata inviata!(simulazione)");
                    }
                </script>
            </div>
        </form>
    </div>		
    <div class="col-md-4"></div>
</body>
