<!-- Side Menu -->
{include "ELEMENTS/sidebar.php"}
<!-- Side Menu END -->

<!-- Welcome Layer -->
{include "ELEMENTS/welcomeLayer.php"}
<!-- Welcome Layer END -->

<!-- Login -->
{include "ELEMENTS/login.php"}
<!-- Login END -->

<!-- New Account -->
{include "ELEMENTS/newAccount.php"}
<!-- New Account END -->

<!-- Roadmap -->
{include "ELEMENTS/roadmap.php"}
<!-- Roadmap END -->

<!-- WHY Vision Network -->
{include "ELEMENTS/whyVN.php"}
<!-- WHY Vision Network END -->

<!-- Service -->
{include "ELEMENTS/service.php"}
<!-- Service END -->

<!-- Vision Network Team -->
{include "ELEMENTS/team.php"}
<!-- Vision Network Team END -->

<!-- Download -->
{include "ELEMENTS/download.php"}
<!-- Download END -->

<!-- Contact -->
{include "ELEMENTS/contact.php"}
<!-- Contact END -->


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