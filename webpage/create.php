<?php

// Parámetros de conexión
$host = "localhost";
$port = "5432";
$dbname = "areas";
$user = "my_user";
$password = "password";

// Conectar a psql
$link = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

// Checar conexión
if (!$link) {
    die("Connection failed: " . pg_last_error());
}

// Define variables e inicializar
$name = $address = $salary = "";
$name_err = $address_err = $salary_err = "";

// Procesar datos
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!preg_match('/^[a-zA-Z\s]+$/', $input_name)){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    // Validar dirección
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";     
    } else{
        $address = $input_address;
    }
    
    // Validate salario
    $input_salary = trim($_POST["salary"]);
    if(empty($input_salary)){
        $salary_err = "Please enter the salary amount.";     
    } elseif(!ctype_digit($input_salary)){
        $salary_err = "Please enter a positive integer value.";
    } else{
        $salary = $input_salary;
    }
    
    // Revisar errores
    if(empty($name_err) && empty($address_err) && empty($salary_err)){
        // Enunciado para insertar
        $sql = "INSERT INTO employees (name, address, salary) VALUES ($1, $2, $3)";
        
        $stmt = pg_prepare($link, "insert_query", $sql);
        
        if($stmt){
            // Bind parameters
            $params = array($name, $address, $salary);
            
            // Attempt to execute the prepared statement
            $result = pg_execute($link, "insert_query", $params);
            if($result){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        pg_free_result($stmt);
    }
    
    // Close connection
    pg_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Crear usuario</h2>
                    <p>Llene los espacios para registrar un nuevo usuario</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Direccion</label>
                            <textarea name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $address; ?></textarea>
                            <span class="invalid-feedback"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Edad</label>
                            <input type="text" name="salary" class="form-control <?php echo (!empty($salary_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $salary; ?>">
                            <span class="invalid-feedback"><?php echo $salary_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
    <button id="go-back">Go back!</button>
    <script>
    document.getElementById("go-back").addEventListener("click", () => {
        history.back();
      });
      </script>
</body>
</html>
