document.addEventListener("DOMContentLoaded", () => {

    //    ----  Variabili  ----    //
    
    //Pannello Admin
    const toggleButton = document.getElementById("toggleAdminPanel");
    const closeButton = document.getElementById("closeAdminPanel");
    const adminPanel = document.getElementById("adminPanel");
    let deletePostButtons = document.getElementsByClassName("deletePost");

    //Creazione Post
    const newPostForm = document.getElementById("newPostForm");

    //Caricamento Post
    const loadingTime = 1000;   //Tempo di caricamento dei post in ms

    //Ricerca Post
    const searchForm = document.getElementById("searchForm");
    const clearSearch = document.getElementById("clearSearch");
    let searchedPosts = false; // Per evitare di caricare altri post durante una ricerca

    //Caricamento Altri Post
    const blogPostsContainer = document.getElementById("blogPosts");
    let offset = 5; // Partiamo dal 5° post (i primi 5 sono già caricati nel PHP)
    const limit = 5; // Numero di post da caricare per ogni richiesta
    let loading = false; // Per prevenire richieste duplicate
    let noMorePostsMessageShown = false; // Per evitare di mostrare il messaggio "No more posts to load." più di una volta

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
    
        closeButton.addEventListener("click", () => {
            adminPanel.style.display = "none";
            toggleButton.style.display = "block";
        });

    }

    document.addEventListener("click", (e) => {
        if (e.target.classList.contains("deletePost")) {
            const postId = e.target.getAttribute("id");

    
            if (confirm(`Are you sure you want to delete the post "${postId}"?`)) {
                const formData = new FormData();
                formData.append('action', 'deletePost');
                formData.append('id', postId);
    
                fetch('database/blogActions.php', {
                    method: 'POST',
                    body: formData,
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("Post deleted successfully!");
                            location.reload();
                        } else {
                            alert("Error: " + data.error);
                        }
                    })
                    .catch(error => {
                        console.error("Unexpected error:", error);
                    });
            }
        }
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

    //    ----  Ricerca Post  ----    //
    if (searchForm) {
  
        searchForm.addEventListener("submit", (e) => {
            e.preventDefault();
            searchedPosts = true;
            clearSearch.style.display = "flex";

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
            clearSearch.style.display = "none";
            location.reload();
        });
    }


    // Funzione per caricare i post successivi
    async function loadMorePosts() {
        if (loading || noMorePostsMessageShown || searchedPosts) return; //Prevenzione richieste multiple
        loading = true;

        const loader = document.getElementById("loaderWheel");
        loader.style.display = "block"; 

        try {
                const response = await fetch(`database/loadMorePosts.php?offset=${offset}&limit=${limit}`, {
                    method: 'POST'
                }
                );
                const html = await response.text();

                await new Promise(resolve => setTimeout(resolve, loadingTime)); //Caricamento simulato per evidenziare l'infinte scroll

                if (html.includes("No more posts to load.")) {
                    if (!noMorePostsMessageShown) {
                        blogPostsContainer.innerHTML += '<p class="no-more-posts">No more posts to load.</p>';
                        noMorePostsMessageShown = true; 
                    }
                } else {
                    blogPostsContainer.innerHTML += html;
        
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


