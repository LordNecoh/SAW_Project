<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/body.css">
    <link rel="stylesheet" href="css/formModifica.css">

    <title>User Profile</title>
    
</head>
<?php
    require 'database/get_info.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        .container {
    display: flex;
    align-items: flex-start;
    flex-direction: column;
    justify-content: center;
    height: auto; /* Cambiato da 60vh per consentire l'espansione */
    margin-top: 20px;
    gap: 20px; /* Spazio tra i contenitori */
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

.form-container {
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

.form-control {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
    background-color: #e9ecef;
    pointer-events: none;
}

.form-control.editable {
    background-color: #ffffff;
    pointer-events: auto;
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

/* Stile per il nuovo form della password */
.password-form-container {
    width: 60%;
    background: #ffffff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    gap: 15px;
}

    </style>

</head>
<body>
        <?php include 'header.php'?>

    <div class="container">
        <div class="user-icon">
            <img id="profileImage" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg" alt="User Icon">
        </div>
        <div class="form-container">
            <h2>User Information</h2>
            <form id="userForm">
                <div class="form-row">
                    <input type="text" id="firstname" name="firstname" class="form-control half-width" placeholder="Name" required value="<?php echo htmlspecialchars($first, ENT_QUOTES); ?>">
                    <input type="text" id="lastname" name="lastname" class="form-control half-width" placeholder="Surname" required value="<?php echo htmlspecialchars($last, ENT_QUOTES); ?>">
                </div>
                <div class="form-row">
                    <input type="email" id="email" name="email" class="form-control large-width" placeholder="Email" required value="<?php echo htmlspecialchars($email, ENT_QUOTES); ?>">
                </div>
                <button type="submit" class="form-button" style="display: none;">Submit</button>
            </form>
            <button id="editProfileButton" class="form-button">Modifica Informazioni</button>
            <button id="cancelButton" class="form-button cancel-button hidden">Annulla</button>
            <button id="confirmButton" class="form-button confirm-button hidden">Conferma</button>
        </div>
    </div>


    <script>
        const editProfileButton = document.getElementById('editProfileButton');
        const cancelButton = document.getElementById('cancelButton');
        const confirmButton = document.getElementById('confirmButton');
        const formControls = document.querySelectorAll('.form-control');
        const profileImage = document.getElementById('profileImage');
        const userForm = document.getElementById('userForm');

        // Salva i valori originali
        const originalValues = {};
        formControls.forEach(input => originalValues[input.id] = input.value);

        editProfileButton.addEventListener('click', function() {
            formControls.forEach(input => input.classList.add('editable'));
            formControls.forEach(input => input.removeAttribute('disabled'));

            profileImage.classList.add('editable');

            editProfileButton.classList.add('hidden');
            cancelButton.classList.remove('hidden');
            confirmButton.classList.remove('hidden');
        });

        cancelButton.addEventListener('click', function() {
            formControls.forEach(input => {
                input.value = originalValues[input.id];
                input.classList.remove('editable');
                input.setAttribute('disabled', 'true');
            });

            profileImage.classList.remove('editable');

            editProfileButton.classList.remove('hidden');
            cancelButton.classList.add('hidden');
            confirmButton.classList.add('hidden');
        });

        confirmButton.addEventListener('click', function () {
            const formData = new FormData(userForm);

            fetch('database/update_profile.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    formControls.forEach(input => originalValues[input.id] = input.value);

                    formControls.forEach(input => {
                        input.classList.remove('editable');
                        input.setAttribute('disabled', 'true');
                    });

                    profileImage.classList.remove('editable');

                    editProfileButton.classList.remove('hidden');
                    cancelButton.classList.add('hidden');
                    confirmButton.classList.add('hidden');

                    alert(data.message);
                } else {
                    alert("Errore durante l'aggiornamento: " + data.message);
                }
            })
            .catch(error => {
                console.error('Errore:', error);
                alert("Si è verificato un errore durante l'aggiornamento del profilo.");
            });

          

});

    </script>
</body>
</html>


