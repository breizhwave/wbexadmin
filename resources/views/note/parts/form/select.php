<label class="form-label" for name="wTitle"><?=$field["title"]?></label>
<select  name="<?=$field["name"]?>" id="waveInput<?=ucfirst($field["name"]). ucfirst($fieldPrefix)?>" class="form-select" >
    <option  > </option>
<?php
$hasParents=false;
foreach ($arrFields[strval($field["name"])]["rTableRecords"] as $k=>$v)
    {
        ?>
        <option value="<?=$v->id?>"  ><?=$v->title?></option>
    <?php
    }?>
</select>

