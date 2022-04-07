<label class="form-label" for name="wTitle"><?=$field["title"]?></label>
<input type="text" name="<?=$field["name"]?>" id="waveInput<?=ucfirst($field["name"])?>" value="" class="waveInput<?=ucfirst( $field["subtype"])?> form-control"

<?php if ($field["subtype"]=="color") echo  "data-coloris"?>
/>
