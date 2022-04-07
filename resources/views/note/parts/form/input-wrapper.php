<?php if
( $field["hide"]!="form" && $field["hide"]!="both")
//  &&!( $field["hide"]=="form_create"&& $id=="")
{
    ?>
<div class="form-group mb-3">
    <?php
    if ($field["subtype"] =="tree")$fieldtype = "select-tree";
    else $fieldtype=$field["type"];


    include( base_path('resources/views/' ). 'note/parts/form/' . $fieldtype . '.php'); ?>

</div>
<?php } ?>
