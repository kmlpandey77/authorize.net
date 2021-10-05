<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment form</title>    
</head>

<body>

    <form action="Payment.php" method="POST">

        <fieldset class="form">
            <legend>Card Info</legend>

            <label>CARD NUMBER</label><br>
            <input type="text" id="card_number" name="card_number"><br><br>

            <label>EXPIRY DATE</label><br>
            <input class="form-control" type="text" name="card_exp_month" placeholder="MM" required="">
            <input class="form-control" type="text" name="card_exp_year" placeholder="YYYY" required="">
            <br><br>


            <label>CVC CODE</label><br>
            <input class="form-control" type="text" name="card_cvc" placeholder="CVC" autocomplete="off" required="">

        </fieldset>
        
        
        <br>
        <fieldset>
            <legend>Personal Info</legend>

            <label>First Name</label><br>
            <input type="text" id="first_name" name="first_name"><br><br>

            <label>Last Name</label><br>
            <input type="text" id="last_name" name="last_name"><br><br>

            <label>Email</label><br>
            <input class="form-control" type="text" name="email" required="">            
            <br><br>

            <label>State</label><br>
            <input class="form-control" type="text" name="state" required="">            
            <br><br>

            <label>Street</label><br>
            <input class="form-control" type="text" name="street" required="">            
            <br><br>

            <label>City</label><br>
            <input class="form-control" type="text" name="city" required="">            
            <br><br>

            <label>Zip Code</label><br>
            <input class="form-control" type="text" name="zip_code" required="">            
            <br><br>

            <label>Country</label><br>
            <input class="form-control" type="text" name="country" required="">            
            <br><br>


        </fieldset>

        <br>
        <fieldset>
            <legend>Price</legend>

            <label>Price</label><br>
            <input type="text" id="price" name="price" value="1"><br>


        </fieldset>
        
        <br><br>
        <input type="submit" value="Submit">
    </form>

</body>

</html>