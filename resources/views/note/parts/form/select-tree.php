<label class="form-label" for name="wTitle"><?=$field["title"]?></label>
<select  name="<?=$field["name"]?>" id="waveInput<?=ucfirst($field["name"]). ucfirst($fieldPrefix)?>" class="form-select select-parents" >
    <option  > </option>
<?php
$hasParents=false;
if (! function_exists("options") ) {
    function options($arrFields, $field, $parent_id = '', $level = 1)
    {
        $str = "";
        foreach ($arrFields[strval($field["name"])]["rTableRecords"] as $k => $v) {
            {

                if ($v->parent_id == $parent_id) {
                    $subOptions = options($arrFields, $field, $v->id, $level + 1);

                    $str .= '<option value="' . $v->id . '"';
                    if (isset($v->parent_id))
                        $str .= 'data-pup="' . $v->parent_id . '" ';
                    $str .= 'class="l' . $level;
                    if ($subOptions == "")
                        $str .= " ";
                    else $str .= " non-leaf ";
                    $str .= ' ">' . $v->title . '</option>' . $subOptions;


                }
            }
        }
        return $str;
    }
}
echo options($arrFields,$field);
?>
</select>


    <script>
        $( document ).ready(function() {
            //console.log("select parent <?//=ucfirst($field["name"]) . ucfirst($fieldPrefix)?>//")
            $("#waveInput<?=ucfirst($field["name"]) . ucfirst($fieldPrefix)?>").select2ToTree();
            $( document ).on( "waveOpenModal", function() {
                    console.log("waveopenmodal");
                    //$("#dynamicWaveMainFrm #waveInput<?//=ucfirst($field["name"]) . ucfirst($fieldPrefix)?>//").select2ToTree(
                    //    {
                    //        dropdownParent: $('.modal .modal-content')
                    //    }
                    //
                    //);}
                    $('#waveModal .select-parents').each(function () {
                        var $p = $(this).parent();
                        //console.log("select to tree " + $(this).attr("id"))
                        $(this).select2ToTree({
                            dropdownParent: $p
                        });
                        $(this).width("100%")
                    });

                }

            )
        });
    </script>

