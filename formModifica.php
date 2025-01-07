<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/body.css">
    <link rel="stylesheet" href="css/formModifica.css">
    <title>User Profile</title>
    <style>
        .container {
            display: flex;
            align-items: flex-start;
            flex-direction: column;
            justify-content: center;
            height: auto;
            margin-top: 20px;
            gap: 20px;
        }

        .user-icon {
            width: 20%;
            text-align: center;
            padding: 20px;
            position: relative;
        }

        .user-icon img {
            border-radius: 50%;
            width: 150px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .user-icon img.editable {
            cursor: pointer;
        }

        .user-icon img.editable:hover {
            transform: scale(1.1);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .form-container,
        .password-form-container {
            width: 60%;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-row {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }

        .form-control,
        .password-form-control {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-control.half-width {
            flex: 1;
        }

        .form-control.large-width {
            flex: 2;
        }

        .form-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            display: inline-block;
        }

        .form-button:hover {
            background-color: #0056b3;
        }

        .form-button.hidden {
            display: none;
        }

        .cancel-button {
            background-color: #dc3545;
        }

        .cancel-button:hover {
            background-color: #c82333;
        }

        .confirm-button {
            background-color: #28a745;
        }

        .confirm-button:hover {
            background-color: #218838;
        }

        h2 {
            margin-bottom: 20px;
        }

        .hidden {
            display: none;
        }
    </style>
    <script src="js/gestioneFormModifica.js"></script>
    </head>

<body>

    <?php require 'header.php';
    require 'database/get_info.php';
    ?>

    <div class="container">
        <div class="user-icon">
            <img id="profileImage"
                src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"
                alt="User Icon">
        </div>
        <div class="form-container">
            <h2>User Information</h2>
            <form id="userForm">
                <div class="form-row">
                    <input type="text" id="firstname" name="firstname" class="form-control half-width"
                        placeholder="Name" required value="<?php echo htmlspecialchars($first, ENT_QUOTES); ?>">
                    <input type="text" id="lastname" name="lastname" class="form-control half-width"
                        placeholder="Surname" required value="<?php echo htmlspecialchars($last, ENT_QUOTES); ?>">
                </div>
                <div class="form-row">
                    <input type="email" id="email" name="email" class="form-control large-width" placeholder="Email"
                        required value="<?php echo htmlspecialchars($email, ENT_QUOTES); ?>">
                </div>
                <button type="submit" class="form-button" style="display: none;">Submit</button>
            </form>
            <button id="editProfileButton" class="form-button">Modifica Informazioni</button>
            <button id="cancelButton" class="form-button cancel-button hidden">Annulla</button>
            <button id="confirmInfoButton" class="form-button confirm-button hidden">Conferma</button>
        </div>

        <div class="password-form-container">
            <button id="editPasswordButton" class="form-button">Modifica Password</button>
            <div id="passwordForm" class="hidden">
                <form id="passwordUpdateForm">
                    <div class="form-row">
                        <input type="password" id="password" name="password"
                            class="password-form-control half-width" placeholder="Nuova Password" required>
                        <input type="password" id="confirmPassword" name="confirmPassword"
                            class="password-form-control half-width" placeholder="Conferma Password" required>
                    </div>
                </form>
                <button id="cancelPasswordButton" class="form-button cancel-button">Annulla</button>
                <button id="confirmPasswordButton" class="form-button confirm-button">Conferma</button>
            </div>
        </div>
    </div>


</body>

</html>