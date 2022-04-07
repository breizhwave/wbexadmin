
<?php include( base_path('resources/views/' ). 'note/includes/header.php'); ?>


        <div class="page-body">
            <?php $fieldPrefix="";include( base_path('resources/views/' ). 'note/parts/form.php'); ?>
            <div class="container-xl  ">
<div class="col card  text-right">
    <div class="card-header">
        <div class="container"><div class="row justify-content-between">
        <div class="col-1"><?=$title?></div>
        <div class="col-1">
        <button  class="btn btnWaveAddRecord " role="button" >
            <svg fill="#000000" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 128 128" width="24px" height="24px">    <path d="M 64 6.0507812 C 49.15 6.0507812 34.3 11.7 23 23 C 0.4 45.6 0.4 82.4 23 105 C 34.3 116.3 49.2 122 64 122 C 78.8 122 93.7 116.3 105 105 C 127.6 82.4 127.6 45.6 105 23 C 93.7 11.7 78.85 6.0507812 64 6.0507812 z M 64 12 C 77.3 12 90.600781 17.099219 100.80078 27.199219 C 121.00078 47.499219 121.00078 80.500781 100.80078 100.80078 C 80.500781 121.10078 47.500781 121.10078 27.300781 100.80078 C 7.0007813 80.500781 6.9992188 47.499219 27.199219 27.199219 C 37.399219 17.099219 50.7 12 64 12 z M 64 42 C 62.3 42 61 43.3 61 45 L 61 61 L 45 61 C 43.3 61 42 62.3 42 64 C 42 65.7 43.3 67 45 67 L 61 67 L 61 83 C 61 84.7 62.3 86 64 86 C 65.7 86 67 84.7 67 83 L 67 67 L 83 67 C 84.7 67 86 65.7 86 64 C 86 62.3 84.7 61 83 61 L 67 61 L 67 45 C 67 43.3 65.7 42 64 42 z"/></svg>&nbsp;Ajouter</button></div>
        </div>


       </div>
    </div>



    <div class="waveMainGrid">
                <?php //include( base_path('resources/views/' ). 'note/parts/list.php'); ?>
</div>
</div>



                <script>
                    $( document ).ready(function() {
                        jQuery.waveDisplayList("<?=$xmlTable["name"]?>", true, false, <?php echo json_encode( $requestAll) ?> )
                    });

                </script>
            </div>

            <div class="spinner spinner-grow text-warning d-none" style="width: 3rem; height: 3rem;" role="status"><span class="sr-only">Loading...</span></div>
                <?php include( base_path('resources/views/' ). 'note/includes/footer.php');?>


