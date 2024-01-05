<!-- jQuery library link -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<!-- bootstrap js link  -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js">
</script>
<!-- sweet alert js link  -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- datatables net  -->
<script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<!-- external js link  -->
<script type="text/javascript" src="externals/js/script.js"></script>
<!-- internal js link  -->
<script>
// writting messages in console 
const consoleStyle =
    'background-image:linear-gradient(to bottom right , #00827f, #90ee90); color:#eee; padding:50px; border-radius:7px; font-size:1.2rem; ';
console.log("%c <?php echo $website_name; ?>", consoleStyle);
// localstorage store 
localStorage.setItem("website-name", "<?php echo $website_name; ?>");
// window internet offline 
window.onoffline=()=>{
    window.location.href="offline";
}
</script>