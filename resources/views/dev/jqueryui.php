
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>qsdfqdsdf</title>
    <script src="https://unpkg.com/@tabler/core@latest/dist/js/tabler.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/@tabler/core@latest/dist/css/tabler.min.css">


    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>


    <!-- DATE RANGE PICKER-->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <!-- COLOR PICKER -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/mdbassit/Coloris@latest/dist/coloris.min.css"/>
    <script src="https://cdn.jsdelivr.net/gh/mdbassit/Coloris@latest/dist/coloris.min.js"></script>
    <!-- COLOR SELECT -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.27.1/slimselect.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.27.1/slimselect.min.css" rel="stylesheet"></link>

    <!--SUMMERNOTE WYSIWYG EDITOR-->
    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>


    <!-- JQUERY EASY UI-->
    <link rel="stylesheet" type="text/css" href="/20220117/wave1/public/ijss/jquery-easyui-1.10.2/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="/20220117/wave1/public/ijss/jquery-easyui-1.10.2/themes/icon.css">

    <script type="text/javascript" src="/20220117/wave1/public/ijss/jquery-easyui-1.10.2/jquery.easyui.min.js"></script>
    <!-- WAVE FUNCTIONS -->

    <script src="/20220117/wave1/public/ijss/waveJsModal.js"></script>
    <script src="/20220117/wave1/public/ijss/waveEvents.js"></script>
    <link rel="stylesheet" href="/20220117/wave1/public/ijss/wave.css">
</head>
<body>
<select id="cc" class="easyui-combotree" style="width:200px;"  data-options="url:'/20220117/wave1/public/ijss/jquery-easyui-1.10.2/demo/combotree/tree_data1.json',method:'get',label:'Select Node:',labelPosition:'top'" >
</select>


<select id="ccc" value="01" class="easyui-combotree" style="width:200px;" ></select>
<script>
    $( document ).ready(function() {
    //     $('#ccc').combotree({
    //     url: '/20220117/wave1/public/ijss/jquery-easyui-1.10.2/demo/combotree/tree_data1.json',
    //     required: true
    // });
        $('#ccc').combotree('loadData', [{
            id: 1,
            text: 'Languages',
            children: [{
                id: 11,
                text: 'Java'
            },{
                id: 12,
                text: 'C++'
            }]
        }]);


    });
</script>


</body></html>
