document.addEventListener("DOMContentLoaded", () => {

    //    ----  Variabili  ----    //
    const editProfileBtn = document.getElementById("editProfile");
    const cancelEditBtn = document.getElementById("cancelEdit");
    const saveProfileBtn = document.getElementById("saveProfile");
    const formInputs = document.querySelectorAll("#userForm input");

    const editPasswordBtn = document.getElementById("editPassword");
    const cancelPasswordBtn = document.getElementById("cancelPassword");
    const savePasswordBtn = document.getElementById("savePassword");
    const passwordForm = document.getElementById("passwordForm");

    const originalValues = Object.fromEntries(
        Array.from(formInputs).map((input) => [input.id, input.value])
    );

    formInputs.forEach((input) => input.setAttribute("disabled", "true"));

    const toggleEditable = (editable) => {
        formInputs.forEach((input) => {
            input.disabled = !editable;
            input.classList.toggle("editable", editable);
        });
        editProfileBtn.classList.toggle("hidden", editable);
        cancelEditBtn.classList.toggle("hidden", !editable);
        saveProfileBtn.classList.toggle("hidden", !editable);
    };

    //    ----  Event Listeners  ----    //

    editProfileBtn.addEventListener("click", () => toggleEditable(true));

    cancelEditBtn.addEventListener("click", () => {
        formInputs.forEach((input) => (input.value = originalValues[input.id]));
        toggleEditable(false);
    });

    saveProfileBtn.addEventListener("click", () => {
        const formData = new FormData(document.getElementById("userForm"));
        fetch("database/update_profile.php", {
            method: "POST",
            body: formData
        })
            .then((res) => res.json())
            .then((data) => {
                if (data.success) {
                    formInputs.forEach((input) => {
                        originalValues[input.id] = input.value;
                    });
                    toggleEditable(false);
                    alert(data.message);
                } else {
                    alert(`Error: ${data.message}`);
                }
            })
            .catch(() => alert("An error occurred while updating the profile."));
    });

    editPasswordBtn.addEventListener("click", () => {
        passwordForm.classList.remove("hidden");
        editPasswordBtn.classList.add("hidden");
    });

    cancelPasswordBtn.addEventListener("click", () => {
        passwordForm.reset();
        passwordForm.classList.add("hidden");
        editPasswordBtn.classList.remove("hidden");
    });

    savePasswordBtn.addEventListener("click", () => {
        const newPassword = document.getElementById("newPassword").value;
        const confirmPassword = document.getElementById("confirmPassword").value;

        if (!newPassword || !confirmPassword) {
            alert("Both password fields are required.");
            return;
        }

        if (newPassword !== confirmPassword) {
            alert("Passwords do not match.");
            return;
        }

        const formData = new FormData(document.getElementById("passwordForm"));
        fetch("database/update_password.php", {
            method: "POST",
            body: formData,
        })
            .then((res) => res.json())
            .then((data) => {
                if (data.success) {
                    alert(data.message);
                    passwordForm.reset();
                    passwordForm.classList.add("hidden");
                    editPasswordBtn.classList.remove("hidden");
                } else {
                    alert(`Error: ${data.message}`);
                }
            })
            .catch(() => alert("An error occurred while updating the password."));
    });
});
