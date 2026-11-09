    <script src="<?php echo BASE_URL; ?>/dist/js/jquery-3.6.3.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/dist/js/feather.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/dist/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/dist/js/dataTables.bootstrap5.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/dist/tinymce/tinymce.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/dist/js/custom.js"></script>

    <script src="<?php echo BASE_URL; ?>/dist/js/chart.min.js"></script>
    <script>
        // Graphs
        const ctx = document.getElementById('myChart');
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'May',
                    'Jun',
                    'Jul',
                    'Aug',
                    'Sep',
                    'Oct',
                    'Nov',
                    'Dec'
                ],
                datasets: [{
                    data: [
                        1237,
                        1002,
                        1343,
                        1557,
                        1142,
                        1134,
                        1190,
                        1512,
                        889,
                        1606,
                        1370,
                        1275
                    ],
                    lineTension: 0,
                    backgroundColor: 'transparent',
                    borderColor: '#007bff',
                    borderWidth: 4,
                    pointStyle: 'circle',
                    pointBackgroundColor: '#007bff',
                }]
            },
            options: {
                responsive: true,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            callback: function (value, index, values) {
                                return '$' + value;
                            }
                        }
                    }]
                },
                legend: {
                    display: false
                }
            }
        });
    </script>

    <?php

        if(isset($_SESSION['success'])) {
            echo '<script>
                    iziToast.success({ 
                        message: "' . $_SESSION['success'] . '", 
                        position: "topRight"
                    });
                </script>';
            unset($_SESSION['success']);
        }

        if(isset($_SESSION['error'])) {
            echo '<script>
                    iziToast.error({ 
                        message: "' . $_SESSION['error'] . '", 
                        position: "topRight"
                    });
                </script>';
            unset($_SESSION['error']);
        }

    ?>

</body>

</html>