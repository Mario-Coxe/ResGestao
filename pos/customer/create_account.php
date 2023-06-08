<?php
session_start();
include('config/config.php');
//login 
if (isset($_POST['addCustomer'])) {
    //Prevent Posting Blank Values
    if (empty($_POST["customer_phoneno"]) || empty($_POST["customer_name"]) || empty($_POST['customer_email']) || empty($_POST['customer_password'])) {
        $err = "Valores não aceites";
    } else {
        $customer_name = $_POST['customer_name'];
        $customer_phoneno = $_POST['customer_phoneno'];
        $customer_email = $_POST['customer_email'];
        $customer_password = sha1(md5($_POST['customer_password'])); //Hash This 
        $customer_id = $_POST['customer_id'];

        //Insert Captured information to a database table
        $postQuery = "INSERT INTO rpos_customers (customer_id, customer_name, customer_phoneno, customer_email, customer_password) VALUES(?,?,?,?,?)";
        $postStmt = $mysqli->prepare($postQuery);
        //bind paramaters
        $rc = $postStmt->bind_param('sssss', $customer_id, $customer_name, $customer_phoneno, $customer_email, $customer_password);
        $postStmt->execute();
        //declare a varible which will be passed to alert function
        if ($postStmt) {
            $success = "Conta criada" && header("refresh:1; url=index.php");
        } else {
            $err = "Desculpe, tente novamente";
        }
    }
}
require_once('partials/_head.php');
require_once('config/code-generator.php');
?>

<body class="bg-dark">
    <div class="main-content">
        <div class="header bg-gradient-primar py-7">
            <div class="container">
                <div class="header-body text-center mb-7">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 col-md-6">
                            <h1 class="text-white">ResGestão</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page content -->
        <div class="container mt--8 pb-5">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="card bg-secondary shadow border-0">
                        <div class="card-body px-lg-5 py-lg-5">
                            <form method="post" role="form">
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input class="form-control" required name="customer_name" placeholder="Nome completo" type="text">
                                        <input class="form-control" value="<?php echo $cus_id;?>" required name="customer_id"  type="hidden">
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input class="form-control" required name="customer_phoneno" placeholder="Número de telefone" type="text">
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                        </div>
                                        <input class="form-control" required name="customer_email" placeholder="Email" type="email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                        </div>
                                        <input class="form-control" required name="customer_password" placeholder="Senha" type="password">
                                    </div>
                                </div>

                                <div class="text-center">
                                </div>
                                <div class="form-group">
                                    <div class="text-left">
                                        <button type="submit" name="addCustomer" class="btn btn-primary my-4">Criar Conta</button>
                                        <a href="index.php" class=" btn btn-success pull-right">Entrar</a>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <a href="../admin/forgot_pwd.php" target="_blank" class="text-light"><small>Recuperar Senha?</small></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <?php
    require_once('partials/_footer.php');
    ?>
    <!-- Argon Scripts -->
    <?php
    require_once('partials/_scripts.php');
    ?>
</body>

</html>