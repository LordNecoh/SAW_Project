document.addEventListener("DOMContentLoaded", () => {

    //    ----  Variabili  ----    //
    
    //Pannello Admin
    const toggleButton = document.getElementById("toggleAdminPanel");
    const closeButton = document.getElementById("closeAdminPanel");
    const adminPanel = document.getElementById("adminPanel");

    //Creazione Post
    const newPostForm = document.getElementById("newPostForm");

    //Caricamento Post
    const loadingTime = 1000;   //Tempo di caricamento dei post in ms

    //Ricerca Post
    const searchForm = document.getElementById("searchForm");
    const clearSearch = document.getElementById("clearSearch");

    //Caricamento Altri Post
    const blogPostsContainer = document.getElementById("blogPosts");
    let offset = 5; // Partiamo dal 5° post (i primi 5 sono già caricati nel PHP)
    const limit = 5; // Numero di post da caricare per ogni richiesta
    let loading = false; // Per prevenire richieste duplicate
    let noMorePostsMessageShown = false; // Per evitare di mostrare il messaggio "No more posts to load." più di una volta
    let searchedPosts = false; // Per evitare di caricare altri post durante una ricerca

    //Inizializzazione di TinyMCE
    tinymce.init({
        selector: '#postContent',
        plugins: 'autolink lists link image charmap preview emoticons',
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | emoticons',
    });

    //    ----  Pannello Admin  ----    //
    if(isAdmin){
        toggleButton.addEventListener("click", () => {
            adminPanel.style.display = "block";
            toggleButton.style.display = "none";
        });
    
        // Nasconde il pannello
        closeButton.addEventListener("click", () => {
            adminPanel.style.display = "none";
            toggleButton.style.display = "block";
        });
    }
    // Mostra il pannello


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

    //    ----  Ricerca Post  ----    //
    if (searchForm) {
  
        searchForm.addEventListener("submit", (e) => {
            e.preventDefault();
            searchedPosts = true;

            const formData = new FormData(searchForm);
            formData.append('action', 'searchPosts');

            fetch('database/blogActions.php', {

                method: 'POST',
                body: formData,
            })
                .then(response => response.text())
                .then(html => {
                    blogPostsContainer.innerHTML = html;
                })
                .catch(error => {
                    console.error("Unexpected error:", error);

                });

        });

    }

    if(clearSearch){
        clearSearch.addEventListener("click", () => {
            searchedPosts = false;
            searchForm.reset();
            location.reload();
        });
    }


    // Funzione per caricare i post successivi
    async function loadMorePosts() {
        if (loading || noMorePostsMessageShown || searchedPosts) return; // Preveniamo richieste multiple
        loading = true;

        const loader = document.getElementById("loaderWheel");
        loader.style.display = "block"; // Mostra il loader

        try {
                const response = await fetch(`database/loadMorePosts.php?offset=${offset}&limit=${limit}`);
                const html = await response.text();

                await new Promise(resolve => setTimeout(resolve, loadingTime)); // Simula un ritardo di caricamento

                if (html.includes("No more posts to load.")) {
                    if (!noMorePostsMessageShown) {
                        blogPostsContainer.innerHTML += '<p class="no-more-posts">No more posts to load.</p>';
                        noMorePostsMessageShown = true; // Impedisce ulteriori messaggi
                    }
                } else {
                    // Aggiungi i nuovi post
                    blogPostsContainer.innerHTML += html;
        
                    // Aggiorna l'offset
                    offset += limit;
                }
            } catch (error) {
                console.error("Unexpected error:", error);
            } finally {
                loader.style.display = "none";
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


