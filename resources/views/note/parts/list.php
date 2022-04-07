<form name="frmFilter" class="waveFrmFilter" method="POST"><table class="waveGridTable table table-striped table-hover " data-table="<?=$xmlTable["name"]?>">

    <?php if ($arrQueryParms['withHeaders']=="true") include( base_path('resources/views/' ). 'note/parts/list-header.php'); ?>
    <tbody>
    <?php if (count($xmlTable->d_aggregate )) {?>
    <tr><td colspan="100" class="bg-dark">
            <div class="row justify-content-between waveAggregates">
                <?php
                //        echo "<pre>" ;  print_r($xmlTable); echo "</pre>" ;
                //      echo "<pre>" ;  print_r($aggregatesRecords); echo "</pre>" ;
                foreach($xmlTable->d_aggregate   as $aggregate)
                {
                    $aggregatealias=$aggregate["function"] . "_" . $xmlTable["name"] . "_" . $aggregate["name"];

                    echo "<div class='col'>" .  $aggregate["name"] . "  " . $aggregatesRecords[0]->$aggregatealias ;

                    echo "</div>";
                }
                ?></div>
        </td></tr><?php } ?>

<?php foreach($records as $n)
{?>
    <tr class="  waverecord "  data-id="<?=$n->id?>">

        <td  >

            <span class="btn delete icon-item">
               <svg xmlns="http://www.w3.org/2000/svg"  width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <line x1="4" y1="7" x2="20" y2="7"></line>
                        <line x1="10" y1="11" x2="10" y2="17"></line>
                        <line x1="14" y1="11" x2="14" y2="17"></line>
                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
               </svg> </span></td><td>
            <span class="btn edit icon-item">
            <svg xmlns="http://www.w3.org/2000/svg" class=" icon-tabler icon-tabler-pencil" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4"></path>
   <line x1="13.5" y1="6.5" x2="17.5" y2="10.5"></line>
</svg></span>
        </td>

        <td> <span class="btn duplicate  ">
            <svg xmlns="http://www.w3.org/2000/svg" class="  icon-tabler icon-tabler-copy" width="16" height="16" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <rect x="8" y="8" width="12" height="12" rx="2" />
                <path d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2" />
            </svg>
            </span>
        </td>


       <?php foreach($xmlTable->d_field  as $field)
           if ( $field["hide"]!="list"&& $field["hide"]!="both") {
        ?><td class="align-middle"  >
                   <?php
        $bgcolor="";
        if ($arrFields[strval($field["name"])]["subtype"] =="rColor")
               $bgcolor=$n->{  $field["relation"] . "_color"};
        if ($field["subtype"]=="color")
            $bgcolor=$n->{$xmlTable["name"] . "_" .  $field["name"]};

        if ($bgcolor!="")
            {
              ?>  <span class="align-middle colorSquare" style="background:<?=$bgcolor?>"></span><?php
            }



        if ($field["tooltip"] ) {
            $tooltipHtml =  $n->{$xmlTable["name"] . "_" . $field["tooltip"]};
            $tooltip = 'data-bs-toggle="tooltip" data-bs-html="true" title="' .htmlentities($tooltipHtml) . '"';
        }
        else $tooltip="";
?><span class="align-middle" <?=$tooltip?>><?php
        if ( $field["type"] =="select")
          {
              echo $n->{$field["relation"] . "_title"};
          }
            else
                echo $n->{ $xmlTable["name"] . "_" . $field["name"]}?></span>   </td>
        <?php
        }?></tr>
    <?php
}
?></tbody></table></form>
<?php   if ($arrQueryParms['withHeaders']=="true")
{?>
<script>



        $( document ).ready(function() {
        /// SORT ORDER ARROW
        <?php

            $arrOrder=explode(".",$arrQueryParms['order']);
            ?>
        $(".waveGridTable th[data-field='<?=  $arrOrder[1] ?>'] .waveSortArrow[data-orderdirection='<?=  $arrQueryParms['orderDir'] ?>']").addClass("active");


    });

</script>




    <?php
}
?>
