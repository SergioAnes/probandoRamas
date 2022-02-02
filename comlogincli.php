<html>

    <head>
        <title>LOGIN</title>
    </head>

    <body>

        <form action="comlogincli.php" method="POST">
            
            <h1>Login</h1>
            
            <label>USUARIO: </label> 
            <input type="text" name="usuario" required/><br/>
            
            <label>CONTRASEÑA: </label>
            <input type="text" name="password" required/><br/>

            <input type="submit" value="LOGIN"/>

        </form>
       
        <?php
            if($_POST){ //Cuando se completan los datos, se viene aquí. 
                session_start();
                include('funcionesWeb.php');
                $conexion = crearConexionPDO();
                $usuario=$_POST['usuario'];
                $password=$_POST['password'];
                $query=$conexion->prepare("SELECT nombre, nif FROM cliente WHERE NOMBRE= :usuario AND clave = :password");
                $query->bindParam(":usuario", $usuario); //Esto es simplemente una asociación de variables. Hasta que no se ejecuta, no se hace. 
                $query->bindParam(":password", $password);
                $query->execute();
                $usuarioLogin=$query->fetch(PDO::FETCH_ASSOC); //Crea un array indexado: $usuarioLogin[nombre] = daría el nombre solicitado en la consulta. 

                if ($usuarioLogin){
                    $_SESSION['usuarioNombre'] = $usuarioLogin["nombre"];
                    $_SESSION['usuarioDNI'] = $usuarioLogin["nif"];
                    header("location:comlogincli2.php"); //La función header() se puede utilizar para redirigir automáticamente a otra página, enviando como argumento la cadena Location:
                }else{
                    echo "Usuario o password incorrecto";
                }

            } 
        ?>
    </body>
</html>