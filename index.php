    <!-- require start  -->
    <?php include("includes/require.php") ?>
    <!-- require end  -->


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <!-- meta start  -->
        <?php include("includes/meta.php") ?>
        <!-- meta end  -->
        <!-- link start  -->
        <?php include("includes/link.php") ?>
        <!-- link end  -->
        <!-- website title  -->
        <title><?php if($website_name==""){ echo "Website Title";} else{ echo $website_name;} ?></title>
    </head>

    <body>
        <!-- header start  -->
        <?php include("includes/header.php") ?>
        <!-- header end  -->
        <!-- main start  -->
        <main class="px-2 py-3">
            <div class="d-flex flex-wrap justify-content-center align-items-center gap-4" id="food-data">
               <!-- data from database and live data result  -->
            </div>
        </main>
        <!-- main end  -->
        <!-- footer start  -->
        <?php include("includes/footer.php") ?>
        <!-- footer end  -->
        <!-- script start  -->
        <?php include("includes/script.php") ?>
        <!-- script end  -->
        <!-- internal script start  -->
        <script>
        // jquery ready start 
        $(document).ready(function() {
            // load data ajax code start
            function loaddata() {
                $.ajax({
                    url: "indexdata.php",
                    type: "POST",
                    success: function(data) {
                        $('#food-data').html(data);
                    }
                });
            }

            loaddata();

            // load live search data ajax code start
            $("#search").on("keyup", function() {
                let liveData = $("#search").val();
                $.ajax({
                    url: "indexlivedata.php",
                    type: "POST",
                    data: {
                        live: liveData
                    },
                    success: function(data) {
                        $('#food-data').html(data);
                    }
                });
            });

            // add to cart ajax code start 
            $(document).on("click",
                ".addedtocart",
                function(e) {
                    e.preventDefault();
                    let foodItem = $(this).data("fooditem");
                    $.ajax({
                        url: "cartadd.php",
                        type: "POST",
                        data: {
                            item: foodItem
                        },
                        success: function(data) {
                            if (data == 1) {
                                Swal.fire({
                                    title: "Food is added to your cart",
                                    text: "Thanks for buying",
                                    icon: "success"
                                });
                            } else if (data == 2) {
                                Swal.fire({
                                    title: "Food is already added to your cart",
                                    text: "Thanks for buying",
                                    icon: "success"
                                });
                            }
                        }

                    });
                });
        });
        </script>
        <!-- internal script end  -->

    </body>

    </html>