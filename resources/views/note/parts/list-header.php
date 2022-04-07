<thead><tr class="waveGridHeader"><th colspan="3" class="align-top"  >
 <div class="btn filter icon-item">
        <svg xmlns="http://www.w3.org/2000/svg" class="  icon-tabler icon-tabler-filter" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M5.5 5h13a1 1 0 0 1 .5 1.5l-5 5.5l0 7l-4 -3l0 -4l-5 -5.5a1 1 0 0 1 .5 -1.5"></path>
        </svg></div>
    </th><?php
    foreach($xmlTable->d_field  as $field)
        if ( $field["hide"]!="list"&& $field["hide"]!="both"){
        ?><th data-field="<?=$field["name"]?>"  class="field_header align-middle">
     <span  >  <?=$field["title"]?>
        <div class="waveSort">
            <div class="waveSortArrow up" data-orderdirection="asc">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-up" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <line x1="12" y1="5" x2="12" y2="19" />
                    <line x1="16" y1="9" x2="12" y2="5" />
                    <line x1="8" y1="9" x2="12" y2="5" />
                </svg>
            </div>
            <div class="waveSortArrow down" data-orderdirection="desc">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-down" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <line x1="12" y1="5" x2="12" y2="19" />
                    <line x1="16" y1="15" x2="12" y2="19" />
                    <line x1="8" y1="15" x2="12" y2="19" />
                </svg>

            </div>
        </div></span>




        </th>
        <?php
    }?></tr>
<tr class="filter  "><th colspan="3"></th>


 <?php
    foreach($xmlTable->d_field  as $field)
 if ( $field["hide"]!="list"&& $field["hide"]!="both") {
?><th><?php
        $searchtype = $field["type"];
        if ($searchtype == "textarea") $searchtype = "input";
     if ($arrFields[strval($field["name"])]["subtype"] =="rColor")$searchtype = "select-color";
     if ($arrFields[strval($field["name"])]["subtype"] =="tree")$searchtype = "select-tree";
     $fieldPrefix="header";



         include(base_path('resources/views/') . 'note/parts/form/' . $searchtype . '.php');
        ?> </th><?php
    }?>
</tr>


</thead>
