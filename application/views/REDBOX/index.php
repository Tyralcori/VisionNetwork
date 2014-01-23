<!-- Side Menu -->
{include "REDBOX/ELEMENTS/sidebar.php"}
<!-- Side Menu END -->

<!-- DASH Menu -->
{include "REDBOX/ELEMENTS/dashboard.php"}
<!-- DASH Menu END -->

<!-- Views -->
{include "REDBOX/ELEMENTS/views.php"}
<!-- Views -->

<!-- Visitors -->
{include "REDBOX/ELEMENTS/visitors.php"}
<!-- Visitors -->

<!-- Tickets / Bugs -->
{include "REDBOX/ELEMENTS/tracker.php"}
<!-- Tickets / Bugs -->

<!-- Useragent -->
{include "REDBOX/ELEMENTS/useragent.php"}
<!-- Useragent -->

<!-- Logs -->
{include "REDBOX/ELEMENTS/logs.php"}
<!-- Logs -->

<!-- Soon -->
{include "REDBOX/ELEMENTS/soon.php"}
<!-- Soon -->

<!-- Useragent -->
{include "REDBOX/ELEMENTS/useragent.php"}
<!-- Useragent -->



<!-- FOOT SCRIPT -->
<script>
    $("#menu-close").click(function(e) {
        e.preventDefault();
        $("#sidebar-wrapper").toggleClass("active");
    });
</script>
<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#sidebar-wrapper").toggleClass("active");
    });
</script>
<script>
    $(function() {
        // Whyever this fix the bug..
        window.scrollTo(0,0);
        
        // Scroll allow
        $('a[href*=#]:not([href=#])').click(function() {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '')
                    || location.hostname == this.hostname) {

                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html,body').animate({
                        scrollTop: target.offset().top
                    }, 1000);
                    return false;
                }
            }
        });
    });
</script>
<!-- FOOT SCRIPT END -->