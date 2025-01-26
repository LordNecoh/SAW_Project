document.addEventListener("DOMContentLoaded", () => {

    //    ----  Variabili  ----    //
    
    //Pannello Admin
    const toggleButton = document.getElementById("toggleAdminPanel");
    const closeButton = document.getElementById("closeAdminPanel");
    const adminPanel = document.getElementById("adminPanel");

    //Creazione Post
    const newPostForm = document.getElementById("newPostForm");

    //Inizializzazione di TinyMCE
    tinymce.init({
        selector: '#postContent',
        plugins: 'autolink lists link image charmap preview',
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent',
    });

    //    ----  Pannello Admin  ----    //

    // Mostra il pannello
    toggleButton.addEventListener("click", () => {
        adminPanel.style.display = "block";
        toggleButton.style.display = "none";
    });

    // Nasconde il pannello
    closeButton.addEventListener("click", () => {
        adminPanel.style.display = "none";
        toggleButton.style.display = "block";
    });

    //    ----  Creazione Post  ----    //
    

    if (newPostForm) {
        newPostForm.addEventListener("submit", (e) => {
            e.preventDefault();

            const formData = new FormData(newPostForm);
            formData.append('action', 'createPost');
            formData.append('content', tinymce.get('postContent').getContent());

            fetch('database/blogActions.php', {
                method: 'POST',
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Post published successfully!");
                        location.reload();
                    } else {
                        alert("Error: " + data.error);
                    }
                })
                .catch(error => {
                    console.error("Unexpected error:", error);
                });
        });
    }
});
