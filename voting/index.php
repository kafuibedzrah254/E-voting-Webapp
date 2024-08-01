<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Php Voting System</title>

    <!-- Bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"  rel="stylesheet">
</head>
<body class="bg-secondary">
    <h1 class="text-info text text-center p-3 ">E-Voting System</h1>
    <div class="bg-info py-4">
        <h2  class="text-center">Login</h2>
        <div class="container text-center">
            <form action="./actions/login.php"  method="POST">

            <!-- Username Input Field-->
                <div class="mb-3">
                    <input type="text" class="form-control w-50 m-auto" name="username" placeholder="Enter your username " required="required" >
                </div>

            <!-- Phone Number Input Field-->

            <div class="mb-3">
                    <div class="input-group w-50 m-auto">
                        <span class="input-group-text">+233</span>
                        <input type="tel" class="form-control" placeholder="Enter your phone number" required="required" name="mobile" pattern="[0-9]{9}" title="">
                    </div>
                </div>

            <!-- Password Input Field-->
                
                <div class="mb-3">
                    <input type="password" class="form-control w-50 m-auto" name="password" placeholder="Enter your password " required="required" >
                </div>

            <div class="mb-3">
                <!--<select name="std"   class="form-select w-50 m-auto" >
                    <option value="single voter">Single Voter</option>
                    <option value="poll creator">Poll Creator</option>

                </select>-->
            </div>

            <div>
                <button type="submit" class="btn btn-dark my-4">Login</button>
                <p>Don't have an account?                <a href="./partials/registration.php" class="text-white">Register here</a>
</p>
            </div>

            


                
                

            </form>
        </div>
    </div>



    
</body>
</html>