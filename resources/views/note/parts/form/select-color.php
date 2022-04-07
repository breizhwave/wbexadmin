<label class="form-label" for name="wTitle"><?=$field["title"]?></label>
<select  name="<?=$field["name"]?>" id="waveInput<?=ucfirst($field["name"]) . ucfirst($fieldPrefix)?>"  >

</select>
<script>
var select = new SlimSelect({
select: '#waveInput<?=ucfirst($field["name"]). ucfirst($fieldPrefix)?>',
//valuesUseText: false, // Use text instead of innerHTML for selected values - default false
    showSearch: false,  allowDeselect: true,
    placeholder: 'Search for the good stuff!',
value:"",
    data: [
   {innerHTML: '', text:"", value: "" },

    <?php foreach ($arrFields[strval($field["name"])]["rTableRecords"] as $k=>$v)
    { $bgcolor="";
//    if ($arrFields[strval($field["name"])]["subtype"] =="rColor")
//        $bgcolor=$n->{$field["relation"] . "_color"};

        $bgcolor=$v->color;
        $bgcolorhtml='<span class="align-middle colorSquare" style="background:' . $bgcolor . '"></span>';
    ?>
    {innerHTML: '<div><?=$bgcolorhtml . $v->title?></div>', text:"<?=$v->title?>", value: "<?=$v->id?>" },

    <?php
    }?>

]
})
 </script>
