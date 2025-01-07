document.addEventListener("DOMContentLoaded", () => {

    const editProfileButton = document.getElementById("editProfileButton");
    const cancelButton = document.getElementById("cancelButton");
    const confirmInfoButton = document.getElementById("confirmInfoButton");
    const formControls = document.querySelectorAll(".form-control");
    const passwordFormControls = document.querySelectorAll(".pasword-form-control");

    const profileImage = document.getElementById("profileImage");
    const userForm = document.getElementById("userForm");

    const editPasswordButton = document.getElementById("editPasswordButton");
    const cancelPasswordButton = document.getElementById("cancelPasswordButton");
    const confirmPasswordButton = document.getElementById("confirmPasswordButton");
    const passwordForm = document.getElementById("passwordForm");
    const passwordUpdateForm = document.getElementById("passwordUpdateForm");

    // Salva i valori originali
    const originalValues = {};
    formControls.forEach((input) => (originalValues[input.id] = input.value));

    editProfileButton.addEventListener("click", function () {
        formControls.forEach((input) => input.classList.add("editable"));
        formControls.forEach((input) => input.removeAttribute("disabled"));

        profileImage.classList.add("editable");

        editProfileButton.classList.add("hidden");
        cancelButton.classList.remove("hidden");
        confirmInfoButton.classList.remove("hidden");
    });

    cancelButton.addEventListener("click", function () {
        formControls.forEach((input) => {
            input.value = originalValues[input.id];
            input.classList.remove("editable");
            input.setAttribute("disabled", "true");
        });

        profileImage.classList.remove("editable");

        editProfileButton.classList.remove("hidden");
        cancelButton.classList.add("hidden");
        confirmInfoButton.classList.add("hidden");
    });

    confirmInfoButton.addEventListener("click", function () {
        const formData = new FormData(userForm);

        fetch("database/update_profile.php", {
            method: "POST",
            body: formData,
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then((data) => {
                if (data.success) {
                    formControls.forEach(
                        (input) => (originalValues[input.id] = input.value)
                    );

                    formControls.forEach((input) => {
                        input.classList.remove("editable");
                        input.setAttribute("disabled", "true");
                    });

                    profileImage.classList.remove("editable");

                    editProfileButton.classList.remove("hidden");
                    cancelButton.classList.add("hidden");
                    confirmInfoButton.classList.add("hidden");

                    alert(data.message);
                } else {
                    alert("Errore durante l'aggiornamento: " + data.message);
                }
            })
            .catch((error) => {
                console.error("Errore:", error);
                alert("Si è verificato un errore durante l'aggiornamento del profilo.");
            });
    });

    editPasswordButton.addEventListener("click", function () {
        passwordForm.classList.remove("hidden");
        editPasswordButton.classList.add("hidden");

        const passwordInputs = passwordForm.querySelectorAll("input");
        passwordInputs.forEach((input) => input.removeAttribute("disabled"));
    });

    cancelPasswordButton.addEventListener("click", function () {
        passwordForm.classList.add("hidden");
        editPasswordButton.classList.remove("hidden");

        passwordUpdateForm.reset();
    });

    confirmPasswordButton.addEventListener("click", function () {
        const passwordInputs = passwordUpdateForm.querySelectorAll("input");
        passwordInputs.forEach((input) => input.removeAttribute("disabled")); // Abilita gli input

        const formData = new FormData(passwordUpdateForm);

        fetch("database/update_password.php", {
            method: "POST",
            body: formData,
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then((data) => {
                if (data.success) {
                    alert(data.message);
                    passwordForm.classList.add("hidden");
                    editPasswordButton.classList.remove("hidden");
                    passwordUpdateForm.reset();
                } else {
                    alert("Errore durante l'aggiornamento: " + data.message);
                }
            })
            .catch((error) => {
                console.error("Errore:", error);
                alert(
                    "Si è verificato un errore durante l'aggiornamento della password."
                );
            });
    });
});
