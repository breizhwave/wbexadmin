<div class="d-none" >
    <form name="waveMainFrm" id="idWaveMainFrm" data-table="<?=$xmlTable["name"]?>">



        <?php


        /// START TABS
        $cTabs=0;
        foreach($xmlTable->d_tabs  as $tabs)
        {
            ?><div class="card"   >
            <ul class="nav nav-tabs" data-bs-toggle="tabs">


            <?php

           foreach($tabs as $v=> $tab ) {?>    <li class="nav-item">
               <a href="#UNIQUEtabs<?=$cTabs++?>" class="nav-link <?=$cTabs==1?"active":""?>" data-bs-toggle="tab"><?=strval($tab["title"])?></a>
           </li>

           <?php }

           ?></ul> <?php
        }
            /// END TABS

            /// FORM without tabs

                    if ($cTabs==0)
                        foreach($xmlTable->d_field  as $field)
                                 include( base_path('resources/views/' ). 'note/parts/form/input-wrapper.php');
          /// FORM with tabs
      if ($cTabs>0)
      {
          $tab="";     $cTabs=0;
          ?><div class="card-body">
                <div class="tab-content" >
                    <?php
                    foreach($xmlTable->d_tabs  as $tabs)
                        foreach($tabs as $v=> $tab )
                    {
                        ?>
                    <div class="tab-pane <?=$cTabs==0?"active show":""?> "      id="UNIQUEtabs<?=$cTabs++?>">
                        <?php
                        foreach($xmlTable->d_field  as $field)
                           if (strval($field["tab"])==strval($tab["title"])) include( base_path('resources/views/' ). 'note/parts/form/input-wrapper.php');
                        ?>
                    </div>

                        <?php
                    }?>
                </div>
            </div> </div>
            <?php
      }
?>
    </form>

</div>
