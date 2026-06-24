console.log("Main.js loaded");
$(document).ready(function() {
  console.log("jQuery ready");
});
$(function(){
    let currentView = 'grid';
    let currentPage = 1;
    let perPage = 9;
    let currentCategory = 'all';
    let searchTerm = '';

    function loadCategories(){
        $.post('ajax/fetch_categories.php', {}, function(data){
            $('#categoryButtons').html(data);

            // Always add popular
            if($('#categoryButtons .category-btn[data-category="popular"]').length === 0){
                $('#categoryButtons').append('<button class="btn btn-outline-warning me-1 mb-1 category-btn" data-category="popular">popular</button>');
                
            }

            highlightCategory(currentCategory);
        });
    }

    function highlightCategory(cat){
        $('.category-btn').each(function(){
            const c = $(this).data('category').toLowerCase();
            if(c === 'popular'){
                $(this).removeClass('btn-primary').addClass('btn-outline-warning');
            } else {
                $(this).removeClass('btn-primary btn-outline-warning').addClass('btn-outline-primary');
            }
        });
        $(`.category-btn[data-category="${cat}"]`).removeClass('btn-outline-primary btn-outline-warning').addClass('btn-primary');
    }

    function loadApps(page=1){
        currentPage = page;
        $.post('ajax/fetch_apps.php', {
            page: page,
            per_page: perPage,
            view: currentView,
            category: currentCategory,
            search: searchTerm
        }, function(resp){
            $('#appContainer').html(resp.html);
            renderPagination(resp.total_pages, page);
        }, 'json');
    }

    function renderPagination(totalPages, current){
        if(totalPages <= 1){ $('#pagination').html(''); return; }
        let html = `<li class="page-item ${current<=1?'disabled':''}"><a class="page-link" href="#" data-page="${current-1}">Previous</a></li>`;
        for(let p=1;p<=totalPages;p++){
            html += `<li class="page-item ${p===current?'active':''}"><a class="page-link" href="#" data-page="${p}">${p}</a></li>`;
        }
        html += `<li class="page-item ${current>=totalPages?'disabled':''}"><a class="page-link" href="#" data-page="${current+1}">Next</a></li>`;
        $('#pagination').html(html);
    }

    // Toggle view
    $('#toggleView').click(function(){
        currentView = (currentView==='grid')? 'list':'grid';
        $(this).text(currentView==='grid' ? 'List View' : 'Grid View');
        loadApps(1);
    });

    // Search
    $('#searchBox').on('input', function(){
        searchTerm = $(this).val();
        loadApps(1);
    });

    // Category click
    $(document).on('click', '.category-btn', function(){
        currentCategory = $(this).data('category').toLowerCase();
        highlightCategory(currentCategory);
        loadApps(1);
    });

    // Wishlist category click
   $(document).on('click', '.category-btn[data-category="wishlist"]', function(){
    window.location.href = 'admin/login.php?redirect=wishlist';
});








    
    // ✅ Add Wishlist button click here
    // $(document).on('click', '.category-btn[data-category="wishlist"]', function(){
    //     // Open the wishlist modal
    //     new bootstrap.Modal(document.getElementById('wishlistModal')).show();
    // });

    // Wishlist form submit
   $('#wishlistForm').submit(function(e){
    e.preventDefault();
    console.log('Wishlist submit clicked'); // Debug
    const title = $('#wishlistTitle').val();
    const description = $('#wishlistDesc').val();
    console.log({title, description}); // Debug
    $.post('ajax/wishlist_submit.php', {title: title, description: description}, function(resp){
        console.log(resp); // Debug
        if(resp.status === 'success'){
            alert('Wishlist submitted successfully!');
            $('#wishlistForm')[0].reset();
            bootstrap.Modal.getInstance(document.getElementById('wishlistModal')).hide();
        } else {
            alert(resp.message || 'Error submitting wishlist');
        }
    }, 'json');
});





    // Pagination
    $(document).on('click', '#pagination .page-link', function(e){
        e.preventDefault();
        const p = parseInt($(this).data('page')) || 1;
        if(!$(this).parent().hasClass('disabled') && !$(this).parent().hasClass('active')) loadApps(p);
    });

    // Read more modal
$(document).on('click', '.read-more', function(){
    let id = $(this).data('id');
    $.ajax({
        url: 'get_app_details.php',
        type: 'POST',
        data: { id: id },
        success: function(response){
            let app = JSON.parse(response);
            $('#appTitle').text(app.name);
            $('#appLongDesc').html(app.long_description);
            $('#appPrice').text(app.price);
            $('#appImage').attr('src', app.image);

            // Existing Launch App links
            $('#userAppLink').attr('href', app.user_app_url);

            // ✅ Add this condition:
            if(app.admin_app_url && app.admin_app_url.trim() !== ""){
                $('#adminAppLink').show().attr('href', app.admin_app_url);
            } else {
                $('#adminAppLink').hide();
            }
            let phoneNumber = "919442719940"; // ← replace with your WhatsApp number
            let message = `Hello, I am interested in the app: ${app.name}. Please share more details.`;
            let whatsappURL = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;

            $('#whatsappBtn').attr('href', whatsappURL);

            

            new bootstrap.Modal(document.getElementById('appModal')).show();
        }
    });
});

    // popular toggle
   // popular toggle
$(document).on('click', '.popular-btn', function(){
       console.log("Heart clicked!");

    console.log('popular button clicked');  // << check this
    const btn = $(this);
    const appId = btn.data('appid');
    const action = btn.hasClass('btn-danger') ? 'remove' : 'add';

    $.post('ajax/popular.php', { app_id: appId, action: action }, function(resp){
        if(resp.status === 'success'){
            // Toggle heart class
            btn.toggleClass('btn-danger btn-outline-danger');

            // If currently viewing popular, reload apps so removed app disappears
            if(currentCategory === 'popular') {
                loadApps(currentPage);
            }
        } else {
            alert(resp.message || 'Error updating popular');
        }
    }, 'json');
});




    // Initial load
    loadCategories();
    loadApps();
});
