$( document ).ready(function() {
    waveJsModal= new  WaveJsModal()

    var frmHtml="<form id='dynamicWaveMainFrm'>" + $("#idWaveMainFrm").html() + "</form>";

    frmHtml= frmHtml.replaceAll("UNIQUE","")


    function waveucfirst(str) {
        var firstLetter = str.slice(0,1);
        return firstLetter.toUpperCase() + str.substring(1);
    }

    jQuery.waveAjax=function waveAjax(ajaxUrl,formData, fnCallback ,refreshListAndCloseModal=true) {
        $('.spinner').removeClass('d-none');
        jQuery.post( ajaxUrl, {"formData": formData},
            function (response) {

                fnCallback(response);
              if (refreshListAndCloseModal)  $('.modal').modal('hide');
                $('.spinner').addClass('d-none');
            }).fail(function (response) {
                alert(response.responseText )
            $('.spinner').addClass('d-none');

        });
    }
    //////////////////// ADD
    $(".btnWaveAddRecord").on("click", function (e){
        //var deleteId=$(this).parents(".waverecord").data("id")
        var saveTable=$("#idWaveMainFrm").data("table")
        jQuery.waveDisplayFormAdd(saveTable)
    })
    jQuery.waveDisplayFormAdd=  function waveDisplayFormAdd(table  ) {

        waveJsModal.showModal("Add",frmHtml, "Cancel", "Save and Close")
        $("textarea").summernote();

        $( document ).trigger( "waveOpenModal");

        $("#btnModalOk").on('click', function(event) {waveClickEventSave(  table, null)} );;
        $("#btnModalSaveAndContinueEdit").on('click', function(event) {waveClickEventSave(  table, null,false)} );;
    }
    //////////////////// //DELETE
    $(".waveMainGrid").on("click",".delete" ,function (e){
        var deleteId=$(this).parents(".waverecord").data("id")
        var deleteTable=$(this).parents(".waveGridTable").data("table")
        jQuery.waveConfirmDelete(deleteTable,deleteId )

    })
    jQuery.waveConfirmDelete=  function waveConfirmDelete(table, id ) {
        waveJsModal.showModal("Suppression","Etes vous sur de bien vouloir supprimer cet enregistrement", "No", "Delete",null)
        $("#btnModalOk").on('click',function(event) {
            var ajaxUrl =  "./" + table + "/delete/" + id;
            jQuery.waveAjax(ajaxUrl, null,
                function (response){                 jQuery.waveDisplayList( table)}
            );
        } );

    }


    //////////////////////EDIT
    $(".waveMainGrid").on("click",".edit" ,function (e){
        var updateId=$(this).parents(".waverecord").data("id")
        var updateTable=$(this).parents(".waveGridTable").data("table")
        jQuery.waveDisplayForm(updateTable,updateId ,updateId)
    });
    $(".waveMainGrid").on("click",".duplicate" ,function (e){
        var updateId=$(this).parents(".waverecord").data("id")
        var updateTable=$(this).parents(".waveGridTable").data("table")
        jQuery.waveDisplayForm(updateTable,updateId )
    });


    jQuery.waveDisplayForm=function waveDisplayForm(updateTable ,updateId=null, updateSaveId=null) {


            var ajaxUrl =  "./" + updateTable + "/get/" + updateId;
        var modalTitle="Update ";
        if (updateSaveId === null ) modalTitle =" Duplicate ";
        jQuery.post( ajaxUrl, {"formData": null},
            function (response) {

                // console.log(frmHtmlNevez)

                waveJsModal.showModal(modalTitle + updateTable,frmHtml, "Cancel", "Save and Close")

                // $('.nav-tabs li a').click(function (e) {
                //     e.preventDefault();
                //     console.log( $(this).tab)
                //
                //     $(this).tab('show');
                // });

                $("#btnModalOk").on('click' ,function(event) {  waveClickEventSave(  updateTable, updateSaveId)    } );
                $("#btnModalSaveAndContinueEdit").on('click' ,function(event) {  waveClickEventSave(  updateTable, updateSaveId, false)    } );
                var responJSON = JSON.parse(response)
                for (var key in responJSON) {
                    if (responJSON.hasOwnProperty(key)) {
                       // console.log( "#waveInput" +waveucfirst(key) + " -> " + responJSON[key]);
                        $("#dynamicWaveMainFrm #waveInput" + waveucfirst(key)).val(responJSON[key])

                    }
                }
                $( document ).trigger( "waveOpenModal");
                $("textarea").summernote();

                jQuery.waveDisplayList( updateTable)
                $('.spinner').addClass('d-none');


            }).fail(function () {
            $('.spinner').addClass('d-none');

        });
    };


    //////////////////// //LIST
   jQuery.waveDisplayList=function waveDisplayList(table ,
                                                   withHeaders=false ,
                                                   refreshListAndCloseModal=true,
                                                   arrDefaultState=null
   ) {
        var gridElement = $(".waveMainGrid tbody")
     var ajaxUrl =  "./"+ table + "/maingrid";
        var sortField=$(this).find(".waveSortArrow.active")
       var sortCol=$(sortField).parents('th')
       var fieldOrder=$(sortCol).data("field")
       var fieldOrderDir=$(sortField).data("orderdirection")
      // if (fieldOrder === undefined)  fieldOrder="title"
      //  if (fieldOrderDir === undefined)    fieldOrderDir="asc"
       //  var withHeaders =false;
       //
       // if (sortCol.length==0) {
       //     gridElement=$(".waveMainGrid");
       //     withHeaders = true;
       // }
       //
       if (withHeaders)  gridElement=$(".waveMainGrid");
       var filterFormData = $('.waveFrmFilter').serializeArray();


           const url = new URL(window.location);

           // console.log(arrDefaultState);
           // console.log(filterFormData)

       if (arrDefaultState)
           $.each(arrDefaultState, function (arrDefaultStateKey, arrDefaultStateValue) {

               filterFormData.push ( {
                   name: arrDefaultStateKey,
                   value: arrDefaultStateValue
               })
           })


           $.each(filterFormData, function (key, value) {
               if (value.value) {
                   // console.log(value.name + " " + value.value)
                   url.searchParams.set(value.name, value.value);
               }
               else    url.searchParams.delete(value.name)
           });
           window.history.pushState({}, null, url);

       var formData= {
            page:1,
            limit:20,
            order:fieldOrder,
            orderDir:fieldOrderDir,
            withHeaders:withHeaders,
            filter:filterFormData
        }
       jQuery.waveAjax(ajaxUrl, formData,
           function (response){
           gridElement.html(response);
           inputDateRangeFilter();
               setTooltips();
               if (arrDefaultState)
               {
                   $.each(arrDefaultState, function (key, value) {

                       $('input[name="' + key + '"], select[name="' + key + '"]' ).val(value)
                   })
               }

       },refreshListAndCloseModal)
 }

 ///////// LIST SORT
    $(".waveMainGrid").on("click",".waveSortArrow" ,function (e){
        $(this).parents("tr").find(".waveSortArrow").removeClass("active");
        $(this).toggleClass("active");
        var sortTable=$(this).parents(".waveGridTable").data("table")
        jQuery.waveDisplayList( sortTable)
    });
    //////// LIST FILTER
    $(".waveMainGrid").on("click",".btn.filter" ,function (e){
         $("tr.filter").toggleClass("d-none")
    });
    $(".waveMainGrid").on("change","tr.filter input, tr.filter select" ,function (e){
        var sortTable=$(this).parents(".waveGridTable").data("table")
        jQuery.waveDisplayList( sortTable)

        console.log("filter");
    });
    ////////////////////SAVE
    function waveClickEventSave(table, id, refreshListAndCloseModal=true) {
        $('.spinner').removeClass('d-none');
        var formData = $('#dynamicWaveMainFrm').serialize();
        //console.log("Save " + table + " / " +  formData  )

        var ajaxUrl = "./" + table + "/save";
        if (id) ajaxUrl = ajaxUrl + "/" + id;


        jQuery.waveAjax(ajaxUrl, formData,
            function (response){
            console.log("saved id :  " + response)
                $("#btnModalSaveAndContinueEdit,#btnModalOk").off();
                $("#btnModalOk").on('click', function(event) {waveClickEventSave(  table, response)} );;

                $("#btnModalSaveAndContinueEdit").on('click', function(event) {waveClickEventSave(  table, response,false)} );;

                jQuery.waveDisplayList( table,false,refreshListAndCloseModal)}
        ,refreshListAndCloseModal);

    }

//////////// input date range filter
function inputDateRangeFilter() {
        //console.log("inputdateRangeFilter")
    var dateFilterElement=$('.waveFrmFilter input.waveInputDate');
    dateFilterElement.daterangepicker({
        "autoApply": true,      autoUpdateInput: false,

        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
        },
        "alwaysShowCalendars": true
    }, function (element,start, end, label) {
        // console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
    });

    dateFilterElement.on('apply.daterangepicker', function(ev, picker) {
        console.log("hello")
        $(this).val(picker.startDate.format('MM/DD/YYYY') + '-' + picker.endDate.format('MM/DD/YYYY'));
     //   var elmtID = picker.element.attr("id");
        $(this).trigger("change");
    });
}
function setTooltips()
{
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
}



});
