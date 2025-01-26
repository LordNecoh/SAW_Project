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


    const blogPostsContainer = document.getElementById("blogPosts");
    let offset = 5; // Partiamo dal 5° post (i primi 5 sono già caricati nel PHP)
    const limit = 5; // Numero di post da caricare per ogni richiesta
    let loading = false; // Per prevenire richieste duplicate

    // Funzione per caricare i post successivi
    async function loadMorePosts() {
        if (loading) return; // Preveniamo richieste multiple
        loading = true;

        try {
            //Debug
            console.log(`Fetching: database/loadMorePosts.php?offset=${offset}&limit=${limit}`); 
            const response = await fetch(`database/loadMorePosts.php?offset=${offset}&limit=${limit}`);
            //Debug
            console.log("Raw response:", response);
            const data = await response.json();
            //Debug
            console.log("Parsed data:", data.posts);

            if (data.success) {
                data.posts.forEach(post => {
                    const postDiv = document.createElement('div');
                    postDiv.classList.add('post');
                    postDiv.innerHTML = `
                        <h3>${post.title}</h3>
                        <div>${post.content}</div>
                        <small>Posted by ${post.creator} on ${post.created_at}</small>
                    `;
                    blogPostsContainer.appendChild(postDiv);
                });

                offset += limit; // Aggiorna l'offset
            } else {
                console.error("Error loading posts:", data.error);
            }
        } catch (error) {
            console.error("Unexpected error:", error);
        } finally {
            loading = false;
        }
    }

    // Rileva lo scroll vicino al fondo della pagina
    window.addEventListener("scroll", () => {
        const scrollPosition = window.innerHeight + window.scrollY;
        const bottomPosition = document.body.offsetHeight - 100;

        if (scrollPosition >= bottomPosition) {
            loadMorePosts();
        }
    });
});


